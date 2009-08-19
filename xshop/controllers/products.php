<?php

require_once(dirname(__file__).'/../lib/Controller/DbController.php');

class products extends DbController {

    var $table = 'Products, Products_description, Products_custom';

    var $mapping = array(
        'id' => 'id',
        'name' => 'name',
        'price' => 'price',
        'stock' => 'stock',
        'weight' => 'weight',
        'measure_unit' => 'measure_unit'
    );

    var $filters = array('name' => '%name%');

    var $order = 'ASC';

    var $orderBy = 'name';

    var $return = array('*');

    function getSqlWhere() {
        $sql = parent::getSqlWhere();
        $sql .= parent::getSqlWhereFulltextSearch('fulltext', array('name', 'description'));
        return $sql;
    }

    function getSqlJoin() {
        return parent::getSqlJoin() .
            " AND active = 1" .
            " AND Products_description.fk_product_id = id" .
            " AND Products_custom.fk_product_id = id" .
            " AND lang = 'fr'";
    }

}

?>
