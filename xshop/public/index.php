<?php

session_start();

require_once(dirname(__file__).'/../lib/Util/Config.php');

require_once(dirname(__file__).'/../lib/Util/Route.php');
$r = new Router();
$r->add('web/', array(controller=>'web', view=>'welcome', lang=>'fr', page=>1));
//$r->add('web/:lang', array(controller=>'web', view=>'welcome'));
$r->add('rest/:controller/:action/:id');
$r->add(':controller/productlist/:page', array(view=>'productlist')); // FIXME: this should not happen
$r->add('web/cartview', array(controller=>'web', view=>'cartview')); // FIXME: remove this, it's just so that it works until tomorrow
$r->add('web/:page', array(controller=>'web', view=>'productlist')); // FIXME: remove this, it's just so that it works until tomorrow
$r->add(':controller/:view/:id');//:id'); // TODO: implement * wildcard
$r->add(':controller/:view/page/:page');
$r->route();

?>
