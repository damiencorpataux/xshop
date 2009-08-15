<?php

require_once(dirname(__file__).'/../lib/Controller/DbController.php');

class customer extends DbController {

    var $table = 'Customer';
    //var $table = '`Order`, Order_Product, Products';

    var $mapping = array(
        'id' => 'id',
        'name' => 'name',
        'surname' => 'surname',
    );

    var $return = array('*');

    function getSqlWhere() {
        return parent::getSqlWhere() .
            //" AND Products.lang = 'fr'";
            ""
    }

}

?>
