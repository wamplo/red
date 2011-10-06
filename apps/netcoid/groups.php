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

class Groups Extends Engine\Red
{
    public $a, $r, $e;

    public function __construct(){
        $this->a = new Assets;
        $this->r = new RedRiver;
        $this->e = new Sessions;

        $this->g = new Apps\Netcoid\Models\Groups;
        $this->p = new Apps\Netcoid\Models\Posts;

        $this->u = new Apps\Netcoid\Models\Users;
        $this->i = new Pagination;
        $this->h = new Flash;
    }

    /**
     * www.networks.co.id/skel
     * Search Page Netcoid
     * @author Adam Ramadhan
     * @version 1
     **/
    public function Index(){

        $o = new Apps\Netcoid\Models\Follow;
        $indexdata = array(
            'user'  => $this->u->getData($this->e->get('uid')),
            'status' => $this->__checkGroup(),
            'info'  => $this->g->getGroup($_GET['id']),
            'posts' => $this->p->getPostsbyGroup($_GET['id'], 20, $this->i->curroffset),
            'pagination' => $this->i,
            'login' => $this->e->get('uid'),
            'follow' => $o->isFollowingGID($this->e->get('uid'), $_GET['id'])
        );

        $this->__Header('Netcoid &mdash; ' . $indexdata['info']['name']);  
        $this->h->showAll();

        $this->i->maxperpage = 20;
        $this->i->totalrow = $this->p->CountPostsbyGroup($_GET['id']);
        $this->i->currrow = count($indexdata['posts']);
        
        $this->r->branch(array(
            'src' => 
                array(
                    'html' => $this->a->getView('netcoid','Groups/Index.php',$indexdata),
                    'id' => 'rr-2'
                ),
            'css' => 
                array(
                    $this->a->getPath('default','css/framework.css'),
                    $this->a->getPath('netcoid','css/main.v2.css'),
                    $this->a->getPath('netcoid','css/groups.css'),
                    $this->a->getPath('netcoid','css/pagination.css')
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
    private function __checkGroup(){

        $status = $this->g->getStatusbyGID($_GET['id']);

        switch ($status) {

            case 1:
                $active = array(
                  'status' => 1,
                    'permission'=> array(
                        'post' => true,
                        'offer' => true,
                        'request' => true,
                        'users' => array(
                            5 # ADMIN
                        )
                    )
                );
                break;
 
            case 2:
                $active = array(
                    'status' => 1,
                    'permission'=> array(
                        'post'  => true,
                        'offer' => true,
                        'request' => true,
                        'users' => array(
                            5, #ADMIN
                            0  # UNVERIFIED
                        )
                    )
                );
                break;

            case 3:
                $active = array(
                  'status' => 1,
                    'permission'=> array(
                        'post'  => true,
                        'offer' => false,
                        'request' => false,
                        'users' => array(
                            5, #ADMIN
                            0  # UNVERIFIED
                        )
                    )
                );
                break;

            case 4:
                $active = array(
                  'status' => 1,
                    'permission'=> array(
                        'post'  => false,
                        'offer' => true,
                        'request' => true,
                        'users' => array(
                            5, #ADMIN
                            0  # UNVERIFIED
                        )
                    )
                );
                break;
 
             case 5:
                $active = array(
                  'status' => 0,
                    'permission'=> array(
                        'post'  => false,
                        'offer' => false,
                        'request' => false,
                        'users' => array(
                            NULL
                        )
                    )
                );
                break;
                                          
            default:
                    die('security@networks.co.id');
                break;
        }

        return $active;
    }
}
?>