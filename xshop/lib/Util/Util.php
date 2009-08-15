<?php

class Util {

    static function load($name) {
        $file = $name{0} == "/" ? $file : dirname(__file__)."/{$name}";
        if (file_exists($file)) {
            return $file;
        } else {
            throw new Exception('File not found');
        }
    }
    
    static function listdir($name) {
    }


    /*
     * LOGGING & DEBUGGING
     */    
    static function log($object) {}
        
    // Prints a string in pre mode
    static function debug($title) {
        print '<pre style="background-color:#ffc; border:2px dashed #ee0; padding:10px; font-size:11px">';
        foreach (func_get_args() as $i => $arg) {
            if ($i == 0) {
                print "<h1>{$title}</h1>";
                continue;
            }
            print is_string($arg) ? $arg.'<br/>' : '<pre>'.print_r($arg, true).'</pre>';
            
        }
        print '</pre>';
    }

    static function exception($object) {}
}

?>
