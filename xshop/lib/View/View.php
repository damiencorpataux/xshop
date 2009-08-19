<?php

require_once(dirname(__file__).'/../Util/Util.php');
require_once(dirname(__file__).'/../Util/Auth.php');
require_once(dirname(__file__).'/Template.php');

// TODO: should a View be a Controller subclass?
class View {

    /*
     * Buffering string
     */
    var $buffer = '';

    var $params = array();

    function __construct($params = array()) {
        $this->params = $params;
    }

    function handle() {
        // Implemented in subclasses
    }

    /*
     * Returns the string display of the given view name
     */
    function fetch($name, $params = null) {
        return $this->load($name, $params ? $params : $this->params)->get();
    }

    /*
     * Loads a view
     */
    static function load($name, $params = array()) {
        $file = dirname(__file__)."/../../views/{$name}.php";
        if (!file_exists($file)) throw new Exception('View not found');
        require_once($file);
        return /*$this->views[$name] = */new $name($params);
    }

    /*
     * Buffers a string
     * Takes an arbitrary number of string params
     */
    function b($string) {
        $args = func_get_args();
        foreach($args as $arg) $this->buffer .= $arg;
    }

    /*
     * Applies and returns the string display of the view
     */
    function get() {
        $this->buffer = '';
        $this->handle();
        return $this->buffer;
    }

    function display() {
        print $this->get();
    }

}

?>
