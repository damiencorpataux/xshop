<?php

class dressing extends View {

    var $menu = 'Categories here';
    var $center = 'Center html';
    var $related = 'Related contents';

    function handle() {
        $t = new Template('layout.tpl');
        $auth = Auth::get();
        $t->a('customername', $auth ? $auth['data']['name'] : '');
        $t->a('center', $this->center);
        $t->a('west', $this->menu);
        $t->a('cart', View::load('cartoverview')->get());
        $t->a('related', $this->related);
        $this->b($t->apply());
    }
}

?>
