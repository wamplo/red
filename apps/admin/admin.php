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
        $this->f = new Forms;
        header('Location: /404');
        die();
    }

    /**
     * www.networks.co.id/skel
     * Search Page Netcoid
     * @author Adam Ramadhan
     * @version 1
     **/
    public function Index(){
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
            'sessions' => new Sessions
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