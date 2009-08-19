Ext.namespace('xs');
xs.debug = true;

Ext.namespace('xs.util');
xs.util.initSpinner = function() {
    //Ext.Ajax.on('beforerequest', this.showSpinner, this);
    //Ext.Ajax.on('requestcomplete', this.hideSpinner, this);
    //Ext.Ajax.on('requestexception', this.hideSpinner, this);
}
xs.util.update = function(nodeid, url) {
    var el = Ext.get(nodeid);
    if (!el) return;
    var f = {duration:0.5};
    //var url = url + 'debug'
    el.load(url)./*fadeOut(f).*/fadeIn(f);
}
xs.util.typeout = function(inputid, callback, options) {
    var options = Ext.apply({
        event: 'keyup',
        scope: null,
        timeout:200,
        empathy: true,
        minchar:2
    }, options);
    var el = Ext.get(inputid);
    if (!el) return;
    el.on(options.event, function(ev, el, options) {
        var timeout = options.timeout || 200;
        // adaptive timeout mode
        if (options.empathy) {
            this.diff = (new Date().getTime() - this.lasttime) || timeout;
            this.lasttime = new Date().getTime();
            timeout = this.diff < 3000 ? this.diff : 200;
        }
        if (this.getValue().length < options.minchar) return;
        // FIXME: what scope for the callback?
        if (!this.task) this.task = new Ext.util.DelayedTask(callback, this);
        else this.task.cancel();
        this.task.delay(timeout);
    }, null, options);
}

Ext.namespace('xs.util.validator');
xs.util.validator.rest = function(url, options) {
    Ext.Ajax.request({
        url: '/shop/rest/customer/isemailavailable/',
        method: 'POST',
        params:  {
            email: this.getValue()
        },
        success: function(r) {
            console.log(r.responseText);
        },
        failure: function() {
            //console.log('Product not added', id);
            // Not interrupting failure msg
        }
    });
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
            debug: true
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
xs.customer.isemailavailable = function(email) {

}
