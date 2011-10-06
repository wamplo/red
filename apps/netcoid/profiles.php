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
        $o = new Apps\Netcoid\Models\Follow;

        $userdata = $this->u->getData($username);
             
        $this->__Header($userdata['name'] . ' &mdash; Posts');
        $this->h->showAll(); # SHOW FLASH

        $postdata = array(
            'user' => $userdata,
            'follow' => $o->isFollowingUID($this->e->get('uid'), $userdata['uid']),
            'posts' => $p->getPostbyUID($userdata['uid'], 20, $this->i->curroffset),
            'pagination' => $this->i,
            'login' => $this->e->get('uid'),
            'ispost0' => $p->getPostbyUID($userdata['uid'], 1, $this->i->curroffset),
            'ispost1' => $p->getPostbyUID($userdata['uid'], 1, $this->i->curroffset,1),
            'ispost2' => $p->getPostbyUID($userdata['uid'], 1, $this->i->curroffset,2)
        );

        $this->i->maxperpage = 20;
        $this->i->totalrow = $p->CountPostsbyUID($userdata['uid']);
        $this->i->currrow = count($postdata['posts']);

        $this->r->branch(array(
            'src' => 
                array(
                    'html' => $this->a->getView('netcoid','profiles/posts.php',$postdata),
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
        $o = new Apps\Netcoid\Models\Follow;

        $userdata = $this->u->getData($username);

        $this->__Header($userdata['name'] . ' &mdash; Penawaran');
        $this->h->showAll(); # SHOW FLASH

        $offerdata = array(
            'user' => $userdata,
            'follow' => $o->isFollowingUID($this->e->get('uid'), $userdata['uid']),
            'posts' => $p->getPostbyUID($userdata['uid'], 20, $this->i->curroffset,1),
            'pagination' => $this->i,
            'login' => $this->e->get('uid'),
            'ispost0' => $p->getPostbyUID($userdata['uid'], 1, $this->i->curroffset),
            'ispost1' => $p->getPostbyUID($userdata['uid'], 1, $this->i->curroffset,1),
            'ispost2' => $p->getPostbyUID($userdata['uid'], 1, $this->i->curroffset,2)
        );

        $this->i->maxperpage = 20;
        $this->i->totalrow = $p->CountPostsbyUID($userdata['uid'],1);
        $this->i->currrow = count($offerdata['posts']);

        $this->r->branch(array(
            'src' => 
                array(
                    'html' => $this->a->getView('netcoid','profiles/posts.php',$offerdata),
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
        $o = new Apps\Netcoid\Models\Follow;

        $userdata = $this->u->getData($username);

        $this->__Header($userdata['name'] . ' &mdash; Permintaan');
        $this->h->showAll(); # SHOW FLASH

        $offerdata = array(
            'user' => $userdata,
            'follow' => $o->isFollowingUID($this->e->get('uid'), $userdata['uid']),
            'posts' => $p->getPostbyUID($userdata['uid'], 20, $this->i->curroffset,2),
            'pagination' => $this->i,
            'login' => $this->e->get('uid'),
            'ispost0' => $p->getPostbyUID($userdata['uid'], 1, $this->i->curroffset),
            'ispost1' => $p->getPostbyUID($userdata['uid'], 1, $this->i->curroffset,1),
            'ispost2' => $p->getPostbyUID($userdata['uid'], 1, $this->i->curroffset,2)
        );

        $this->i->maxperpage = 20;
        $this->i->totalrow = $p->CountPostsbyUID($userdata['uid'],2);
        $this->i->currrow = count($offerdata['posts']);

        $this->r->branch(array(
            'src' => 
                array(
                    'html' => $this->a->getView('netcoid','profiles/posts.php',$offerdata),
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

        $o = new Apps\Netcoid\Models\Follow;
        $p = new Apps\Netcoid\Models\Posts;
        $user = $this->u->getData($username);

        $this->__Header($user['name']);
        $this->h->showAll(); # SHOW FLASH

        # @TODO OPTIMASI DATANYA
        $profiledata = array(
            'user' => $user,
            'login' => $this->e->get('uid'),
            'follow' => $o->isFollowingUID($this->e->get('uid'), $user['uid']),
            'ispost0' => $p->getPostbyUID($user['uid'], 1, $this->i->curroffset),
            'ispost1' => $p->getPostbyUID($user['uid'], 1, $this->i->curroffset,1),
            'ispost2' => $p->getPostbyUID($user['uid'], 1, $this->i->curroffset,2)
        );

        $this->r->branch(array(
            'src' => 
                array(
                    'html' => $this->a->getView('netcoid','profiles/index.php',$profiledata),
                    'id' => 'rr-2'
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
            
            echo "<title>$title</title>";
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
     * @version 1 + PJAX
     **/
    private function __Footer(){

        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == "XMLHttpRequest" ) {

            # AN AJAX REQUEAST && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == $request 
            # var_dump($_SERVER);
            
        } else { 

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

            echo $this->a->getView('netcoid','Framework/Footer.php');
        }
    }
}
?>