<?php
namespace Engine;

if (!defined('SECURE'))
    exit('Hello, security@networks.co.id');

class Red
{
    protected function lib($library) {
       
        if (file_exists ( 'engine/libraries/lib.' . $library . '.php' )) {

            include 'engine/libraries/lib.' . $library . '.php';
            $class = ucfirst ( $library );
            
            if (class_exists ( $class ) && ! property_exists ( $this, $library )) {
                $this->$library = new $class ();
                return TRUE;
            }

            if (class_exists ( $class ) && ! property_exists ( $this, $library )) {
                throw new Exception("ENGINE: LIB MISSING #1");
            }
        }
    }
}
?>