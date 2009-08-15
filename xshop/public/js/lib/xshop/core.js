if (!console) {
    console = {
        log: function() {},
        warn: function() {},
        info: function() {},
        debug: function() {}
    }
}

Ext.namespace('xs');
xs.debug = true;

Ext.namespace('xs.misc');
xs.misc.initSpinner = function() {
    //Ext.Ajax.on('beforerequest', this.showSpinner, this);
    //Ext.Ajax.on('requestcomplete', this.hideSpinner, this);
    //Ext.Ajax.on('requestexception', this.hideSpinner, this);
}

Ext.namespace('xs.cart');
xs.cart.update = function(id, action, params) {
    var action = action || 'add';
    var params = params || {};
    // TODO: stop event
    Ext.Ajax.request({
        url: '/shop/cart/' + action,
        method: 'POST',
        params: Ext.apply(params, {
            //debug: true,
            product: id
        }),
        success: function(responseObject) {
            var f = {duration:0.2};
            Ext.get('cart').load('/shop/views/cartoverview').fadeOut(f).fadeIn(f);
            Ext.get('cartview').load('/shop/views/cartview').fadeOut(f).fadeIn(f);
        },
        failure: function() {
            console.log('Product not added', id);
            // Not interrupting failure msg
        }
    });
}
xs.cart.add = function(id, qty) {
    var qty = qty || 1;
    this.update(id, 'add', {qty: qty})
}
xs.cart.substract = function(id, qty) {
    var qty = qty || 1;
    this.update(id, 'add', {qty: -qty})
}

xs.cart.remove = function(id) {
    this.update(id, 'delete');
}
