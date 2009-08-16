<?php

/*
 * NOT YET USED, waiting for reflexion conclusion about a
 * decorator controller for web and rest "modes"
 */

require_once(dirname(__file__).'/Controller.php');

class REST extends Controller {

    function __construct($params = array()) {
        $this->dsn = $dsn ? $dsn : Config::get('dsn');
        parent::__construct($params);
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $this->get();
            break;
            case 'PUT':
                $this->put();
            break;
            case 'DELETE':
                $this->delete();
            break;
            default:
                header("HTTP/1.0 405 Method Not Allowed");
            break;
        }
    }

    function handle($result) {
        $error = false;
        if ($error) {
            header("HTTP/1.0 500 Internal Server Error");
            if ($debug) var_dump($result);
        }
        if (count($result) < 1) {
            header("HTTP/1.0 404 Not Found");
        }
        $this->respond($result);
    }

    function respond($item) {
        print json_encode($item);
    }

    function error($httpStatus) {
        // TODO: switch on httpstatus (404, 500, 302, ...)
        // and send proper header
    }
}

?>
