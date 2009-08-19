<?php

session_start();
require_once(dirname(__file__).'/../lib/Util/Config.php');

require_once(dirname(__file__).'/../lib/Util/Route.php');
$r = new Router();
$r->add('/', array(redirect=>'/shop/web/'));
$r->add('web/', array(redirect=>'/shop/web/welcome/'));
$r->add('web/product/:id', array(controller=>'web', view=>'product')); // TODO: remove this, always use id param in views (instead of page,step,...)
$r->add('rest/:restcontroller/:restaction/:id', array(controller=>'restservice'));
$r->add(':controller/:view/:page');
$r->add(':controller/:view/page/:page');
$r->add(':controller/:view/step/:page');
$r->add(':controller/:view/:id');//:id'); // TODO: implement * wildcard
$r->route();

?>
