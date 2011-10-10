<?php 
if (!defined('SECURE'))
    exit('Hello, security@networks.co.id');

use Engine\Libraries\Assets;
use Engine\Libraries\RedRiver;
use Engine\Libraries\Memcached;
use Engine\Libraries\Social;
use Engine\Libraries\Forms;
use Engine\Libraries\Sessions;
use Engine\Libraries\Validation;
use Engine\libraries\Flash;

class Message Extends Engine\Red
{
    public $a, $r, $e;

    /**
     * GLOBAL FUNCTION
     * Dependency load here, if a library is used in all the function
     * put it here, dont forget to put a private var above
     * @author Adam Ramadhan
     * @version 1
     **/
    public function __construct(){
        $this->a = new Assets;
        $this->r = new RedRiver;
        $this->e = new Sessions;

        $this->v = new Validation;
        $this->f = new Forms;
        $this->u = new Apps\Netcoid\Models\Users;
        $this->m = new Apps\Netcoid\Models\Messages;
        $this->h = new Flash;

        if (!$this->e->get('uid') && isset($_GET['id'])) {
            die('security@networks.co.id');
        }
    }

    public function Index(){
        
        $this->__Header('Netcoid &mdash; Messages');  
        $this->h->showMessage();

        $m = new Apps\Netcoid\Models\Messages;

        # VIEW MESSAGE
        if (isset($_GET['id'])) {

            $messagesdata = array(
                'message' => $m->getMessage($_GET['id'],$this->e->get('uid')),
                'messages' => $m->getListMessages($this->e->get('uid'))
            );

            $this->r->branch(array(
                'src' => 
                    array(
                        'html' => $this->a->getView('netcoid','messages/view.php', $messagesdata),
                        'id' => 'rr-2'
                    ),
                'css' => 
                    array(
                        $this->a->getPath('default','css/framework.css'),
                        $this->a->getPath('netcoid','css/main.v2.css'),
                        $this->a->getPath('netcoid','css/blog.css')
                    ),
                'cache' => 0
            ));   
        }

        # MESSAGE INDEX
        if (!isset($_GET['id'])) {
            $messagesdata = array(
                'messages' => $m->getListMessages($this->e->get('uid')),
                'archives' => $m->getListArchives($this->e->get('uid'))
            );

            $this->r->branch(array(
                'src' => 
                    array(
                        'html' => $this->a->getView('netcoid','messages/index.php', $messagesdata),
                        'id' => 'rr-2'
                    ),
                'css' => 
                    array(
                        $this->a->getPath('default','css/framework.css'),
                        $this->a->getPath('netcoid','css/main.v2.css')
                    ),
                'cache' => 0
            ));            
        }

        $this->__Footer();
    }

    /**
     * www.networks.co.id/skel
     * Search Page Netcoid
     * @author Adam Ramadhan
     * @version 1
     **/
    public function Send(){
        $this->__Header('Netcoid &mdash; Send Message');  

        # CHECK IF THE RECEVER IS THERE IF NOT REDIRECT
        $user = $this->u->uidexist($_GET['id']);
        if (empty( $user )) {
            redirect('/');
        }

        if($this->f->checkHumanPost(3)) {

            $m['RUID'] = $_GET ['id']; # RECEVER
            $m['SUID'] = $this->e->get ( 'uid' ); # SENDER
            
            if (!empty($_POST['subject'])) {
                $m['subject'] = $this->v->safe($_POST['subject']);
            }
            if (empty($_POST['subject'])) {
                $m['subject'] = l('nosubject');
            }

            $m['message'] = $this->v->safe($_POST['message']);
            $m['type'] = '0'; #notopen 
            # get the time from jakarta
            $time = new DateTime(NULL, new DateTimeZone('Asia/Jakarta'));
            $m['time_create'] = $time->format('Y-m-d H:i:s');

            $this->v->regex($_POST['subject'], '/^[a-zA-Z0-9_\s#]{4,140}$/', 
            '4-140 boleh berupa a-Z 0-9 # dan spasi');
            $this->v->required($m['message'], l('message_empty'));
            
            if (!sizeof($this->v->errors)) {
                $this->m->sendMessage($m);
                $this->h->setMessage('Message Sent!');
                header( 'Location: /dashboard' );
            }
            # GET DATA FROM POST
        }

        $messagedata = array(
            'forms' => $this->f
        );

        $this->r->branch(array(
            'src' => 
                array(
                    'html' => $this->a->getView('netcoid','messages/send.php', $messagedata),
                    'id' => 'rr-2'
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