Ext.namespace('xs');
xs.debug = true;

Ext.namespace('xs.util');
xs.util.initSpinner = function() {
    //Ext.Ajax.on('beforerequest', this.showSpinner, this);
    //Ext.Ajax.on('requestcomplete', this.hideSpinner, this);
    //Ext.Ajax.on('requestexception', this.hideSpinner, this);
}
xs.util.update = function(id, url) {
    var f = {duration:0.125};
    if (e = Ext.get(id)) e.load(url).fadeOut(f).fadeIn(f);
}

Ext.namespace('xs.cart');
xs.cart.update = function(action, params) {
    var action = action || 'add';
    var params = params || {};
    // TODO: stop event
    Ext.Ajax.request({
        url: '/shop/rest/cart/' + action,
        method: 'POST',
        params: Ext.apply(params, {
            //debug: true
        }),
        success: function(r) {
            xs.util.update('cart', '/shop/views/cartoverview');
            xs.util.update('cartview', '/shop/views/cartview');
        },
        failure: function() {
            //console.log('Product not added', id);
            // Not interrupting failure msg
        }
    });
}
xs.cart.add = function(id, qty) {
    var qty = qty || 1;
    this.update('add', {product: id, qty: qty})
}
xs.cart.substract = function(id, qty) {
    var qty = qty || 1;
    this.update('add', {product: id, qty: -qty})
}
xs.cart.remove = function(id) {
    this.update('delete', {product: id});
}
xs.cart.empty = function(id) {
    //this.update('delete', {customer: 1});
}

Ext.namespace('xs.customer');
xs.customer.emailCheck = function(email) {
    Ext.Ajax.request({
        url: '/shop/rest/customer/isemailavailable/',
        method: 'POST',
        params:  {
            email: email
        },
        success: function(r) {
            console.log(r);
        },
        failure: function() {
            //console.log('Product not added', id);
            // Not interrupting failure msg
        }
    });
}
