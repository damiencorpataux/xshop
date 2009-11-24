Ext.namespace('xs');
xs.debug = true;

Ext.namespace('xs.util');
xs.util.initSpinner = function() {
    // TODO: make a neat spinner on requests
    //Ext.Ajax.on('beforerequest', this.showSpinner, this);
    //Ext.Ajax.on('requestcomplete', this.hideSpinner, this);
    //Ext.Ajax.on('requestexception', this.hideSpinner, this);
}
xs.util.update = function(nodeid, url) {
    var el = Ext.get(nodeid);
    if (!el) return;
    var f = {duration:0.5};
    //var url = url + 'debug'
    // FIXME: make an Ext.Ajax.request() with instant slow-fadeout
    //        and a fadein on success; on error, put back last content
    el.load(url)./*fadeOut(f).*/fadeIn(f);
    // TODO: disable link during update & make a spinner or mouse waiting icon
}
xs.util.arrize = function(value) {
    // use arguments to concat non-null values and arrays and return a consitant array
    if (value instanceof Array) return value
    else return [value];
}
xs.util.display = function(el, visible) {
    if (el = Ext.get(el)) return el.setVisibilityMode(Ext.Element.DISPLAY).setVisible(visible);
}
xs.util.show = function(el) {
    xs.util.display(el, true);
}
xs.util.hide = function(el) {
    xs.util.display(el, false);
}
xs.util.typeout = function(inputid, callback, options) {
    var options = Ext.apply({
        event: 'keyup',
        scope: null,
        timeout: 200,
        empathy: false,
        minchar: 0
    }, options);
    // FIXME: had to arrize inputid to attach multiple typeouts to the same element
    var el = Ext.get(xs.util.arrize(inputid));
    if (!el) return;
    el.on(options.event, function(ev, el, options) {
        if (ev.button >= 32 && ev.button <= 39) return;
        var timeout = options.timeout || 333;
        // adaptive timeout mode
        if (options.empathy) {
            this.diff = (new Date().getTime() - this.lasttime) || timeout;
            this.lasttime = new Date().getTime();
            timeout = this.diff < 1000 ? this.diff : timeout;
        }
        // calls latest event callback
        if (this.getValue().length < options.minchar) return;
        this.lastlength = this.getValue().length;
        if (!this.task) this.task = new Ext.util.DelayedTask(callback, this);
        else this.task.cancel();
        this.task.delay(timeout);
    }, el, options);
}

Ext.namespace('xs.validator');
xs.validator.settip = function(options) {
    // TODOS:
    /// accept an array of options
    /// accept array in options.pass and options.fail
    var options = Ext.apply({}, options);
    options.pass = xs.util.arrize(options.pass);
    options.fail = xs.util.arrize(options.fail);
    // hide tips
    Ext.each(options.pass.concat(options.fail), function(e) {
        xs.util.hide(e);
    })
    // bind listener to options.input field
    xs.util.typeout(options.input, function() {
        // call options.validator to test is valid
        var pass = options.validator(Ext.get(options.input).getValue());
        for (var j=0; j<options.pass.length; j++) xs.util.display(options.pass[j], pass);
        for (var j=0; j<options.fail.length; j++) xs.util.display(options.fail[j], !pass);
    }, {empathy: true});
}
xs.validator.email = function(value) {
    this.emailRE = this.emailRE || new RegExp(/^[^\s]+?@[^\s]+?\.[\w]{2,5}$/);
    var matches = this.emailRE.exec(value);
    return matches ? true : false;
}
xs.validator.rest = function(url, inputid, options) {
    var params = {};
    params[inputid] = Ext.get(inputid).getValue();
    // TODO: make a sync request
    Ext.Ajax.request({
        url: url,
        method: 'POST',
        params: params,
        success: function(r) {
            //console.log(r.responseText);
        },
        failure: function() {
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
