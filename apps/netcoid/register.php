<?php 

if (! defined ( 'SECURE' ))
    exit ( 'Hello, security@networks.co.id' );

use Engine\libraries\Assets;
use Engine\libraries\RedRiver;
use Engine\libraries\Forms;
use Engine\libraries\Security;
use Engine\libraries\Validation;
use Engine\libraries\Sessions;
use Engine\Vendors\Openwall\PasswordHash;

class Register extends Engine\Red
{
    public $a, $r, $e;
    
    function __construct(){
        $this->a = new Assets;
        $this->r = new RedRiver;
        $this->e = new Sessions;
    }

    function Index(){

        # BOOTSTRAP
        $s = new PasswordHash(8,FALSE);
        $u = new Apps\Netcoid\Models\Users;
        $v = new Validation;
        $f = new Forms;
        # loadingnya agak lama $s = new Social;

        if ($f->checkHumanPost(5)) {

            $time = new DateTime(NULL, new DateTimeZone('Asia/Jakarta'));
            $data['username'] = $_POST ['username'];
            $data['password'] = $s->HashPassword($_POST['password']);
            $data['name'] = $_POST ['name'];
            $data['phone'] = $_POST ['phone'];
            $data['email'] = $_POST ['email'];
            $data['timelogin'] = $time->format ('Y-m-d H:i:s');
            $data['timeregister'] = $time->format ('Y-m-d H:i:s');
            $data['role'] = '0';

            $v->regex($data['username'], '/^[a-zA-Z0-9_]{6,20}$/', l('register_username_error'));
            $v->required($data['password'], l('register_password_empty'));
            $v->regex($data['name'], '/^[a-zA-Z0-9_\s]{6,30}$/', l('register_name_error'));
            $v->regex($data['phone'], '/^([0]([0-9]{2}|[0-9]{3})[-][0-9]{6,8}|[0][8]([0-9]{8,12}))$/', l ('register_phone_error'));
            $v->regex($data['email'], '/^[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/', l('register_email_error'));

            # check username
            # @todo ajaxnya blm & routes check
            $userexist = $u->userexist($data['username']);
            $companyexist = $u->companyexist($data['name']);
            $v->f(!empty($userexist), l('register_username_used'));
            $v->f(!empty($companyexist), l('register_name_used'));
            $this->validation = $v; // GLOBAL OBJ
            #$v->f(is_routes($r['username']), l('register_username_used'));

            if (!sizeof($v->errors)) 
            {
                $status = $u->register($data);
                if ($status) {

                    $this->welcome();
                    
                    # START EMAIL
                    $fheaders  = 'From: Netcoid <hermes-the-messenger@netcoid.com>; charset=UTF-8; Content-Type: text/html';

                    $fmessage = 'Anda terdaftar dengan username, ' . $data['username']. ' dengan password ' . $_POST['password'] . '. anda dapat langsung login di www.netcoid.com/login. *Segera hapus email ini demi keamanan, jika anda merasa email ini salah kirim tolong hubungi security@netcoid.com';

                    $fsubject = 'Hallo!, Selamat bergabung di Netcoid Indonesia! [rahasia]';
                    $to = $data['email'];
                    mail($to, $fsubject, $fmessage, $fheaders);
                    # START EMAIL
                }
                if (!$status) {
                    die('registrasi gagal, support@networks.co.id');
                }
            }
        }
    }

    function Welcome(){

        $this->__Header();  

        $this->r->branch(array(
            'src' => 
                array(
                    'html' => $this->a->getView('Netcoid','Users/Welcome.php'),
                    'id' => 'rr-ajax-welcome'
                ),
            'css' => 
                array(
                    $this->a->getPath('default','css/framework.css'),
                    $this->a->getPath('netcoid','css/main.v2.css'),
                    $this->a->getPath('netcoid','css/blog.css'),
                    $this->a->getPath('netcoid','css/welcome.css')
                ),
            'js' =>
                array(
                    array(
                        'https://platform.twitter.com/anywhere.js?id=VgMhY8zm9QF6SgpYskmptA&v=1'
                    ),
                    array(
                        $this->a->getPath('netcoid','js/welcome.js')
                    )
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