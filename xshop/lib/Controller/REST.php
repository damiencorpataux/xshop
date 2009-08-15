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
}

?>
