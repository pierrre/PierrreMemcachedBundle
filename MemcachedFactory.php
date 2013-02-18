<?php

namespace Pierrre\MemcachedBundle;

class MemcachedFactory
{
    public function get(array $config)
    {
        $persistentId = isset($config['persistent_id']) ? $config['persistent_id'] : null;
        $memcached = new \Memcached($persistentId);

        if (count($memcached->getServerList()) == 0) { //Re use persistent instance
            if (isset($config['servers'])) {
                foreach ($config['servers'] as $server) {
                    $memcached->addServer($server['host'], $server['port'], isset($server['weight']) ? $server['weight'] : null);
                }
            }

            if (isset($config['options'])) {
                foreach ($config['options'] as $optionName => $optionValue) {
                    $memcached->setOption($optionName, $optionValue);
                }
            }
        }

        return $memcached;
    }
}
