<?php 
namespace Config;

if (!defined('SECURE'))
    exit('Hello, security@networks.co.id');
    
/**
* CONFIG Application
* Basic configuration
*/
Class Engine
{
    public function register()
    {
        $config = array(
            'folder' 		=> '',
            'development'	=> TRUE
        );
        
        return $config;
    }
}
?>