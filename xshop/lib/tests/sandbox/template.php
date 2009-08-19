<?php

error_reporting(E_ALL);

require_once(dirname(__file__).'/../../View/Template.php');

/*
 * Tests extjs XTemplate specification implementation
 */


// Tests variable substitution
class tt { var $member = 'Class member'; var $array = array(index => 'Object member array cell'); }
$tt = new tt();
$t = new Template();
$t->template = '<ul>' .
    '  <li>{var}</li>' .
    '  <li>{array.1}</li>' .
    '  <li>{array.assoc}</li>' .
    '  <li>{array.array.10}</li>' .
    '  <li>{object.member}</li>' .
    '  <li>{object.array.index}</li>' .
    '</ul>';
$t->a(array(
    'var' => 'Simple variable',
    'array' => array(
        1 => 'Numeric index array cell',
        assoc => 'String index array cell',
        "array" => array(10 => 'Numeric index nested array cell')
    ),
    'object' => $tt
));
//print $t->apply();


// Tests if loop
$t = new Template();
$t->template =
    '<tpl if="age < 10 & ages!= 2 && age">' .
        'Older than 10 (math sign: < )' .
    '</tpl>';
$t->a('age', 12);
//print $t->template.'<br/>';
//print $t->apply();


// Tests for loop
$t = new Template();
$t->template =
    '<ul>' .
    '<tpl for="iarray">' . // "." means to loop on each assign array (a.k.a root node) member
    '    <tpl if="#!=1">  <li>{#}: {.}</li>  </tpl>' .
    '</tpl>' .
    '</ul>' .
    "\n" .
    '<ul>' .
    '<tpl for="karray">' . // "." means to loop on each assign array (a.k.a root node) member
    '   <li>{#}: {kname} {u.fd.fds}</li>' .
    '</tpl>' .
    '</ul>';
$t->a('iarray', array(1, 2, 3, 10=>'the odd item'));
$t->a('karray', array(
    array(kname=>'some name'),
    array(kname=>'some other name')
));
print $t->apply();


?>
