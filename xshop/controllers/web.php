<?php

require_once(dirname(__file__).'/../lib/Controller/PlainWeb.php');

class web extends PlainWeb {

    function __construct($params = array()) {
        try {
            parent::__construct($params);
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
        $view = View::load($this->params['view'], $this->params);
        $layout = View::load('layout', $this->params);
        $layout->meta = array_merge_recursive($layout->meta, $view->getMeta());
        $layout->center = $view->get();
        $layout->display();
    }

}

?>
