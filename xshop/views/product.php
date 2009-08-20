<?php

require_once(dirname(__file__).'/../controllers/products.php');

class product extends View {

    function __construct($params = array()) {
        parent::__construct($params);
        $c = new products($this->params);
        $this->product = array_shift($c->get());
    }

    function handle() {
        $t = new Template('product.tpl');
        $t->a('product', $this->product);
        $this->b($t->apply());
    }

    function getMeta() {
        return array('title' => $this->product['name']);
    }
}

?>
