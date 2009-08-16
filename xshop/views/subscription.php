<?php

require_once(dirname(__file__).'/../controllers/cart.php');

// TODO: extend cartview, or vice-versa
class subscription extends View {

    function handle() {
        $c = new cart();
        $r = $c->get();
        // cart price
        $price = $count = 0;
        foreach ($r as $item) {
            $price += (float)$item['total'];
            $count += (int)$item['quantity'];
        }
        // search
        $t = new Template('cart.overview.tpl');
        $t->a('n', $count);
        $t->a('price', sprintf("%.2f", $price));
        $this->b($t->apply());
    }
}

?>
