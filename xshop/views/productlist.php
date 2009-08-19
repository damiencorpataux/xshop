<?php

require_once(dirname(__file__).'/../controllers/products.php');

class productlist extends View {

    function handle() {
        // search
        $t = new Template('search.tpl');
        $t->a('fulltext', $this->params['fulltext']);
        $this->b($t->apply());
        // create products controller
        $c = new products(array(
            fulltext => $this->params['fulltext'],
        ));
        // compute page
        $pagelength = 3;
        $ntotal = array_shift($c->count());
        $page = $this->params['page'] ? $this->params['page'] : 1;
        if ((int)$page < 1) throw new Exception("Invalid page number: {$page}");
        $offset = ($page-1)*$pagelength;
        $limit = $pagelength;
        $assign = array(
            // FIXME: implement php control structure in templates / or use extjs <tpl ... > specs for compatibility
            currentpage => $page,
            firstpage => $page > 2 ? 1 : '',
            previouspage => $page > 1 ? $page-1 : '',
            nextpage => ceil($ntotal/$pagelength) > $page ? $page+1 : '',
            lastpage => ceil($ntotal/$pagelength) > $page+1 ? ceil($ntotal/$pagelength) : ''
        );
        // display list
        $c->params = array_merge($c->params, array( // TODO: use a Controller->addparam()
            offset => $offset,
            limit => $limit
        ));
        $t = new Template('productlist.listitem.tpl');
        $h = '';
        $products = $c->get();
        foreach ($products as $product) {
            $t->clear();
            $t->assign('product', $product);
            $h .= $t->apply();
        }
        // wrapper
        $t = new Template('productlist.tpl');
        $t->a($assign);
        $t->a('products', $h);
        $t->a('n', count($products));
        $t->a('ntotal', $ntotal);
        $this->b($t->apply());
    }
}

?>
