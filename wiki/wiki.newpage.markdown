# MAKEING A NEW PAGE

a minimum page reqiure:

- a route
- a controller

lets say your in `main` team you only can edit / pull everything in `/apps/netcoid` folder

1. create a route, open `__init__.php` on each app folder, in this example is on `netcoid`

	#### REGISTER ROUTES `__init__.php`
	
	$routes = array(
		// if get `/` request -> run controller file `defaults.php` function `Index()`
	    'index' =>  'defaults:Index',
		// if get `/404` request -> run controller file `defaults.php` function `Missing()`	    
	    '404'   =>  'defaults:Missing',
		// if get `/503` request -> run controller file `defaults.php` function `Offline()`
	    '503'   =>  'defaults:Offline',
		// if get `/nojs` request -> run controller file `defaults.php` function `Nojs()`
	    'nojs'  =>  'defaults:Nojs'
	);

2. create a controller
a controller is where all the function live, name it as a group, lets say we want to make a ajax page to procsess some json request, so the controller will be named `ajax.php` with a skel controller for more **Naming convention** please see example below

### Controller

	<?php 
	if (!defined('SECURE'))
	    exit('Hello, security@networks.co.id');
	use Engine\Libraries\Assets;
	use Engine\Libraries\RedRiver;
	use Engine\Libraries\Memcached;
	use Engine\Libraries\Social;
	use Engine\Libraries\Forms;
	use Engine\Libraries\Sessions;
	class Site Extends Engine\Red
	{
	    public $a, $r, $e;

	    /**
	     * GLOBAL FUNCTION
	     * Dependency load here, if a library is used in more then
	     * 2 Function put it here too, dont forget to put a private var
	     * above
	     * @author Adam Ramadhan
	     * @version 1
	     **/
	    public function __construct(){
	        $this->a = new Assets;
	        $this->r = new RedRiver;
	        $this->e = new Sessions;
	    }

	    /**
	     * www.networks.co.id/skel
	     * Search Page Netcoid
	     * @author Adam Ramadhan
	     * @version 1
	     **/
	    public function Skel(){
	        $this->__Header();
	        echo "skel";
	        $this->__Footer();
	    }

	    /**
	     * FRAMEWORK __HEADER
	     * Header Element
	     * @author Adam Ramadhan
	     * @version 1
	     **/
	    private function __Header(){
	        echo $this->a->getView('netcoid','framework/header.php',
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
	                'id' => 'rr-ajax-footer'
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