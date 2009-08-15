<?php

require_once(dirname(__file__).'/../lib/Controller/DbController.php');

class order extends DbController {

    var $table = '`Order`';
    //var $table = '`Order`, Order_Product, Products';

    var $mapping = array(
        'id' => 'id',
        'customer' => '`Order`.fk_customer_id',
    );

    var $return = array('*');

    // TODO: on delete: set cancelled_date
    
    function getCurrent() {
        $sql = "SELECT ".implode(', ', $this->return)." FROM {$this->maintable}";
        $sql .= $this->getSqlWhere() .
            " AND processed_date is null" .
            " ORDER BY creation_date DESC LIMIT 1";
        return $this->query($sql);
    }
}

?>
