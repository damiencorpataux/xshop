<div style="padding-bottom: 12px">
  <a href="/shop/web/product/{product.id}">
    <img src="/shop/assets/products/{product.picturefile}" style="float:left;width:115px;margin:0 10px 10px 0"/>
  </a>
  <h3>{product.quantity}x <a href="/shop/web/product/{product.id}">{product.name}</a></h2>
  <h3>{product.quantity}x {product.price} CHF</h2>
  <h1>{product.total} CHF</h1>
  <div style="clear:both"></div>  
  <a href="/shop/web/product/{product.id}">Afficher les détails</a>
  |
  <a href="javascript:xs.cart.add({product.id})">Ajouter une unité</a>
  |
  <a href="javascript:xs.cart.substract({product.id})">Retirer une unité</a>
  |
  <a href="javascript:xs.cart.remove({product.id})">Retirer le produit du panier</a>
  <br/>
  <hr />
</div>
