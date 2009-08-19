<?xml version="1.0" encoding="UTF-8"?>
<html>
  <head>
    <title>Next shop</title>
    <meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
    <link rel="stylesheet" href="/shop/css/main.css" type="text/css" />
    <script type="text/javascript" src="/shop/js/lib/ext-core/ext-core.js"></script>
    <script type="text/javascript" src="/shop/js/lib/xshop/core.js"></script>
  </head>
  <body>
    <div id="wrapper">
      <div id="header">
        <img src="/shop/assets/layout/logo.jpg" style="float:left; height:75px;">
        <div class="text">Next shop</div>
        <div class="motto">Think simple</div>
        <div style="clear:both"></div>
        <div style="text-align:right">
          <a href="/shop/web/login/">Identification</a>
          |
          <a href="/shop/web/logout/">Déconnexion</a>
          |
          <a href="/shop/web/subscription/">Inscription</a>
          <br/>
          <b>{customername}</b>
        </div>
      </div>
      <div id="content">
        {center}
      </div>
      <div id="additional">
        <div id="cart">
          {cart}
        </div>
        <br/><br/><br/>
        <h2>Related content</h2>
        {related}
      </div>
      <div style="clear:both"></div>
      <div id="footer">
        <a href="#">Contact</a> | <a href="#">Credits</a> | <a href="#">Impressum</a>
        <br />
        &copy; Next shop, tous droits réservés.
      </div>
    </div>
  </body>
</html>

