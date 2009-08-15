<div style="padding-bottom: 12px">
  <img src="/shop/assets/products/{product.picturefile}" style="float:left"/>
  <h2><a href="/shop/web/product/{product.id}">{product.name}</a></h2>
  <p>
    {product.description}
  </p>
  <ul>
    <li>Poids: {product.weight} {product.measure_unit}</li>
  </ul>
  <!-- <div style="clear:both"></div> -->
  <h2>{product.price} CHF</h2>
  <a href="javascript:xs.cart.add({product.id})">Ajouter au panier</a>
  <br/>
  <a href="/shop/web/product/{product.id}">Afficher les détails</a>
  <hr />
</div>
