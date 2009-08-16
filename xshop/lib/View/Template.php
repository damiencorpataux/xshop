<?php

class Template {

    var $template = null;
    var $variables = array();
    var $file = null;

    function __construct($name) {
        $this->file = dirname(__file__)."/../../templates/{$name}";
        if (file_exists($this->file)) {
            $this->template = file_get_contents($this->file);
        } else {
            throw new Exception("Template {$name} not found");
        }
        // Assigns commonly used values
        $this->a('_q', $_SERVER['QUERY_STRING']);
        // TODO: remove _dc param (mind ext requests)

    }

    function assign($name, $value = null) {
        if (is_array($name)) {
            foreach($name as $k => $v) $this->assign($k, $v);
            return;
        }
        $this->variables[$name] = $value;
    }
    function a($name, $value = null) {
        $this->assign($name, $value);
    }

    function clear() {
        $this->variables = array();
    }
    
    /*
     * Returns the string of the applied variables against the template
     */
    function apply() {
        return preg_replace_callback('/{([^{}]+?)}/', array($this, "applyvar"), $this->template);
    }
    function applyvar($matches) {
        $var = $matches[1];
        if (strpos($var, '.')) {
            $parts = explode('.', $var);
            $variables = $this->variables;
            foreach ($parts as $part) {
                if (isset($variables[$part])) $variables = $variables[$part];
                else if (isset($variables->$part)) $variables = $variables->$part;
            }
            return $variables;
        } else {
            return $this->variables[$var];
        }
    }

}

?>
