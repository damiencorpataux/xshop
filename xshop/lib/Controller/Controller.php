<?php

/**
 * Base controller class
 * Deals with caller interactions (request & response)
 * Subclasses handle data retrieving logic and http status codes (eg. 404)
**/
class Controller {

    var $params = array();
    
    function __construct($params = array()) {
        // Check optional auth

        $this->params = $params;
        
    }

    function handleRest() {
        // if not auth correctly: 401 Unauthorized
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $result = $this->get();
            break;
            case 'PUT':
            case 'POST':
                $result = $this->put();
            break;
            case 'DELETE':
                $result = $this->delete();
            break;
            default:
                header("HTTP/1.0 405 Method Not Allowed");
            break;
            $this->handle($result);
        }
    }

    function get() {}

    function put() {}

    function delete() {}
}

?>
