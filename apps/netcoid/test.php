<?php 
if (!defined('SECURE'))
    exit('Hello, security@networks.co.id');

class Test
{
    /**
     * /INDEX
     * INDEX Page
     * @author Adam Ramadhan
     * @version 1
     **/
    public function Index(){
        echo 'helloworld';
    }

    /**
     * /404
     * 404 Page
     * @author Adam Ramadhan
     * @version 1
     **/
    public function Missing(){
        header('HTTP/1.1 404 Not Found');
        echo '404';
    }

    /**
     * /503
     * 503 Page
     * @author Adam Ramadhan
     * @version 1
     **/
    public function Offline(){
        header('HTTP/1.1 503 Service Temporarily Unavailable');
        echo '503 OFFLINE';
    }

    /**
     * /NOJS
     * NOJS Page
     * @author Adam Ramadhan
     * @version 1
     **/
    public function NoJS(){
        echo 'NO JS';
    }
}
?>