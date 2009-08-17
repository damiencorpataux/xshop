<h1>Inscription</h1>
<p>S'inscrire? En un clin d'oeil! Votre adresse vous sera demandée lors
de votre première commande.</p>

<div style="display:{error};text-align:center;color:#a00">
  Formulaire invalide
</div>
<form action="2" method="POST">
<table>
  <tr>
    <th></th>
    <td></td>
  </tr>
  <!--
  <tr>
    <th>Compliment</th>
    <td>
      <input type="radio" name="" value=""/> Mademoiselle
      <br/>
      <input type="radio" name="" value=""/> Monsieur
      <br/>
      <input type="radio" name="" value=""/> Madame
    </td>
  </tr>
  -->
  <tr>
    <th><label for="name">Prénom</label>*</th>
    <td>
      <input type="text" name="name" id="name">
    </td>
  </tr>
  <tr>
    <th><label for="surname">Nom</label>*</th>
    <td>
      <input type="text" name="surname" id="surname">
    </td>
  </tr>
  <tr>
    <th><label for="email">E-mail</label>*</th>
    <td>
      <input type="text" name="email" id="email">
    </td>
  </tr>
  <tr>
    <th><label for="password">Mot de passe</label>*</th>
    <td>
      <input type="password" name="password" id="password">
    </td>
  </tr>
  <tr>
    <th><label for="passconfirm">Confirmer le mot de passe</label>*</th>
    <td>
      <input type="password" name="passconfirm" id="passconfirm">
    </td>
  </tr>
  <tr>
    <th>&nbsp;</th>
    <td>
      <input type="checkbox" name="termsagree" id="confirm">&nbsp;<label for="confirm">J'accepte les conditions générales de ventes</label>*
      <br/>
      <input type="checkbox" name="newsletter" id="newsletter">&nbsp;<label for="newsletter">Je désire être tenu au courant par la newsletter</label>
    </td>
  </tr>
  <tr>
    <th>&nbsp;</th>
    <td>
      <input type="submit" name="" value="Bienvenue">
      <br/>
      <a href="/shop/web/">Abandonner l'inscription</a>
    </td>
  </tr>
</table>
</form>
