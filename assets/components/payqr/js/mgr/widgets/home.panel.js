payqr.panel.Home = function (config) {
	config = config || {};
	Ext.apply(config, {
		baseCls: 'modx-formpanel',
		layout: 'anchor',
		/*
		 stateful: true,
		 stateId: 'payqr-panel-home',
		 stateEvents: ['tabchange'],
		 getState:function() {return {activeTab:this.items.indexOf(this.getActiveTab())};},
		 */
		hideMode: 'offsets',
		items: [{
			html: '<h2>' + _('payqr') + '</h2>',
			cls: '',
			style: {margin: '15px 0'}
		}, {
			xtype: 'modx-tabs',
			defaults: {border: false, autoHeight: true},
			border: true,
			hideMode: 'offsets',
			items: [{
				title: _('payqr_items'),
				layout: 'anchor',
				items: [{
					html: _('payqr_intro_msg'),
					cls: 'panel-desc',
				}, {
					xtype: 'payqr-grid-items',
					cls: 'main-wrapper',
				}]
			}]
		}]
	});
	payqr.panel.Home.superclass.constructor.call(this, config);
};
Ext.extend(payqr.panel.Home, MODx.Panel);
Ext.reg('payqr-panel-home', payqr.panel.Home);
