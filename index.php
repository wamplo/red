<?php 
$start = microtime();

define ( 'SECURE', TRUE );
define ( 'DS', '/' );

include_once __DIR__ . '/engine/__init__.php';

# BOOTSTRAP
try {
    new Engine\Router(
        array(
            'engine' => new Config\Engine,
            'apps'  => new Config\Apps
        )
    );
} catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
}

?>