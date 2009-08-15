<?php

require_once(dirname(__file__).'/../controllers/products.php');

class product extends View {

    function handle() {
        $c = new products();
        $products = $c->get();
        
        $t = new Template('product.tpl');
        $t->a('product', array_shift($products));
        $this->b($t->apply());
    }
}

?>
