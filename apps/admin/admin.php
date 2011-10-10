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

class Admin Extends Engine\Red
{
    public $a;

    public function __construct(){
        $this->a = new Assets;
        $this->r = new RedRiver;

        $this->v = new Validation;
        $this->e = new Sessions;
        $this->f = new Forms;
        $this->u = new Apps\Netcoid\Models\Users; 

        $user = $this->u->getData($this->e->get('uid'));

        if ($user['role'] != 5) {
            header('Location: /');  
        }
    }

    public function Index(){
        $this->__Header();

        # INDEX
        $this->r->branch(array(
        'src' => 
            array(
                'html' => $this->a->getView('admin','site/index.php'),
                'id' => 'rr-2'
            ),
        'css' => 
            array(
                $this->a->getPath('default','css/framework.css'),
                $this->a->getPath('netcoid','css/main.v2.css')
            ),
         'cache' => 0
        )); # END

        $this->__Footer();
    }

    public function Accounts(){
        $this->__Header();

        # INDEX
        $this->r->branch(array(
        'src' => 
            array(
                'html' => $this->a->getView('admin','accounts/index.php'),
                'id' => 'rr-2'
            ),
        'css' => 
            array(
                $this->a->getPath('default','css/framework.css'),
                $this->a->getPath('netcoid','css/main.v2.css')
            ),
         'cache' => 0
        )); # END

        $this->__Footer();
    }

    /**
     * www.networks.co.id/skel
     * Search Page Netcoid
     * @author Adam Ramadhan
     * @version 1
     **/
    public function Groups(){
        $g = new Apps\Netcoid\Models\Groups;


        if ($this->f->checkHumanPost(1)) 
        {
            var_dump($_POST);
            $this->v->required($_POST['name'], l('group_name_error'));
            #$this->v->required($_POST['parent'], l('group_parent_name_error'));
            $this->v->required($_POST['description'], l('group_description_error'));
            $this->v->required($_POST['description_html'], l('group_description_html_error'));
            $this->v->required($_POST['status'], l('group_status_error'));

            if (!sizeof($this->v->errors)) {

                $group['name'] = $_POST['name'];
                $group['parent_GID'] = $g->getGIDbyName($_POST['parent']);
                $group['description'] = $_POST['description'];
                $group['description_html'] = $_POST['description_html'];
                $group['status'] = $_POST['status'];

                var_dump($group);
                $g->setGroup($group);
                #header('Location: /admin');
            }
        }


        $this->__Header();

        $groupsdata = array(
            'forms' => $this->f, 
            'validation' => $this->v
        );

        $this->r->branch(array(
            'src' => 
                array(
                    'html' => $this->a->getView('admin','groups/New.php',$groupsdata),
                    'id' => 'rr-ajax-admin-groups'
                ),
            'css' => 
                array(
                    $this->a->getPath('default','css/framework.css'),
                    $this->a->getPath('netcoid','css/main.v2.css'),
                    $this->a->getPath('netcoid','css/buttons.css'),
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
                        $this->a->getPath('admin','js/groups.js')
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

            echo "<title>$title</title>";
            
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
                        'html' => $this->a->getView('admin','framework/menu.php', $menudata),
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