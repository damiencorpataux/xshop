<?php

class Template {

    var $template = null;
    var $variables = array();
    var $tmpdir = '/tmp/';

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
        // complies template
        $s = $this->template;
        // if blocks
        $s = preg_replace_callback('/<tpl if="(.+?)">(.+?)<\/tpl>/', array($this, "_applyif"), $s);
        // for blocks
        //$s = preg_replace_callback('/<tpl (.+?)="(.+?)">(.+?)<\/tpl>/', array($this, "_apply"), $s);
        // variables
        $s = preg_replace_callback('/{([^\s{}]+?)}/', array($this, "_applyvar"), $s);
        // processes compiled template
        $file = $this->tmpdir.uniqid('xtpl_', true).'.tplc';
        file_put_contents($file, $s);
        ob_start();
        //print file_get_contents( $file);
        require($file);
        $s = ob_get_contents();
        ob_end_clean();
        unlink($file);
        return ($s);
    }
    /*
     * Returns a php variable string
     */
    function _convertvar($var) {
        if (is_array($var)) $var = array_shift($var);
        // fingers variable type
        $parts = '$this->variables';
        $value = $this->variables;
        foreach(explode('.', $var) as $i => $member) {
            if (is_array($value)) {
                $parts .= "['{$member}']";
                $value = $value[$member];
            } elseif (is_object($value)) {
                $parts .= "->{$member}";
                $value = $value->$member;
            }
            else throw new Exception("Could not handle variable type");
        }
        return $parts;
    }
    function _applyvar($matches) {
        // TODO: implement string formatting (see Ext.Template & Ext.util.Format)
        $var = $this->_convertvar($matches[1]);
        return "\n<?php print {$var}; ?>\n";
    }
    function _applyif($matches) {
        $variables = $this->variables;
        $cond = $matches[1];
        $content = $matches[2];
        $php = preg_replace_callback('/[a-zA-Z]{1}[\w]*/', array($this, '_convertvar'), $cond);
        return "<?php if ($php) { ?>\n{$content}\n<?php } ?>";
    }
    
}

?>
