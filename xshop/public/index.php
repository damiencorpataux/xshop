<?php

session_start();

require_once(dirname(__file__).'/../lib/Util/Config.php');

require_once(dirname(__file__).'/../lib/Util/Route.php');
$r = new Router();
$r->add('web/', array(controller=>'web', view=>'welcome'));
$r->add('web/:view/:id', array(controller=>'web'));
$r->add('views/:view/:id', array(controller=>'views'));
$r->add(':controller/:action/:id');
$r->route();

?>
