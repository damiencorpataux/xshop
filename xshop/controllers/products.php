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

    var $orderBy = 'price';

    var $return = array('*');

    function getSqlWhere() {
        $sql = parent::getSqlWhere();
        // Adds a multifields, fulltext where clause
        if (!isset($this->params['fulltext'])) return $sql;
        $fulltext = $this->params['fulltext'];
        if (!$fulltext) return $sql;
        $sql .= ' AND ( 0';
        foreach (explode(' ', $fulltext) as $text) {
            foreach (array('name', 'description') as $fullfield) {
                if (!empty($fulltext)) $sql .= " OR {$fullfield} LIKE '%{$text}%'";
            }
        }
        $sql .= ' )';
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
