<?php

require_once(dirname(__file__).'/../lib/Controller/PlainWeb.php');

class web extends PlainWeb {

    function get() {
        $view = View::load($this->params['view'], $this->params);
        $layout = View::load('layout', $this->params);
        $layout->meta = $view->getMeta();
        $layout->center = $view->get();
        $layout->display();
    }

}

?>
