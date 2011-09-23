<?php
namespace Config;

if (! defined ( 'SECURE' ))
    exit ( 'Hello, security@networks.co.id' );
    
/**
* CONFIG NODES
* highest node from bottom to above, they will
* win if there is the same route on node __init__.php
* FALSE = OFFLINE, 503 Error, TRUE = ONLINE, run Node
*/
Class Apps
{
    public function register()
    {
        $nodes = array(
            'default'   => TRUE,
            'netcoid'   => TRUE,
            'admin'     => TRUE,
        );
        
        return $nodes;
    }
}
?>