<?php 
/**
* CORE NODE
*/
class Defaults
{
    function Index(){
        echo 'helloworld';
    }

    function Missing(){
        header('HTTP/1.1 404 Not Found');
        echo '404';
    }

    function Offline(){
        header('HTTP/1.1 503 Service Temporarily Unavailable');
        echo '503 OFFLINE';
    }

    function NoJS(){
        echo 'NO JS';
    }
}
?>