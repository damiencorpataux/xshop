<?php

require_once(dirname(__file__).'/../lib/Controller/DbController.php');

class customer extends DbController {

    var $table = 'Customer';
    //var $table = '`Order`, Order_Product, Products';

    var $mapping = array(
        'id' => 'id',
        'name' => 'name',
        'surname' => 'surname',
        'email' => 'email',
        'password' => 'password',
        'lang' => 'lang'
    );
    
    var $put = array('name', 'surname', 'email', 'password');

    var $return = array('*');

    function getSqlWhere() {
        return parent::getSqlWhere() .
            //" AND Products.lang = 'fr'";
            "";
    }

    function put() {
        // TODO: check mail pattern
        // TODO: hash password: SHA1? MD5?
        return parent::put();
    }
    
    function isemailavailable() {
        $r = $this->get();
        return count($r) ? true : false;
    }

}

?>
