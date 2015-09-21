payqr.page.Home = function (config) {
	config = config || {};
	Ext.applyIf(config, {
		components: [{
			xtype: 'payqr-panel-home', renderTo: 'payqr-panel-home-div'
		}]
	});
	payqr.page.Home.superclass.constructor.call(this, config);
};
Ext.extend(payqr.page.Home, MODx.Component);
Ext.reg('payqr-page-home', payqr.page.Home);