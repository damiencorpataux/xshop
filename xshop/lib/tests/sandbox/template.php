<?php

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
print $t->apply();


// Tests if loop
$t = new Template();
$t->template =
    '<tpl if="age > 10">' .
        'Older than 10' .
    '</tpl>';
$t->a('age', 9);
print $t->apply();


// Tests for loop
/*
$t = new Template();
$t->template = '<ul>' .
    '<tpl for=".">' . // "." means to loop on each assign array (a.k.a root node) member
    '    <li>{#} {name}</li>' .
    '</tpl>' .
    '<ul>';
$t->a();
*/

?>