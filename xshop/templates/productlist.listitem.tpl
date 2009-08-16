<div style="padding-bottom: 12px">
  <a href="/shop/web/product/{product.id}">
    <img src="/shop/assets/products/{product.picturefile}" style="float:left;width:115px;margin: 0 10px 10px 0"/>
  </a>
  <h2><a href="/shop/web/product/{product.id}">{product.name}</a></h2>
  <p>
    {product.description}
  </p>
  <ul>
    <li>Poids: {product.weight} {product.measure_unit}</li>
  </ul>
  <!-- <div style="clear:both"></div> -->
  <h2>{product.price} CHF</h2>
  <div style="clear:both"></div>
  <a href="/shop/web/product/{product.id}">Afficher les détails</a>
  |
  <a href="javascript:xs.cart.add({product.id})">Ajouter au panier</a>
  <hr />
</div>
