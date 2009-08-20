<?php

require_once(dirname(__file__).'/../lib/Util/Auth.php');
require_once(dirname(__file__).'/../lib/Controller/DbController.php');
require_once(dirname(__file__).'/order.php');

/*
 * Cart is an Order_Product controller that behaves like a cart
 */
class cart extends DbController {

    var $table = 'Order_Product, `Order`, Products, Products_description, Products_custom';

    var $mapping = array(
        'id' => 'Order_Product.fk_order_id', // TODO: remove this
        'order' => 'Order_Product.fk_order_id',
        'product' => 'Order_Product.fk_product_id',
        'qty' => 'quantity',
        'customer' => '`Order`.fk_customer_id'
    );

    var $put = array('product');
    var $delete = array('order', 'product');

    var $return = array('*', 'price*quantity AS total');

    function getSqlJoin() {
        return parent::getSqlJoin() .
            " AND processed_date is null" .
            " AND Order_Product.fk_order_id = `Order`.id" .
            " AND Order_Product.fk_product_id = Products.id" .
            " AND Products_description.fk_product_id = Products.id" .
            " AND Products_custom.fk_product_id = Products.id" .
            " AND Products_description.lang = 'fr'";
    }

    function __construct($params = array()) {
        parent::__construct($params);
        if (!isset($this->params['id'])) $this->params['id'] = $this->getOrderId(); // Deprecated, use order as in mapping
        if (!isset($this->params['order'])) $this->params['order'] = $this->getOrderId();
    }

    /*
     * $id: product id
     */
    function add() {
        // looks for product in cart
        if (!isset($this->params['product'])) throw new Exception("No product specified");
        $c = new cart(array(
            id=>$this->params['order'],
            product=>$this->params['product']
        ));
        $items = $c->get();
        // insert product in cart if not existing
        if (!$items) {
            // TODO: check that product exists
            //       (maybe check that in $this->get() that would throw a "Unknown product" exception)
            $this->put();
        }
        // update cart quantities if existing
        $qty = isset($this->params['qty']) ? (int)$this->params['qty'] : 1;
        $q = (int)$items[0]['quantity'] + (int)$qty;
        unset($this->params['qty']); // TODO: this is bad (find a good way to update rows: discrimine what params for WHERE and that params for SET)
        if ($q > 0) {
            $sql = "UPDATE {$this->maintable} SET quantity = '{$q}'";
            $sql .= $this->getSqlWhere();
            $sql .= "LIMIT 1";
            return $this->query($sql);
        } else {
            var_dump($this->params);
            return $this->delete();
        }
    }

    function remove() {
        // TODO: if last order product removed, delete the related order
    }

    function getOrderId() {
        // gets current order,
        // if an unprocessed order does not exist, create it
        // TODO: move this in order::getCurrent() ?
        $uid = Auth::get() ? Auth::getid() : 0;
        $c = new order(array(customer=>$uid));
        $order = $c->getCurrent();
        if (!count($order)) {
            $id = $c->put();
            $id = $id['insertid'];
            $order = $c->get($id);
        }
        $order = $order[0];
        return $order['id'];
    }

}

?>
