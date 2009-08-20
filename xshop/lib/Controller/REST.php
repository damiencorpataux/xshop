<?php

/*
 * NOT YET USED, waiting for reflexion conclusion about a
 * decorator controller for web and rest "modes"
 */

require_once(dirname(__file__).'/Controller.php');

class REST extends Controller {

    function __construct($params = array()) {
        parent::__construct($params);
        $controller = $this->params['controller'];
        require_once(dirname(__file__)."/../../controllers/{$controller}.php");
        $c = new $controller($this->params);
        if ($action = $this->params['action']) {
            $this->handle($c->$action());
            return;
        }
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET': // select
                $this->handle($c->get());
            break;
            case 'POST': // insert
                $this->handle($c->post());
            break;
            case 'PUT': // update
                $this->handle($c->put());
            break;
            case 'DELETE': // delete
                $this->handle($c->delete());
            break;
            default:
                header("HTTP/1.0 405 Method Not Allowed");
            break;
        }
    }

    function handle($result) {
        /*
        $error = false;
        if ($error) {
            header("HTTP/1.0 500 Internal Server Error");
        }
        if (count($result) < 1) {
            header("HTTP/1.0 404 Not Found");
        }
        */
        $this->respond($result);
    }

    function respond($item) {
        // TODO: header mimetype to "application/json"
        print json_encode($item);
    }

    function error($httpStatus) {
        // TODO: switch on httpstatus (404, 500, 302, ...)
        // and send proper header
    }
}

?>
