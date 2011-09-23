<?php 
namespace Config;

if (! defined ( 'SECURE' ))
    exit ( 'Hello, security@networks.co.id' );
    
/**
* CONFIG Sessions
* Sessions configuration
* gc_probability/gc_divisor, e.g. 1/100 means there is a 1% chance GC ( garbage collation )
*/
Class Sessions
{
    public function registerConfig()
    {
        $config = array(
            'session_name' => 'NETCOID_SECURE',
            'gc_probability' => '1',
            'gc_divisor' => '100',
            'hash_function' => 'SHA512',
            'gc_maxlifetime' => '1800'
        );

        return $config;
    }
}
?>