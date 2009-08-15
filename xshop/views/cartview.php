<?php

require_once(dirname(__file__).'/../controllers/cart.php');

class cartview extends View {

    function handle() {
        $c = new cart();
        $cartitems = $c->get();
        // cart price
        // cart details
        $t = new Template('cart.item.tpl');
        $h = '';
        $price = $count = 0;
        foreach ($cartitems as $item) {
            $t->clear();
            $item['total'] = sprintf("%.2f", $item['total']);
            $t->assign('product', $item);
            $h .= $t->apply();
            $price += (float)$item['total'];
            $count += (int)$item['quantity'];
        }
        // cart
        $t = new Template('cart.tpl');
        $t->a('details', $h);
        $t->a('n', $count);
        $t->a('price', sprintf("%.2f", $price));
        $this->b($t->apply());
    }
}

?>
