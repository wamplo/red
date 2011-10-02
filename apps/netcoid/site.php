<?php 

use Engine\libraries\Assets;
use Engine\libraries\RedRiver;
use Engine\libraries\Memcached;
use Engine\libraries\Social;
use Engine\libraries\Forms;
use Engine\libraries\Sessions;
use Engine\libraries\Flash;

class Site Extends Engine\Red
{
    public $a;
    public $r;

    public function __construct(){
        $this->a = new Assets;
        $this->r = new RedRiver;
        $this->e = new Sessions;
    }


    /**
     * netcoid.com
     * Index Page Netcoid
     * @author Adam Ramadhan
     * @version 1
     **/
    public function Index(){
        $this->__Header();

        $this->r->branch(array(
            'src' => 
                array(
                    'html' => $this->a->getView('netcoid','site/sitedev.php'),
                    'id' => 'rr-2'
                ),
            'css' => 
                array(
                    $this->a->getPath('default','css/framework.css'),
                    $this->a->getPath('netcoid','css/main.v2.css'),
                    $this->a->getPath('netcoid','css/signup.css'),
                    $this->a->getPath('netcoid','css/buttons.css')
                ),
            'cache' => 0
        ));

        $this->__Footer();
    }

    /**
     * netcoid.com/signup
     * Signup Page Netcoid
     * @author Adam Ramadhan
     * @version 1
     **/
    public function Signup(){
        
        $this->__Header();

        $signupdata = array(
            'forms' => new Forms
        );

        $this->r->branch(array(
        'src' => 
            array(
                #'html' => $this->a->getView('netcoid','site/sitedev.php',$signupdata),
                'html' => $this->a->getView('netcoid','site/signup.php',$signupdata),
                'id' => 'rr-2'
            ),
        'css' => 
            array(
                $this->a->getPath('default','css/framework.css'),
                $this->a->getPath('netcoid','css/main.v2.css'),
                $this->a->getPath('netcoid','css/signup.css'),
                $this->a->getPath('netcoid','css/buttons.css')
            ),
        'js' =>
            array(
                array(
                    $this->a->getPath('netcoid','js/jquery/jquery.validation.js'),
                    $this->a->getPath('netcoid','js/jquery/jquery.example.js')
                ),
                array(
                    $this->a->getPath('netcoid','js/signup.js')               
                )
            ),
        'cache' => 0
        ));

        $this->__Footer();
    }

    /**
     * www.networks.co.id/search
     * Search Page Netcoid
     * @author Adam Ramadhan
     * @version 1
     **/
    public function Search(){

        $g = new Apps\Netcoid\Models\Groups;
        
        $t = $g->getSearch();

        # http://stackoverflow.com/questions/4452472/category-hierarchy-php-mysql
        $list = array();
        foreach ($t as $value) {
            $thisref = &$refs[ $value['GID'] ];
            $thisref['parent_GID'] = $value['parent_GID'];
            $thisref['GID'] = $value['GID'];

            $thisref['name'] = $value['name'];
            if ($value['parent_GID'] == NULL) {
                $list[ $value['GID'] ] = &$thisref;
            } else {
                $refs[ $value['parent_GID'] ]['children'][ $value['GID'] ] = &$thisref;
            }
        }

        $searchdata = array(
            'g' => $list
        );

        $this->__Header();

        # SHOW FLASH
        $h = new Flash;
        $h->showAll();

        $this->r->branch(array(
        'src' => 
            array(
                'html' => $this->a->getView('netcoid','Site/Search2.php',$searchdata),
                'id' => 'rr-2'
            ),
        'css' => 
            array(
                $this->a->getPath('default','css/framework.css'),
                $this->a->getPath('netcoid','css/main.v2.css'),
                $this->a->getPath('netcoid','css/signup.css'),
                $this->a->getPath('netcoid','css/buttons.css')
            ),
        'cache' => 0
        ));

        $this->__Footer();
    }

    /**
     * www.networks.co.id/development
     * Search Page Netcoid
     * @author Adam Ramadhan
     * @version 1
     **/
    public function Development(){
        $this->__Header();

        $devdata = array(
            'start' => 'something'
        );

        $this->r->branch(array(
            'src' => 
                array(
                    'html' => $this->a->getView('netcoid','Site/Development.php', $devdata),
                    'id' => 'rr-2'
                ),
            'css' => 
                array(
                    $this->a->getPath('default','css/framework.css'),
                    $this->a->getPath('netcoid','css/main.v2.css')
                ),
            'cache' => 0
        ),1); # START
        $this->__Footer();
    }

    /**
     * FRAMEWORK __HEADER
     * @author Adam Ramadhan
     * @version 1 + PJAX
     **/
    private function __Header($title = 'Netcoid &mdash; jejaring bisnis indonesia', $desc = 'Netcoid, jejaring bisnis indonesia, menghubungkan pelaku bisnis indonesia'){

        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == "XMLHttpRequest" ) {
            

            # AN AJAX REQUEAST && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == $request 
            # var_dump($_SERVER);
            
        } else {    
            echo $this->a->getView('netcoid','framework/header.php',
                array(
                    'title' => $title,
                    'description' => $desc 
                )
            );

            $o = new Apps\Netcoid\Models\Mentions;
            $m = new Apps\Netcoid\Models\Messages;

            $menudata = array(
                'sessions' => $this->e,
                'countmentions' => $o->countMentionUID($this->e->get('uid')),
                'countmessages' => $m->countMessageUID($this->e->get('uid'))
            );
            
            $this->r->branch(array(
                'src' => 
                    array(
                        'html' => $this->a->getView('netcoid','framework/menu.php', $menudata),
                        'id' => 'rr-1'
                    ),
                'css' => 
                    array(
                        $this->a->getPath('default','css/framework.css'),
                        $this->a->getPath('netcoid','css/main.v2.css')
                    ),
                'cache' => 0
            ),0); # START
        }
    }

    /**
     * FRAMEWORK __FOOTER
     * @author Adam Ramadhan
     * @version 1
     **/
    private function __Footer(){
        $this->r->branch(array(
        'src' => 
            array(
                'html' => $this->a->getView('netcoid','framework/bottom.php'),
                'id' => 'rr-3'
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