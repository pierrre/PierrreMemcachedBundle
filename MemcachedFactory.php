<?php

namespace Pierrre\MemcachedBundle;

class MemcachedFactory
{
    public function get(array $config)
    {
        $persistentId = isset($config['persistent_id']) ? $config['persistent_id'] : null;
        $memcached = new \Memcached($persistentId);

        if ($this->isInitializationRequired($memcached)) { //Re use persistent instance
            $this->initialize($memcached, $config);
        }

        return $memcached;
    }

    private function isInitializationRequired(\Memcached $memcached)
    {
        return count($memcached->getServerList()) == 0;
    }

    private function initialize(\Memcached $memcached, array $config)
    {
        $this->addServers($memcached, $config);

        $this->setOptions($memcached, $config);
    }

    private function addServers(\Memcached $memcached, array $config)
    {
        if (isset($config['servers'])) {
            foreach ($config['servers'] as $serverConfig) {
                $this->addServer($memcached, $serverConfig);
            }
        }
    }

    private function addServer(\Memcached $memcached, array $serverConfig)
    {
        $memcached->addServer($serverConfig['host'], $serverConfig['port'], isset($serverConfig['weight']) ? $serverConfig['weight'] : null);
    }

    private function setOptions(\Memcached $memcached, array $config)
    {
        if (isset($config['options'])) {
            $memcached->setOptions($config['options']);
        }
    }
}
