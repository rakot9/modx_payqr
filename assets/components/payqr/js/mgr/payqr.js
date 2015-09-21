var payqr = function (config) {
	config = config || {};
	payqr.superclass.constructor.call(this, config);
};
Ext.extend(payqr, Ext.Component, {
	page: {}, window: {}, grid: {}, tree: {}, panel: {}, combo: {}, config: {}, view: {}, utils: {}
});
Ext.reg('payqr', payqr);

payqr = new payqr();