<?php 
/**
* CORE NODE
*/

use Engine\libraries\Assets;
use Engine\libraries\RedRiver;
use Engine\libraries\Validation;
use Engine\libraries\Forms;
use Engine\libraries\Sessions;
use Engine\libraries\Flash;
use Engine\Vendors\Openwall\PasswordHash;

class Auth Extends Engine\Red
{
    public $a, $r, $v, $f, $e;

    public function __construct(){
        $this->a = new Assets;
        $this->r = new RedRiver;
        $this->v = new Validation;
        $this->f = new Forms;
        $this->e = new Sessions;
    }

    /**
     * www.networks.co.id/login
     * Login Page Netcoid
     * @author Adam Ramadhan
     * @version 1
     **/
    public function Login(){

        # BOOTSTRAP
        $s = new PasswordHash(8,FALSE);
        $u = new Apps\Netcoid\Models\Users;
        $f = new Flash;

        if ($this->f->checkHumanPost(1)) {
            
            $this->v->regex($_POST['username'], '/^[a-zA-Z0-9_]{6,20}$/', l('register_username_error'));
            $this->v->required($_POST['password'], l('register_password_empty'));
            
            if (!sizeof($this->v->errors)) {

                $data = $u->getData($_POST['username']);
                $check = $s->CheckPassword($_POST['password'], $data['password']);
                
                # CHECK RETURN ARRAY JIKA DATABASE KOSONG USER
                
                if ($check) {
                    $this->e->set('uid', $data['uid']);
                    $this->e->set('name', $data['name']);
                    $this->e->set('username', $data['username']);
                    $f->setMessage('Hello, ' . $data['username'] . '!');
                    header('Location: /dashboard');

                } else {
                    $this->v->errors[0] = 'Maaf username atau password yang anda masukan salah, hubungi hello@networks.co.id untuk bantuan';
                }             
            }           
        }

        $this->__Header();

        $signindata = array(
            'forms' => $this->f, 
            'validation' => $this->v
        );

        $this->r->branch(array(
            'src' => 
                array(
                    'html' => $this->a->getView('netcoid','Site/Login.php',$signindata),
                    'id' => 'rr-2'
                ),
            'css' => 
                array(
                    $this->a->getPath('default','css/framework.css'),
                    $this->a->getPath('netcoid','css/main.v2.css'),
                    $this->a->getPath('netcoid','css/buttons.css'),
                    $this->a->getPath('netcoid','css/login.css')
                ),
            'js' =>
                array(
                    array(
                        $this->a->getPath('netcoid','js/jquery/jquery.validation.js')
                    ),
                    array(
                        $this->a->getPath('netcoid','js/signin.js')               
                    )
                ),

            'cache' => 0
        ));

        $this->__Footer();
    }

    /**
     * www.networks.co.id/logout
     * Logout Page Netcoid
     * @author Adam Ramadhan
     * @version 1
     **/
    function Logout()
    {
        $this->e->flush();
        $this->e->refresh();
        header('Location: /');
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