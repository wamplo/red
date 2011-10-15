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
        
        $this->__Header('Netcoid &mdash; Dashboard');

        $this->h->showMessage();

        $dashboarddata = array(
            'posts' => $renderarr
        );

        $this->r->branch(array(
            'src' => 
                array(
                    'html' => $this->a->getView('netcoid','users/dashboard.php', $dashboarddata),
                    'id' => 'rr-2'
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
                        $this->a->getPath('netcoid','js/users/dashboard.js')
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

        $this->__Header('Netcoid &mdash; Mentions');

        $this->r->branch(array(
            'src' => 
                array(
                    'html' => $this->a->getView('netcoid','Users/Mentions.php', $mentiondata),
                    'id' => 'rr-2'
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

            #$e['information_html'] = $_POST['information_html'];

            # START PLUGIN
            $vendorHTMLpurifier = new Engine\Vendors\HTMLpurifier\HTMLpurifier;
            $HTMLpurifierConfig = HTMLPurifier_Config::createDefault();
            $HTMLpurifierConfig->set('HTML.SafeObject', "1");
            $HTMLpurifierConfig->set('Output.FlashCompat', "1");
            $HTMLpurifierConfig->set('Filter.YouTube', "1");
            $HTMLpurifierConfig->set('URI.AllowedSchemes', array(
                'ymsgr' => true,
                'http' => true,
                'https' => true,
                'mailto' => true,
            ));

            $purifier = new HTMLPurifier($HTMLpurifierConfig);

            # @todo munkin nanti satu aja, information aja gak usah pake html karena sama ajA
            # penuh - penuhin database
            
            $e['information'] = $purifier->purify($_POST['information']);
            $e['information_html'] = $e['information'];
            # END PLUGIN
            
            $e['uid'] = $this->e->get('uid');

            $this->v->required($e['information_html'], 'security@networks.co.id');
            $this->v->required($e['information'], 'security@networks.co.id');

            if(!sizeof($this->v->errors)) 
            {
                $u->updateFrontPage($e); 
                $this->h->setMessage('Updated');
            }
        }

        $this->__Header('Netcoid &mdash; Edit Profile');

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
                    'html' => $this->a->getView('netcoid','users/editprofile.php',$editprofile),
                    'id' => 'rr-2'
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

            'cache' => 0
        ));

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