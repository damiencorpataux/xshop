<?php

require_once(dirname(__file__).'/../lib/Controller/DbController.php');

class category extends DbController {

    var $table = 'Category';//, Category_description';//, Category_Product';
    //var $table = '`Order`, Order_Product, Products';

    var $mapping = array(
        'id' => 'id',
        'name' => 'name',
        'desc' => 'description',
    );

    var $return = array('*');

    function getSqlWhere() {
        return parent::getSqlWhere() ."";
            //" AND Category.id = Category_description.fk_category_id" .
            //" AND Category.id = Category_Product.fk_category_id" .
            //" AND Category_description.lang = 'fr'";
    }

}

?>
