<?php

return array(
    'factories' => array(
        'dbAdapter' => function($sl) {
            $config = $sl->get('config');
            $config = $config['db'];
            $dbAdapter = new Zend\Db\Adapter\Adapter($config);
            
            return $dbAdapter;
        },
        'cacheCart' => function($sl) {
            $config = $sl->get('config');
            $config = $config['cacheCart'];
            $cache = Zend\Cache\StorageFactory::factory($config);
            
            return $cache;
        },
        'cacheDb' => function($sl) {
            $config = $sl->get('config');
            $config = $config['cacheDb'];
            $cache = Zend\Cache\StorageFactory::factory($config);
            
            return $cache;
        },
        'security' => 'Common\Model\Service\Factory\SecurityFactory',
    ),
    'invokables' => array(
    ),
);
