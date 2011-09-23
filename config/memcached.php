<?php 
namespace Config;

if (! defined ( 'SECURE' ))
    exit ( 'Hello, security@networks.co.id' );
    
/**
* CONFIG Memcached
* Memcached configuration
*/
Class Memcached
{
    public function registerMaster()
    {
        $config = array(
			'host'		 =>	'127.0.0.1',
			'port'		 => '11211'
        );

        return $config;
    }
 
    public function registerSlave()
    {
        $config = array(
			'host'		 =>	'127.0.0.2',
			'port'		 => '11211'
        );

        return $config;
    }
}
?>