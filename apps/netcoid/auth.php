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
                    'id' => 'rr-ajax-login'
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
                        $this->a->getPath('netcoid','js/jquery.validation.js')
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