<?php

class layout extends View {

    var $menu = 'Categories here';
    var $center = 'Center html';
    var $related = 'Related contents';
    var $meta = array(
        title => '',
        keywords => '',
        author => '',
        scripts => array(
            '/shop/js/lib/ext-core/ext-core.js',
            '/shop/js/lib/xshop/core.js'
        )
    );

    function handle() {
        $t = new Template('layout.tpl');
        $auth = Auth::get();
        $t->a('customername', $auth ? $auth['data']['name'] : '');
        $t->a('center', $this->center);
        $t->a('west', $this->menu);
        $t->a('cart', View::load('cartoverview')->get());
        $t->a('related', $this->related);
        $t->a('meta', $this->meta);
        $this->b($t->apply());
    }
}

?>
