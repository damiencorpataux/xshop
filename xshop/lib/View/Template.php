<?php

class Template {

    var $template = null;
    var $variables = array();

    function __construct($name=null) {
        if ($name) $this->load($name);
        // Assigns commonly used values
        $this->a('_q', $_SERVER['QUERY_STRING']);
        // TODO: remove _dc param (mind ext requests)
    }

    function load($name) {
        $file = dirname(__file__)."/../../templates/{$name}";
        if (file_exists($file)) {
            $this->template = file_get_contents($file);
        } else {
            throw new Exception("Template {$name} not found");
        }
    }

    function assign($name, $value=null) {
        if (is_array($name)) {
            foreach($name as $k => $v) $this->assign($k, $v);
            return;
        }
        $this->variables[$name] = $value;
    }
    function a($name, $value=null) {
        $this->assign($name, $value);
    }

    function clear() {
        $this->variables = array();
    }

    /*
     * Returns the string of the applied variables against the template
     */
    function apply() {
        $s = $this->template;
        //$s = preg_replace_callback('/<tpl ([^>]+?)>/', array($this, "_apply"), $s);
        $s = preg_replace_callback('/{([^{}]+?)}/', array($this, "_apply"), $s);
        return $s;
    }
    function _apply($matches) {
        $var = $matches[1];
        if (substr($var, 0, 2) == 'if') return $this->_applytplif($var, $this->variables);
        elseif (substr($var, 0, 3) == 'for') return $this->_applytplfor($var, $this->variables);
        else return $this->_applyvar($var, $this->variables);
    }
    function _applyvar($index, $variables) {
        if ($p = strpos($index, '.')) {
            $followup = substr($index, $p+1);
            $index = substr($index, 0, $p);
            $variables = $this->_applyvar($index, $variables);
            if (is_array($variables)) return $this->_applyvar($followup, $variables);
            if (is_object($variables)) return $this->_applyvar($followup, $variables);
        } else {
            if (is_array($variables)) return $variables[$index];
            if (is_object($variables)) return $variables->$index;
            if (is_string($variables)) return $variables;
            throw new Exception("Could not handle variable type");
        }
    }
    function _applytplif($index, $variables) {
        print $index;
    }
}

?>
