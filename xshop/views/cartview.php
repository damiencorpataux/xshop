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
        $count = $price = $weight = 0;
        foreach ($cartitems as $item) {
            $t->clear();
            $item['total'] = sprintf("%.2f", $item['total']);
            $t->assign('product', $item);
            $h .= $t->apply();
            $count += (int)$item['quantity'];
            $price += (float)$item['total'];
            $weight += (int)$item['weight']*(int)$item['quantity'];
        }
        // cart
        $t = new Template('cart.tpl');
        $t->a('details', $h);
        $t->a('n', $count);
        $t->a('nproducts', count($cartitems));
        $t->a('weight', $weight);
        $t->a('price', sprintf("%.2f", $price));
        $this->b($t->apply());
    }
}

?>
