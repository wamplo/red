<?php 
/**
* CORE NODE
*/

use Engine\libraries\Assets;
use Engine\libraries\RedRiver;
use Engine\libraries\Memcached;
use Engine\libraries\Social;
use Engine\libraries\Forms;
use Engine\libraries\Sessions;
use Engine\libraries\Pagination;
use Engine\libraries\Flash;

class Profiles Extends Engine\Red
{
    public $a, $r, $e;

    public function __construct(){
        $this->a = new Assets;
        $this->r = new RedRiver;
        $this->e = new Sessions;
        $this->i = new Pagination;
        $this->h = new Flash;

        $this->u = new Apps\Netcoid\Models\Users;
    }


    private function __securitycheck($username){
        if (!$this->u->getData($username)) {
            header('HTTP/1.1 404 Not Found');
            echo '404';
            die();
        }
    }

    /**
     * www.networks.co.id/(username)/Posts
     * Search Page Netcoid
     * @author Adam Ramadhan
     * @version 1
     **/
    public function Posts($username){
        $this->__securitycheck($username);

        $p = new Apps\Netcoid\Models\Posts;

        $this->__Header();

        $userdata = $this->u->getData($username);
        
        $postdata = array(
            'user' => $userdata,
            'posts' => $p->getPostbyUID($userdata['uid'], 20, $this->i->curroffset),
            'pagination' => $this->i,
            'login' => $this->e->get('uid')
        );

        $this->i->maxperpage = 20;
        $this->i->totalrow = $p->CountPostsbyUID($userdata['uid']);
        $this->i->currrow = count($postdata['posts']);

        $this->r->branch(array(
            'src' => 
                array(
                    'html' => $this->a->getView('netcoid','Profiles/Posts.php',$postdata),
                    'id' => 'rr-2'
                ),
            'css' => 
                array(
                    $this->a->getPath('default','css/framework.css'),
                    $this->a->getPath('netcoid','css/main.v2.css'),
                    $this->a->getPath('netcoid','css/profile.css'),
                    $this->a->getPath('netcoid','css/pagination.css')
                ),
            'cache' => 0
        ),1); # START

        $this->__Footer();
    }

    /**
     * www.networks.co.id/(username)/Offers
     * Search Page Netcoid
     * @author Adam Ramadhan
     * @version 1
     **/
    public function Offers($username){
        $this->__securitycheck($username);

        $p = new Apps\Netcoid\Models\Posts;

        $this->__Header();

        $userdata = $this->u->getData($username);
        $offerdata = array(
            'user' => $userdata,
            'posts' => $p->getPostbyUID($userdata['uid'], 20, $this->i->curroffset,1),
            'pagination' => $this->i,
            'login' => $this->e->get('uid')
        );

        $this->i->maxperpage = 20;
        $this->i->totalrow = $p->CountPostsbyUID($userdata['uid'],1);
        $this->i->currrow = count($offerdata['posts']);

        $this->r->branch(array(
            'src' => 
                array(
                    'html' => $this->a->getView('netcoid','Profiles/Offers.php',$offerdata),
                    'id' => 'rr-2'
                ),
            'css' => 
                array(
                    $this->a->getPath('default','css/framework.css'),
                    $this->a->getPath('netcoid','css/main.v2.css'),
                    $this->a->getPath('netcoid','css/profile.css'),
                    $this->a->getPath('netcoid','css/pagination.css')
                ),
            'cache' => 0
        ),1); # START

        $this->__Footer();
    }

    /**
     * www.networks.co.id/(username)/Requests
     * Search Page Netcoid
     * @author Adam Ramadhan
     * @version 1
     **/
    public function Requests($username){
        $this->__securitycheck($username);

        $p = new Apps\Netcoid\Models\Posts;

        $this->__Header();

        $userdata = $this->u->getData($username);
        $offerdata = array(
            'user' => $userdata,
            'posts' => $p->getPostbyUID($userdata['uid'], 20, $this->i->curroffset,2),
            'pagination' => $this->i,
            'login' => $this->e->get('uid')
        );

        $this->i->maxperpage = 20;
        $this->i->totalrow = $p->CountPostsbyUID($userdata['uid'],2);
        $this->i->currrow = count($offerdata['posts']);

        $this->r->branch(array(
            'src' => 
                array(
                    'html' => $this->a->getView('netcoid','Profiles/Offers.php',$offerdata),
                    'id' => 'rr-2'
                ),
            'css' => 
                array(
                    $this->a->getPath('default','css/framework.css'),
                    $this->a->getPath('netcoid','css/main.v2.css'),
                    $this->a->getPath('netcoid','css/profile.css'),
                    $this->a->getPath('netcoid','css/pagination.css')
                ),
            'cache' => 0
        ),1); # START

        $this->__Footer();
    }

    /**
     * www.networks.co.id/(username)
     * Search Page Netcoid
     * @author Adam Ramadhan
     * @version 1
     **/
    public function Index($username){
        $this->__securitycheck($username);

        $this->__Header();

        $this->h->showAll(); # SHOW FLASH
        
        $o = new Apps\Netcoid\Models\Follow;
        $user = $this->u->getData($username);

        $profiledata = array(
            'user' => $user,
            'login' => $this->e->get('uid'),
            'follow' => $o->isFollowingUID($this->e->get('uid'), $user['uid'])
        );

        $this->r->branch(array(
            'src' => 
                array(
                    'html' => $this->a->getView('netcoid','Profiles/Index.php',$profiledata),
                    'id' => 'rr-ajax-profiles'
                ),
            'css' => 
                array(
                    $this->a->getPath('default','css/framework.css'),
                    $this->a->getPath('netcoid','css/main.v2.css'),
                    $this->a->getPath('netcoid','css/profile.css'),
                    $this->a->getPath('netcoid','css/blog.css'),
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

            $menudata = array(
                'sessions' => $this->e
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
                'html' => $this->a->getView('netcoid','Framework/Bottom.php'),
                'id' => 'rr-3'
            ),
        'css' => 
            array(
                $this->a->getPath('default','css/framework.css'),
                $this->a->getPath('netcoid','css/main.v2.css')
            ),
         'cache' => 0
        ),2); # END

        echo $this->a->getView('netcoid','Framework/Footer.php');
    }
}
?>