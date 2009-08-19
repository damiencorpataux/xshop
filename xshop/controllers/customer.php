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

    function get() {
        // TODO: check auth
        return parent::get();
    }

    function put() {
        // TODO: check mail pattern
        // TODO: hash password: SHA1? MD5?
        return parent::put();
    }

    function delete() {
        // TODO: do not delete, set as inactive
        return parent::delete();
    }

    function isvalidauth() {
        $r = array_shift($this->get());
        return (count($r) && $r['password'] == $this->params['password']);
    }

    function isemailavailable() {
        $r = $this->get();
        return count($r) ? false : true;
    }

}

?>
