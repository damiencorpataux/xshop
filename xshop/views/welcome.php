<?php

class welcome extends View {

    function handle() {
        $t = new Template('welcome.tpl');
        $t->a('name', 'test name');
        $this->b($t->apply());        
        $this->b($this->fetch('productlist'));
        /* instead of
        $c = new products($dsn);
        $t = new Template('product.listitem.tpl');
        foreach ($c->get() as $product) {
            $t->clear();
            $t->assign('product', $product);
            $this->b($t->apply());
        }
        */
    }
}

?>
