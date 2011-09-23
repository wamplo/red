<?php 
$start = microtime();

define ( 'SECURE', TRUE );
define ( 'DS', '/' );

include_once __DIR__ . '/engine/__init__.php';

# TEST
/*
function __autoload($class){
    
    # GET TYPE FROM CLASS NAME
    $data = str_split($class, 6);
    include_once $data[0].DS.$data[1].'.php';     
}
*/

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