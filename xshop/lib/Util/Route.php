<?php

require_once(dirname(__file__).'/Util.php');

class Router {

    var $fragments = array();
    var $routes = array();

    function __construct() {
        $base = 'shop/';
        $uri = $_SERVER['REQUEST_URI'];
        $uri = substr($uri, strlen($base));
        if (strpos($uri, '?') !== false) $uri = substr($uri, 0, strpos($uri, '?'));
        $uri = trim($uri, '/');
        $this->fragments = explode('/', $uri);
    }
    
    function add($pattern, $params = null) {
        $this->routes[] = array(
            pattern => explode('/', $pattern),
            params => $params ? $params : array()
        );
    }
    
    function route() {
        // finds the best matching route
        foreach ($this->fragments as $ip => $part) {
            if ($ip == count($this->fragments)-1 && $part{0} == '?') {
                // Strips querystring part
                unset($this->fragments[$ip]);
                continue;
            }
            foreach ($this->routes as $ir => $route) {
//                if (count($part) != count($route)) {
//                    unset($this->routes[$ir]);
//                    continue;
//                }                
                if ($route['pattern'][$ip]{0} == ':') continue;
                if ($route['pattern'][$ip] != $part) {
                    unset($this->routes[$ir]);
                    continue;
                }
            }
        }
        if (count($this->routes) < 1) throw new Exception("No URI matching route");
        $route = array_shift($this->routes);
        // get params from route fragments
        $routeparams = array();
        foreach ($this->fragments as $i => $part) {
            $var = $route['pattern'][$i];
            if ($var{0} != ':') continue;
            $var = substr($var, 1);
            $routeparams[$var] = $part;
        }
        // sets params in server request
        //foreach($params as $k => $v) $_REQUEST[$k] = $v;
        // params defined in route config are prioritary
        $params = array_merge($_REQUEST, $routeparams, $route['params']);
        // debug info
        if (isset($_GET['debug'])) {
            Util::debug('Route debug',
                 'Route fragments:',
                 $this->fragments,
                 'Matched route:',
                 $route,
                 'Route params:',
                 $routeparams,
                 'Controller params:',
                 $params,
                 'REQUEST params:',
                 $_REQUEST
            );
        }
        // calls controller action
        $controller = $params['controller'];
        $action = $params['action'];
        require_once(dirname(__file__)."/../../controllers/{$controller}.php");
        try {
            if ($action{0} == '_') throw new Exception("Action {$controller}.{$action} is not meant to be called");
            $c = new $controller($params);
            if ($action) $c->$action();
        } catch (Exception $e) {
            if (isset($_GET['debug'])) {
                print
                    '<pre style="background-color:#fcc; border:2px dashed #e00; padding:10px; font-size:11px">' .
                    '<h1>Unexpected error</h1>' .
                    $e . 
                    '</pre>';
            }
        }
    }    
}

?>
