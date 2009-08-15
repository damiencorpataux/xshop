<h1>{product.name}</h1>
<p>{product.description}</p>
<img src="/shop/assets/products/{product.picturefile}" style="width:200px"/>
<ul>
  <li>Prix: {product.price}</li>
  <li>Poids: {product.weight} {product.measure_unit}</li>  
  <li>Stock: {product.stock} pièces</li>  
</ul>
<ul>
  <li>Gluten: {product.measure_unit}</li>
  <li>Lactose: {product.measure_unit}</li>
  <li>Cholesterol: {product.measure_unit}</li>
</ul>

<a href="javascript:xs.cart.add({product.id})">Ajouter au panier</a>
<br/>
<a href="/shop/web/productlist">Retour à la liste des produits</a>

