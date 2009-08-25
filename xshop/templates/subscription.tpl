<script>
Ext.onReady(function() {
    // checks email pattern validity
    xs.validator.settip({
        input: 'email',
        fail: 'email_invalid',
        //validator: xs.validator.email
        validator: function(value) {
            // FIXME: put this logc in settip() and make it activable through an option (e,g verbose:false)
            var valid = xs.validator.email(value);            
            if (valid) this.validonce = true;
            return !this.validonce || valid;
        },
        verbose: false
    });
    // checks email availability
    xs.validator.settip({
        input: 'email',
        pass: 'email_available',
        validator: function(value) {
            return xs.validator.email(value) && true
        }
    });
    // checks email pattern validity
    xs.validator.settip({
        input: 'email',
        pass: 'email_unavailable',
        validator: function(value) {
            return xs.validator.email(value) && !true
        }
    });
/*
// FIXME: use this settip options object for more flexibility at once:
[
    {validator: function(value) {}, show: ['id1'], hide: ['id2']}
]
more complex:
[{
    validator: function(value) {},
    show: ['email_available']
}, {
    
}]
*/
    // checks passwords match
    xs.validator.settip({
        input: ['password', 'passconfirm'],
        fail: ['passconfirm_error'],
        validator: function() {
            return Ext.get('password').getValue() == Ext.get('passconfirm').getValue();
        }
    });

});
</script>


<h1>Inscription</h1>

<div class="error message" style="display:{error}">
  Formulaire invalide
</div>

<p>S'inscrire? En un clin d'oeil! Votre adresse vous sera demandée lors
de votre première commande.</p>

<div id="form"></div>
<form action="2" method="POST">
<table>
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
      <span id="email_invalid" class="warning tip">Email incomplet</span>
      <span id="email_unavailable" class="error tip">Email déjà pris</span>
      <span id="email_available" class="ok tip">Email disponible</span>
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
      <span id="passconfirm_error" class="error tip">Vérifiez votre mot de passe</span>
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
      <br/>
      <input type="submit" name="" value="Bienvenue">
      <br/>
      <a href="/shop/web/">Abandonner l'inscription</a>
    </td>
  </tr>
</table>
</form>
