<?php

require_once(dirname(__file__).'/../controllers/customer.php');

// TODO: extend cartview, or vice-versa
class login extends View {

    function handle() {
        switch ($this->params['page']) {
            case 1:
            default:
                $t = new Template('login.tpl');
                $t->a('error', isset($this->params['error']) ? 'block' : 'none'); // FIXME: implement if in templating system
                $this->b($t->apply());
                break;
            case 2:
                // checks customer password
                $c = new customer($this->params);
                $r = $c->isvalidauth();
                // merge session cart with user cart
                // TODO
                // user checkin
                if ($r) {
                    Auth::checkin(array_shift($c->get()));
                    header('Location: /shop/web/');
                } else {
                    header('Location: 1?error');
                }
                break;
        }
    }
}

?>
