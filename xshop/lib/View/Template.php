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
        // for blocks
        // FIXME: the correct tpl block end tag should be smartly guessed
        $s = preg_replace_callback('/<tpl for="(.+?)">(.+?)<\/tpl>/', array($this, "_applyfor"), $s);
        // if blocks
        $s = preg_replace_callback('/<tpl if="(.+?)">(.+?)<\/tpl>/', array($this, "_applyif"), $s);
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
    function _convert($var) {
        if (is_array($var)) $var = array_shift($var);
        // creates php variable string
        $parts = '$this->variables';
        $value = $this->variables;
        foreach(explode('.', $var) as $i => $member) {
            // handles reserved variables names (see _applyfor)
            if ($member == '#' && $i==0) return '$k';
            elseif ($member == '#') $parts .= '[$k]';
            elseif (!$member && $i==0) return '$v';
            // adds component to php variable string
            else $parts .= "['{$member}']";
        }
        return $parts;
    }
    function _applyvar($matches) {
        // TODO: implement string formatting (see Ext.Template & Ext.util.Format)
        $phpvar = $this->_convert($matches[1]);
        return "<?php if (isset({$phpvar})) print {$phpvar}; ?>";
    }
    function _applyif($matches) {
        $cond = $matches[1];
        $content = $matches[2];
        $phpcond = preg_replace_callback('/[a-zA-Z#]{1}[\w]*/', array($this, '_convert'), $cond);
        return "<?php if ({$phpcond}) { ?> {$content} <?php } ?>";
    }
    function _applyfor($matches) {
        // NOTE: cannot look through object members
        $var = $matches[1];
        $content = $matches[2];
        // creates foreach php variable
        $phpvar = $this->_convert($var);
        // prefixes 
        // TODO: handle parent.key as in ext
        $content = preg_replace('/{([^.#].*?)}/', '{'.$var.'.#.$1}', $content);
        return "<?php foreach($phpvar as \$k => \$v) { ?> {$content} <?php } ?>";
    }    
}

?>
