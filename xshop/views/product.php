<?php

require_once(dirname(__file__).'/../controllers/products.php');

class product extends View {

    function handle() {
        var_dump($this->params);
        $c = new products($this->params);
        $products = $c->get();
        
        $t = new Template('product.tpl');
        $t->a('product', array_shift($products));
        $this->b($t->apply());
    }
}

?>
