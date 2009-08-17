<?php

require_once(dirname(__file__).'/../Controller/Controller.php');
require_once(dirname(__file__).'/../View/View.php');

class PlainWeb extends Controller {

    function __construct($params = array()) {
        //error_reporting(0) in prod mode
        try {
            parent::__construct($params);
            $this->get();
        } catch (Exception $e) {
            print
                '<pre style="background-color:#fcc; border:2px dashed #e00; padding:10px; font-size:11px">' .
                '<h1>Unexpected error</h1>' .
                $e . 
                '</pre>';
            $this->params = array(view => 'welcome');
            $this->get();
        }
    }

    function get() {
        $name = $this->params['view'];
        $view = new View($this->params);
        print $view->fetch($name);
    }

}

?>
