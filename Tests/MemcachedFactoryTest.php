<?php

namespace Pierrre\MemcachedBundle\Tests;

use Pierrre\MemcachedBundle\MemcachedFactory;

class MemcachedFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers \Pierrre\MemcachedBundle\MemcachedFactory::get
     */
    public function testGetInstanceOf()
    {
        $memcachedFactory = new MemcachedFactory();
        $memcached = $memcachedFactory->get(array());
        $this->assertInstanceOf('Memcached', $memcached);
    }
}
