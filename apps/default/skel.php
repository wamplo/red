<?php 
if (!defined('SECURE'))
    exit('Hello, security@networks.co.id');

use Engine\Libraries\Assets;
use Engine\Libraries\RedRiver;
use Engine\Libraries\Memcached;
use Engine\Libraries\Social;
use Engine\Libraries\Forms;
use Engine\Libraries\Sessions;

class Site Extends Engine\Red
{
    public $a, $r, $e;

    /**
     * GLOBAL FUNCTION
     * Dependency load here, if a library is used in more then
     * 2 Function put it here too, dont forget to put a private var
     * above
     * @author Adam Ramadhan
     * @version 1
     **/
    public function __construct(){
        $this->a = new Assets;
        $this->r = new RedRiver;
        $this->e = new Sessions;
    }

    /**
     * www.networks.co.id/skel
     * Search Page Netcoid
     * @author Adam Ramadhan
     * @version 1
     **/
    public function Skel(){
        $this->__Header();
        echo "skel";
        $this->__Footer();
    }

    /**
     * FRAMEWORK __HEADER
     * Header Element
     * @author Adam Ramadhan
     * @version 1
     **/
    private function __Header(){
        echo $this->a->getView('netcoid','framework/header.php',
            array(
                'title' => 'Netcoid &mdash; jejaring bisnis indonesia',
                'description' => 'Netcoid, jejaring bisnis indonesia, menghubungkan pelaku bisnis indonesia' 
            )
        );

        $menudata = array(
            'sessions' => $this->e
        );

        $this->r->branch(array(
            'src' => 
                array(
                    'html' => $this->a->getView('netcoid','framework/menu.php', $menudata),
                    'id' => 'rr-ajax-menu'
                ),
            'css' => 
                array(
                    $this->a->getPath('default','css/framework.css'),
                    $this->a->getPath('netcoid','css/main.v2.css')
                ),
            'cache' => 0
        ),0); # START
    }

    /**
     * FRAMEWORK __FOOTER
     * Footer Element
     * @author Adam Ramadhan
     * @version 1
     **/
    private function __Footer(){
        $this->r->branch(array(
        'src' => 
            array(
                'html' => $this->a->getView('netcoid','framework/bottom.php'),
                'id' => 'rr-ajax-footer'
            ),
        'css' => 
            array(
                $this->a->getPath('default','css/framework.css'),
                $this->a->getPath('netcoid','css/main.v2.css')
            ),
         'cache' => 0
        ),2); # END

        echo $this->a->getView('netcoid','framework/footer.php');
    }
}
?>