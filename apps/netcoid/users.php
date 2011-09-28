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

class Users Extends Engine\Red
{
    public $a, $r, $e;

    public function __construct(){
        $this->a = new Assets;
        $this->r = new RedRiver;
        $this->e = new Sessions;
        $this->f = new Forms;
        $this->h = new Flash;
        $this->v = new Validation;

        if (!$this->e->get('uid')) {
            die('security@networks.co.id');
        }
    }

    /**
     * www.networks.co.id/Dashboard
     * Search Page Netcoid
     * @author Adam Ramadhan
     * @version 1
     **/
    public function Dashboard(){

        $p = new Apps\Netcoid\Models\Posts;
        $g = new Apps\Netcoid\Models\Groups;

        $follow_post = $p->getFollowingPost($this->e->get('uid'));
        $follow_group = $g->getFollowingGroups($this->e->get('uid'));

        # START RENDERARRAY
        $renderarr = array();

        # FOLLOW POST
        if (!empty($follow_post)) {
            # GABUNGIN PID YANG SAMA +  TYPE
            foreach ($follow_post as $newfollow_post) {
                $renderarr[$newfollow_post['PID']] = array(
                    'post' => $newfollow_post,
                    'type' => 'post'
                );
            }
        }

        # FOLLOW GROUP
        if (!empty($follow_group)) {
            foreach ($follow_group as $newfollow_group) {
               $renderarr[$newfollow_group['PID']] = array(
                    'post' => $newfollow_group,
                    'type' => 'groups'
                );
            }
        }
        
        krsort($renderarr);
        
        $this->__Header();

        $this->h->showMessage();

        $dashboarddata = array(
            'posts' => $renderarr
        );

        $this->r->branch(array(
            'src' => 
                array(
                    'html' => $this->a->getView('netcoid','Users/Dashboard.php', $dashboarddata),
                    'id' => 'rr-ajax-dashboard'
                ),
            'css' => 
                array(
                    $this->a->getPath('default','css/framework.css'),
                    $this->a->getPath('netcoid','css/main.v2.css'),
                    $this->a->getPath('netcoid','css/mentions.css'),                   
                ),
            'js' => 
                array(
                    array(
                        $this->a->getPath('netcoid','js/Users/Dashboard.js')
                    ),
                ),
            'cache' => 0
        ),1);

        $this->__Footer();
    }

    /**
     * www.networks.co.id/Mentions
     * Search Page Netcoid
     * @author Adam Ramadhan
     * @version 1
     **/
    public function Mentions(){
        
        $c = new Apps\Netcoid\Models\Comments;

        $mentiondata = array(
            'mentions' => $c->listCommentsByMentions($this->e->get('uid'))
        );

        $this->__Header();

        $this->r->branch(array(
            'src' => 
                array(
                    'html' => $this->a->getView('netcoid','Users/Mentions.php', $mentiondata),
                    'id' => 'rr-ajax-mentions'
                ),
            'css' => 
                array(
                    $this->a->getPath('default','css/framework.css'),
                    $this->a->getPath('netcoid','css/main.v2.css'),
                    $this->a->getPath('netcoid','css/mentions.css'),                   
                ),
            'cache' => 0
        ),1);

        $this->__Footer();
    }

    /**
     * www.networks.co.id/skel
     * Search Page Netcoid
     * @author Adam Ramadhan
     * @version 1
     **/
    public function editProfile(){

        # @todo coba hnya dipindah ke views
        # error gak bisa direfresh nanti 5 / sept / 2011
        $u = new Apps\Netcoid\Models\Users;

        if ($this->f->checkHumanPost(1)) {

            $e['information'] = $this->v->safe($_POST['information']);
            $e['information_html'] = $_POST['information_html'];
            $e['uid'] = $this->e->get('uid');

            $this->v->required($_POST['information_html'], 'security@networks.co.id');

            if(!sizeof($this->v->errors)) 
            {
                $u->updateFrontPage($e); 
                $this->h->setMessage('Updated');
            }
        }

        $this->__Header();

        $editprofile = array(
            'forms' => new Forms,
            'validation' => new Validation,
            'data' => $u->getData($this->e->get('uid')),
            'username' => $this->e->get('username')
        );

        $this->h->showMessage();
        $this->r->branch(array(
            'src' => 
                array(
                    'html' => $this->a->getView('netcoid','Users/Editprofile.php',$editprofile),
                    'id' => 'rr-ajax-edit'
                ),
            'css' => 
                array(
                    $this->a->getPath('default','css/framework.css'),
                    $this->a->getPath('netcoid','css/main.v2.css'),
                    $this->a->getPath('netcoid','css/forms.css'),
                    $this->a->getPath('netcoid','css/users.css'),
                    $this->a->getPath('netcoid','css/blog.css'),
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
                    )
                ),

            'cache' => 0
        ));

        $this->__Footer();
    }

    public function Messages(){
        $this->__Header();

        $m = new Apps\Netcoid\Models\Messages;
        $messagesdata = array(
            'messages' => $m->getListMessages($this->e->get('uid'))
        );

        $this->r->branch(array(
            'src' => 
                array(
                    'html' => $this->a->getView('netcoid','users/messages.php', $messagesdata),
                    'id' => 'rr-ajax-messages'
                ),
            'css' => 
                array(
                    $this->a->getPath('default','css/framework.css'),
                    $this->a->getPath('netcoid','css/main.v2.css')
                ),
            'cache' => 0
        ));
        $this->__Footer();
    }

    /**
     * FRAMEWORK __HEADER
     * @author Adam Ramadhan
     * @version 1
     **/
    private function __Header(){
        echo $this->a->getView('netcoid','Framework/Header.php',
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
                    'html' => $this->a->getView('netcoid','Framework/Menu.php', $menudata),
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
     * @author Adam Ramadhan
     * @version 1
     **/
    private function __Footer(){
        $this->r->branch(array(
        'src' => 
            array(
                'html' => $this->a->getView('netcoid','Framework/Bottom.php'),
                'id' => 'rr-ajax-footer'
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