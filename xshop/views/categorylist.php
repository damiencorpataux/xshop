<?php

require_once(dirname(__file__).'/../controllers/category.php');

// TODO: extend cartview, or vice-versa
class categorylist extends View {

    function handle() {
        $c = new category();
        $cats = $c->get();
        $tree = $this->tree($cats);
        $this->applytree($tree);
    }
    
    function applytree($tree) {
        $tl = new Template('categorylist.tpl');
        $ti = new Template('categorylist.item.tpl');
        $h = '';
        foreach($tree as $twig) {
            if (count($twig['children'])) $this->applytree($twig);
            $ti->a($twig);
            $h .= $ti->apply();
        }
        $tl->a('item', $h);
        $this->b($tl->apply());
    }
    
    function tree($categories) {
        $tree = array();
        foreach ($categories as $category) {
            if (is_null($category['fk_category_id'])) {
                $tree[$category['id']] = $category;
                $tree[$category['id']]['children'] = array();
            } else {
                $tree[$category['fk_category_id']]['children'] = $category;
            }
        }
        return $tree;
    }
}

?>
