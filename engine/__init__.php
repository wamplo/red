<?php

if (! defined ( 'SECURE' ))
	exit ( 'Hello, security@networks.co.id' );

function __autoload_Engine($class){
    $class = ltrim($class, '\\');
    $file  = NULL;
    $namespace = NULL;

    if ($lastNsPos = strripos($class, '\\')) {
        $namespace = substr($class, 0, $lastNsPos);
        $class = substr($class, $lastNsPos + 1);
        $file  = str_replace('\\', DS, $namespace) . DS;
    }

    $file .= str_replace('_', DS, $class) . '.php';
    $file = strtolower($file);
    var_dump($file);
    if ( file_exists ( $file )) {
        include_once $file;
    }

    if ( !file_exists ( $file )) {

        throw new Exception("Engine: Cant load: at <code>$file</code> class <code>$class</code> on <code>$namespace</code> namespace");
    }
}

spl_autoload_register('__autoload_Engine');
date_default_timezone_set('Asia/Jakarta');

/**
 * return translate
 * @version 100.20/3/2011
 * @package ENGINE/BOOTSTRAP
 * @param string $language
 * @author rama@networks.co.id
 * @tutorial wiki/missing.txt
 */
function l($language) {
    require 'languages/indonesia.php';
    return $l [$language];
}
?>