<?php
namespace Engine;

if (!defined('SECURE'))
    exit('Hello, security@networks.co.id');

class Router
{
    # PRIVATE GLOBALS
    private $url;
    private $routes;
    private $controller;
    private $segments;
    private $params;

    public function __construct($dependency)
    {
        # RUN THE ROUTE
        $this->dependency = $dependency;
        $this->setup();
        $this->getRoutes();
        $this->getControllers();
        $this->dispatch();
    }

    private function setup()
    {
        # SETUP CONFIGURATION
        # $config = $this->dependency['engine']->register();

        # REMOVE FOLDER(not supported) & CLEAN THE URL from ?
        $this->url = parse_url(str_replace( '' , NULL, $_SERVER['REQUEST_URI']), PHP_URL_PATH);

        # GET SEGMENTS
        $this->segments = explode('/', $this->url);
        array_shift($this->segments);
    }

    private function getRoutes()
    {
        # GET FROM NODES THAT ARE REGISTERD
        $apps = $this->dependency['apps']->register();

        # GET ROUTES FORM EACH APPLICATION
        foreach ($apps as $app => $status) {
            if (!is_file('apps' . DS . $app . DS . "__init__.php")) {
                throw new \Exception("Node <code>$app</code> __init__.php is missing see #1");
            }

            include_once 'apps' . DS . $app . DS . "__init__.php";

            # @todo ERROR FOR DUPLICATE ROUTES
            foreach ($routes as $key => $value) {
                if (!isset($newroutes[$key])) {

                    # ONLINE
                    if ($status) {
                        $joinedroutes[$key] = $app . ':' . $value;
                    }

                    # OFFLINE
                    if (!$status) {
                        $joinedroutes[$key] = 'default:defaults:Offline';
                    }
                }
            }
        }
        $this->routes = $joinedroutes;
    }

    private function getControllers()
    {
        # DEFAULT
        if (empty($this->segments[0])) {
            $this->controller = $this->routes['index'];
        }

        # SEARCH REGEX
        $uri = implode('/', $this->segments);
        foreach ($this->routes as $regex => $request) {
            if (preg_match('#^' . $regex . '$#', $uri)) {
                if (isset($this->url)) {
                    $this->controller = $request;
                }
                if (strpos($request, '$') !== FALSE and strpos($regex, '(') !== FALSE) {
                    $controller = preg_replace('#^' . $regex . '$#', $request, $this->url);
                    $this->controller = $controller;
                }
            }
        }

        # 404
        if (!isset($this->controller)) {
            $this->controller = $this->routes['404'];
        }
    }

    private function dispatch()
    {
        $controller = explode(':', $this->controller);
        
        # GET INFORMATION FROM STRING
        $path = "apps" . DS . $controller[0] . DS . $controller[1] . ".php";
        $path = strtolower($path);

        # CHECK PERMISSION & EXIST
        if (file_exists($path) && is_readable($path)) {

            include_once $path;

            # NODE, CLASS, METHOD
            $app = strtolower($controller[0]);
            $class = ucfirst($controller[1]);
            $method = strtolower($controller[2]);

            # GET CLASS OUT FOR REAL PARAMS
            $this->params = array_diff($this->segments, array(
                $controller[1]
            ));

            #var_dump($app,$class,$method);
            # START THE MAGIC
            $controller = new $class();
            if (is_callable(array(
                $controller,
                $method
            ))) {

                // ADD SECURITY
                header('SERVER:');
                header('X-Powered-By:');

                # IF EMPTY CALL $controller->method else call_user_func_arr
                # http://paul-m-jones.com/archives/182
                
                call_user_func_array(array(
                    $controller,
                    $method
                ), $this->params);
            }
            if (!is_callable(array(
                $controller,
                $method
            ))) {
                throw new \Exception("Cant call class <code>$class</code> with function <code>$method</code> #1 in
                App <code>$app</code>");
            }
        }
    }
}
?>