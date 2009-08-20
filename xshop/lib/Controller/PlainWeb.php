<?php

require_once(dirname(__file__).'/../Controller/Controller.php');
require_once(dirname(__file__).'/../View/View.php');

class PlainWeb extends Controller {

    function __construct($params = array()) {
        //error_reporting(0) in prod mode
        parent::__construct($params);
        $this->get();
    }

    function get() {
        $view = View::load($this->params['view'], $this->params);
        $view->display();
    }

}

?>
