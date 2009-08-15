<?php

class Config {

    function debug() {
        if (isset($_GET['debug'])) return true;
        else return false;
    }

    function get($directive) {
        if (!isset($_SERVER['xs']['config'])) self::load();
        return $_SERVER['xs']['config'][$directive];
    }

    function load($name = null) {
        if (!$name) $name = 'default';
        $this->file = dirname(__file__)."/../../config/{$name}.ini";
        if (!file_exists($this->file)) throw new Exception('Config file not found');
        $_SERVER['xs']['config'] = parse_ini_file($this->file);
    }

}

?>
