<?php

require_once(dirname(__file__).'/../controllers/products.php');

class productlist extends View {

    function handle() {
        // search
        $t = new Template('search.tpl');
        $t->a('fulltext', $_REQUEST['fulltext']);
        $this->b($t->apply());
        // list
        $c = new products(array(
            fulltext => $_REQUEST['fulltext']
        ));
        $t = new Template('productlist.listitem.tpl');
        $h = '';
        $products = $c->get();
        foreach ($products as $product) {
            $t->clear();
            $t->assign('product', $product);
            $h .= $t->apply();
        }
        // wrapper
        $t = new Template('productlist.tpl');
        $t->a('products', $h);
        $t->a('n', count($products));
        $this->b($t->apply());
    }
}

?>
