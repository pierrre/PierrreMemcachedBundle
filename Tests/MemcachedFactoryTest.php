<?php

namespace Pierrre\MemcachedBundle\Tests;

use Pierrre\MemcachedBundle\MemcachedFactory;

class MemcachedFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers \Pierrre\MemcachedBundle\MemcachedFactory::get
     * @covers \Pierrre\MemcachedBundle\MemcachedFactory::isInitializationRequired
     * @covers \Pierrre\MemcachedBundle\MemcachedFactory::initialize
     * @covers \Pierrre\MemcachedBundle\MemcachedFactory::addServers
     * @covers \Pierrre\MemcachedBundle\MemcachedFactory::addServer
     * @covers \Pierrre\MemcachedBundle\MemcachedFactory::setOptions
     */
    public function testGet()
    {
        $memcachedFactory = new MemcachedFactory();
        $memcached = $memcachedFactory->get(array(
            'servers' => array(
                array(
                    'host' => 'localhost',
                    'port' => '11211'
                )
            ),
            'options' => array(
                \Memcached::OPT_COMPRESSION => true
            )
        ));
        $this->assertInstanceOf('Memcached', $memcached);
    }

    /**
     * @coversNothing
     */
    public function testPersistentConnection()
    {
        $memcachedFactory = new MemcachedFactory();

        $config = array(
            'persistent_id' => 'test',
            'servers' => array(
                array(
                    'host' => 'localhost',
                    'port' => '11211'
                )
            )
        );

        $memcached = $memcachedFactory->get($config);
        $totalConnectionsStart = array_pop($memcached->getStats())['total_connections'];

        for ($i = 0; $i < 10; $i++) {
            $memcachedFactory->get($config);
        }
        $totalConnectionsEnd = array_pop($memcached->getStats())['total_connections'];

        $this->assertEquals($totalConnectionsStart, $totalConnectionsEnd);
    }

    /**
     * @coversNothing
     */
    public function testNonPersistentConnection()
    {
        $memcachedFactory = new MemcachedFactory();

        $config = array(
            'servers' => array(
                array(
                    'host' => 'localhost',
                    'port' => '11211'
                )
            )
        );

        $memcached = $memcachedFactory->get($config);
        $totalConnectionsStart = array_pop($memcached->getStats())['total_connections'];

        for ($i = 0; $i < 10; $i++) {
            $memcachedFactory->get($config);
        }
        $totalConnectionsEnd = array_pop($memcached->getStats())['total_connections'];

        $this->assertGreaterThan($totalConnectionsStart, $totalConnectionsEnd);
    }
}
