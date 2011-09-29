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
use Engine\libraries\Validation;
use Engine\libraries\Flash;

class Posts Extends Engine\Red
{
    public $a, $r, $e;

    public function __construct(){
        $this->a = new Assets;
        $this->r = new RedRiver;
        $this->e = new Sessions;
        $this->v = new Validation;
        $this->f = new Forms;
        $this->h = new Flash;

        $this->p = new Apps\Netcoid\Models\Posts;
        $this->g = new Apps\Netcoid\Models\Groups;
        $this->c = new Apps\Netcoid\Models\Comments;
        $this->u = new Apps\Netcoid\Models\Users;

        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            die('security@networks.co.id');
        }
    }

    public function Delete(){

        # kenapa gak dimasukin ke del aja dll? contoh del(id,user)
        $this->__checkPostUser(); # check if this post is from user

        $this->p->del($_GET['id']);
        $this->c->delbyPID($_GET['id']);
        $this->h->setMessage('Post Deleted');
        header('Location: /search');
    }

    public function Bump(){
        $this->__checkPostUser(); # check if this post is from user
        $postdata = $this->p->getPostbyPID($_GET['id']);
        if (strtotime($postdata['time_bump']) < strtotime('-1 Hour')){

            # GENERATE NEW TIME
            $time = new DateTime(NULL, new DateTimeZone('Asia/Jakarta'));
            $e['time_bump'] = $time->format('Y-m-d H:i:s');
            $e['pid'] = $_GET['id'];

            $this->p->setBump($e);
            $this->h->setMessage('Bumped!');
            header('Location: /post?id='.$_GET['id']); // to post
        }   
    }

    public function editPost(){

        $this->__checkPostUser(); # check if this post is from user
        $postdata = $this->p->getPostbyPID($_GET['id']);
        $this->__processPost($postdata['status'],1); # 0 any, 1 offer, 2 request, 3 ntah.

        $this->__Header();

        $editdata = array(
            'forms' => $this->f,
            'validation' => $this->v,
            'username' => $this->e->get('username'),
            'post' => $postdata
        );

        $this->r->branch(array(
            'src' => 
                array(
                    'html' => $this->a->getView('netcoid','Posts/Edit.php',$editdata),
                    'id' => 'rr-2'
                ),
            'css' => 
                array(
                    $this->a->getPath('default','css/framework.css'),
                    $this->a->getPath('netcoid','css/main.v2.css'),
                    $this->a->getPath('netcoid','css/forms.css'),
                    $this->a->getPath('netcoid','css/users.css'),
                    $this->a->getPath('netcoid','css/blog.css'),
                    $this->a->getPath('netcoid','css/posts.css'),
                    '/engine/vendors/stackexchangeinc/wmd/demo.css'
                ),
            'js' =>
                array(
                    array(
                       '/engine/vendors/stackexchangeinc/wmd/Markdown.Converter.js'
                    ),
                    array(
                       '/engine/vendors/stackexchangeinc/wmd/Markdown.Sanitizer.js'
                    ),
                    array(
                       '/engine/vendors/stackexchangeinc/wmd/Markdown.Editor.js'
                    ),
                    array(
                        $this->a->getPath('netcoid','js/wmd.js')
                    ),
                    array(
                        $this->a->getPath('netcoid','js/Posts/wmd-addon.js')
                    )
                ),
            'cache' => 0
        ),0); # START

        $this->__Footer();
    }

    public function showPost(){

        $this->__Header();
        $post = $this->p->getPostbyPID($_GET['id']);

        if (!$post) {
            header('HTTP/1.1 404 Not Found');
            echo '404';
            die();            
        }

        $this->h->showAll(); # SHOW FLASH

        $postdata = array(
            'post'          => $post,
            'comments'      => $this->c->getCommentsByPID($_GET['id'], 0, 500),
            'count'         => $this->c->countByPid($_GET['id']),
            'forms'         => $this->f,
            'login'         => $this->e->get('uid')
        );

        $this->r->branch(array(
            'src' => 
                array(
                    'html' => $this->a->getView('netcoid','Posts/Show.php', $postdata),
                    'id' => 'rr-2'
                ),
            'css' => 
                array(
                    $this->a->getPath('default','css/framework.css'),
                    $this->a->getPath('netcoid','css/main.v2.css'),
                    $this->a->getPath('netcoid','css/comments.css'),
                    $this->a->getPath('netcoid','css/blog.css'),
                    $this->a->getPath('netcoid','css/showpost.css')
                    #'/engine/vendors/github/holman-boastful-7423621/netcoid.boastful.css'
                ),
            'js' =>
                array(
                    /*
                    array(
                       '/engine/vendors/github/holman-boastful-7423621/jquery.boastful.js'
                    ),
                    */
                    array(
                       $this->a->getPath('netcoid','js/jquery/jquery.timeago.js'),
                       $this->a->getPath('netcoid','js/timeago.js')
                    )
                ),
            'cache' => 0
        ),1);

        $this->__Footer();
    }

    /**
     * www.networks.co.id/post/any
     * Single Post to Group (post)
     * @author Adam Ramadhan
     * @version 1
     **/
    public function Any(){

        $check = $this->__checkGroup();

        $this->__processPost(0); # 0 any, 1 offer, 2 request, 3 ntah.

        $this->__Header();

        $postdata = array(
            'forms' => $this->f,
            'validation' => $this->v,
            'username' => $this->e->get('username')
        );

        $this->r->branch(array(
            'src' => 
                array(
                    'html' => $this->a->getView('netcoid','Posts/Any.php',$postdata),
                    'id' => 'rr-2'
                ),
            'css' => 
                array(
                    $this->a->getPath('default','css/framework.css'),
                    $this->a->getPath('netcoid','css/main.v2.css'),
                    $this->a->getPath('netcoid','css/forms.css'),
                    $this->a->getPath('netcoid','css/users.css'),
                    $this->a->getPath('netcoid','css/blog.css'),
                    $this->a->getPath('netcoid','css/posts.css'),
                    '/engine/vendors/stackexchangeinc/wmd/demo.css'
                ),
            'js' =>
                array(
                    array(
                       '/engine/vendors/stackexchangeinc/wmd/Markdown.Converter.js'
                    ),
                    array(
                       '/engine/vendors/stackexchangeinc/wmd/Markdown.Sanitizer.js'
                    ),
                    array(
                       '/engine/vendors/stackexchangeinc/wmd/Markdown.Editor.js'
                    ),
                    array(
                        $this->a->getPath('netcoid','js/wmd.js')
                    ),
                    array(
                        $this->a->getPath('netcoid','js/Posts/wmd-addon.js')
                    )
                ),
            'cache' => 0
        ),0); # START

        $this->__Footer();
    }

    /**
     * www.networks.co.id/post/offer
     * Single Post to Group (post)
     * @author Adam Ramadhan
     * @version 1
     **/
    public function Offer(){

        $check = $this->__checkGroup();
        
        $this->__processPost(1); # 0 any, 1 offer, 2 request, 3 ntah.

        $this->__Header();

        $postdata = array(
            'forms' => $this->f,
            'validation' => $this->v,
            'username' => $this->e->get('username')
        );

        $this->r->branch(array(
            'src' => 
                array(
                    'html' => $this->a->getView('netcoid','Posts/Offer.php',$postdata),
                    'id' => 'rr-2'
                ),
            'css' => 
                array(
                    $this->a->getPath('default','css/framework.css'),
                    $this->a->getPath('netcoid','css/main.v2.css'),
                    $this->a->getPath('netcoid','css/forms.css'),
                    $this->a->getPath('netcoid','css/users.css'),
                    $this->a->getPath('netcoid','css/blog.css'),
                    $this->a->getPath('netcoid','css/posts.css'),
                    '/engine/vendors/stackexchangeinc/wmd/demo.css'
                ),
            'js' =>
                array(
                    array(
                       '/engine/vendors/stackexchangeinc/wmd/Markdown.Converter.js'
                    ),
                    array(
                       '/engine/vendors/stackexchangeinc/wmd/Markdown.Sanitizer.js'
                    ),
                    array(
                       '/engine/vendors/stackexchangeinc/wmd/Markdown.Editor.js'
                    ),
                    array(
                        $this->a->getPath('netcoid','js/wmd.js')
                    ),
                    array(
                        $this->a->getPath('netcoid','js/Posts/wmd-addon.js')
                    )
                ),
            'cache' => 0
        ),0); # START

        $this->__Footer();
    }

    /**
     * www.networks.co.id/post/offer
     * Single Post to Group (post)
     * @author Adam Ramadhan
     * @version 1
     **/
    public function Request(){

        $check = $this->__checkGroup();

        $this->__processPost(2); # 0 any, 1 offer, 2 request, 3 ntah.

        $this->__Header();

        $postdata = array(
            'forms' => $this->f,
            'validation' => $this->v,
            'username' => $this->e->get('username')
        );

        $this->r->branch(array(
            'src' => 
                array(
                    'html' => $this->a->getView('netcoid','Posts/Request.php',$postdata),
                    'id' => 'rr-2'
                ),
            'css' => 
                array(
                    $this->a->getPath('default','css/framework.css'),
                    $this->a->getPath('netcoid','css/main.v2.css'),
                    $this->a->getPath('netcoid','css/forms.css'),
                    $this->a->getPath('netcoid','css/users.css'),
                    $this->a->getPath('netcoid','css/blog.css'),
                    $this->a->getPath('netcoid','css/posts.css'),
                    '/engine/vendors/stackexchangeinc/wmd/demo.css'
                ),
            'js' =>
                array(
                    array(
                       '/engine/vendors/stackexchangeinc/wmd/Markdown.Converter.js'
                    ),
                    array(
                       '/engine/vendors/stackexchangeinc/wmd/Markdown.Sanitizer.js'
                    ),
                    array(
                       '/engine/vendors/stackexchangeinc/wmd/Markdown.Editor.js'
                    ),
                    array(
                        $this->a->getPath('netcoid','js/wmd.js')
                    ),
                    array(
                        $this->a->getPath('netcoid','js/Posts/wmd-addon.js')
                    )
                ),
            'cache' => 0
        ),0); # START

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

    private function __checkPostUser(){
         $postdata = $this->p->getPostbyPID($_GET['id']);

        # SECURITY 
        if ($postdata['post_UID'] !== $this->e->get('uid')) {
            die('security@networks.co.id');
        }       
    }

   /**
     * Check if any post and Process it
     * @author Adam Ramadhan
     * @version 1
     **/
    private function __processPost($status,$update = 0){
        if ($this->f->checkHumanPost(1)) {

            $p['title'] = $_POST['title'];
            $p['content'] = $this->v->safe($_POST['content']);

            # FALLBACK
            if (empty($_POST['content_html'])) {
                $m = new Engine\Vendors\Stackexchangeinc\wmd\ElephantMarkdown;
                $p['content_html'] = $m->netcoid_safe_parse($_POST['content']);
            }

            # THIS IS NOT SAFE! @todo

            $m = new Engine\Vendors\Stackexchangeinc\wmd\ElephantMarkdown;
            $p['content_html'] = $m->netcoid_safe_parse($_POST['content']);

            $time = new DateTime(NULL, new DateTimeZone('Asia/Jakarta'));

            if ($update === 0) {
                $p['time_create'] = $time->format('Y-m-d H:i:s');
                $p['time_bump'] = $time->format('Y-m-d H:i:s');
                $p['time_update'] = $time->format('Y-m-d H:i:s');        
            }

            if ($update === 1) {
                $p['pid'] = $_GET['id'];
                $p['time_update'] = $time->format('Y-m-d H:i:s');               
            }

            $p['post_GID'] = $this->v->safe($_GET['id']);
            $p['post_UID'] = $this->e->get('uid');

            # 0 any, 1 offer, 2 request, 3 ntah.
            $p['status'] = $status;

            $this->v->regex($_POST['title'], '/^[a-zA-Z0-9_\s#]{4,140}$/', 
            '4-140 boleh berupa a-Z 0-9 # dan spasi');
            $this->v->required($_POST['content'], 'post tidak boleh kosong');
            $this->v->required($_POST['content_html'], 'security@networks.co.id');

            if(!sizeof($this->v->errors)) 
            {
                # guard doble post for lagging people
                if ($update === 0) {
                    $id = $this->p->setPostReturnId($p);
                    $this->h->setMessage('Posted');
                    header('Location: /post?id='.$id); // to post
                }

                if ($update === 1) {
                    $this->p->editPost($p);
                    $this->h->setMessage('Edited');
                    header('Location: /post?id='.$_GET['id']); // to post
                }
            }
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


        # CHECK POST ENABLED + LOGIN USER + IF CAN POST WITH USER
        $data = $this->u->getData($this->e->get('uid'));
        if (!$active['permission']['post'] || !$this->e->get('uid') || !in_array($data['role'], $active['permission']['users'])) {
            die('security@networks.co.id');
        }

        return $active;
    }
}
?>