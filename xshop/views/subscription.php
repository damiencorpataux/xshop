<?php

require_once(dirname(__file__).'/../controllers/customer.php');

// TODO: extend cartview, or vice-versa
class subscription extends View {

    function handle() {
        switch ($this->params['page']) {
            case 1:
            default:
                $t = new Template('subscription.tpl');
                $t->a('error', isset($this->params['error']) ? 'block' : 'none'); // FIXME: implement if in templating system
                $this->b($t->apply());
                break;
            case 2:
                // checks terms agreement & passwords match
                if (!isset($this->params['termsagree']) ||
                    $this->params['password'] !== $this->params['passconfirm'] ||
                    strlen($this->params['password']) < 6) {
                    header('Location: 1?error');
                }
                // adds customer
                $c = new customer($this->params);
                $r = $c->put();
                // Confirm or fail notice
                $t = new Template('subscription.confirmation.tpl');
                $this->b($t->apply());
                break;
        }
    }
}

?>
