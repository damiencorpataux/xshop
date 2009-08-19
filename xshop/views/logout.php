<?php

require_once(dirname(__file__).'/../controllers/customer.php');

// TODO: extend cartview, or vice-versa
class logout extends View {

    function handle() {
        Auth::checkout();
        header('Location: /shop/web/');
    }
}

?>
