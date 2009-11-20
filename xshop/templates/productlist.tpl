<h1 style="float:left">Liste des produits</h1>
<div style="text-align:right">
  .
  <a href="{firstpage}?{_q}">{firstpage}</a>
  ...
  <a href="{previouspage}?{_q}">{previouspage}</a>
  ..
  {currentpage}
  ..
  <a href="javascript:xs.util.update('content', '/shop/views/productlist/page/{nextpage}?{_q}')">{nextpage}</a>
  ...
  <a href="{lastpage}?{_q}">{lastpage}</a>
  .
</div>
<br/>
<br/>
{products}
{n} produits sur {ntotal}
