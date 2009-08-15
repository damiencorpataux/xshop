<?php

require_once(dirname(__file__).'/../Util/Util.php');
require_once(dirname(__file__).'/Template.php');

class View {

    /*
     * Composing views
     */
    var $views = array();

    /*
     * Buffering string
     */
    var $buffer = '';

    function __construct() {
    }
    
    function handle() {
        // Implemented in subclasses
    }

    /*
     * Returns the string display of the given view name
     */
    function fetch($name) {
        return $this->load($name)->get();
    }

    /*
     * Loads a view 
     */
    static function load($name) {
        $file = dirname(__file__)."/../../views/{$name}.php";
        if (!file_exists($file)) throw new Exception('View not found');
        require_once($file);
        return /*$this->views[$name] = */new $name();
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
