<?php

/* TODO: Auth decorator for any class?
 * This decorator would catch any call made to itself,
 * and redirects it to the held decorated class after
 * auth check.
 * PHP functions: this::__get/set/call(),
 *                func_get_args()
 *                func_call...()
 */

class Auth {

    // universal-auth-attributes => user-specific-attributes mapping
    static $mapping = array(
        id => 'id',
        role => 'id',
    );

    static function get() {
        return isset($_SESSION['xs']['auth']) ? $_SESSION['xs']['auth'] : false;
    }
    static function getid() {
        if (!isset($_SESSION['xs']['auth']) || !isset($_SESSION['xs']['auth']['id']))
            throw new Exception("No user checked in");
        return $_SESSION['xs']['auth']['id'];
    }

    static function checkin($data) {
        unset($_SESSION['xs']['auth']);
        $_SESSION['xs']['auth'] = array();
        $_SESSION['xs']['auth']['data'] = $data;
        $_SESSION['xs']['auth']['checkindate'] = mktime();
        foreach (self::$mapping as $authattr => $userattr) {
            $_SESSION['xs']['auth'][$authattr] = $data[$userattr];
        }
    }

    static function checkout() {
        if (isset($_SESSION['xs']['auth'])) unset($_SESSION['xs']['auth']);
    }

}

?>
