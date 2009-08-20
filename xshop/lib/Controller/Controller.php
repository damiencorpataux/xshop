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
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $result = $this->get();
            break;
            case 'POST':
                $result = $this->post();
            case 'PUT':
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

    // select
    function get() {}

    // insert
    function post() {}

    // update
    function put() {}

    // delete
    function delete() {}
}

?>
