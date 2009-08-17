<?php

require_once(dirname(__file__).'/../lib/Controller/REST.php');

class restservice extends REST {

    function __construct($params = array()) {
        $params['controller'] = $params['restcontroller'];
        $params['action'] = $params['restaction'];
        parent::__construct($params);
    }
    
}

?>
