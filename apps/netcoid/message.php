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

    /**
     * www.networks.co.id/skel
     * Search Page Netcoid
     * @author Adam Ramadhan
     * @version 1
     **/
    public function Index(){
        $this->__Header();

        # CHECK IF THE RECEVER IS THERE IF NOT REDIRECT
        $user = $this->u->uidexist($_GET['id']);
        if (empty( $user )) {
            redirect('/');
        }

        if($this->f->checkHumanPost(5)) {

            $m['RUID'] = $_GET ['id']; # RECEVER
            $m['SUID'] = $this->e->get ( 'uid' ); # SENDER
            
            if (!empty($m['subject'])) {
                $m['subject'] = $this->v->safe($_POST['subject']);
            }
            if (empty($m['subject'])) {
                $m['subject'] = l('nosubject');
            }
            
            $m['message'] = $this->v->safe($_POST['message']);
            $m['type'] = '0'; #notopen 

            # get the time from jakarta
            $time = new DateTime(NULL, new DateTimeZone('Asia/Jakarta'));
            $m['timecreate'] = $time->format('Y-m-d H:i:s');

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
                    'html' => $this->a->getView('netcoid','send/message.php', $messagedata),
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
     * Footer Element
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