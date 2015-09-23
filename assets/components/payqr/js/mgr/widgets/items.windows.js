payqr.window.CreateItem = function (config) {
	config = config || {};
	if (!config.id) {
		config.id = 'payqr-item-window-create';
	}
	Ext.applyIf(config, {
		title: _('payqr_item_create'),
		width: 550,
		autoHeight: true,
		url: payqr.config.connector_url,
		action: 'mgr/item/create',
		fields: this.getFields(config),
		keys: [{
			key: Ext.EventObject.ENTER, shift: true, fn: function () {
				this.submit()
			}, scope: this
		}]
	});
	payqr.window.CreateItem.superclass.constructor.call(this, config);
};
Ext.extend(payqr.window.CreateItem, MODx.Window, {
	getFields: function (config) {
		return [{
                        xtype: 'hidden',
			name: 'name',
			id: config.id + '-name'
                }, {
                        xtype: 'textarea',
			fieldLabel: _('payqr_item_description'),
			name: 'description',
			id: config.id + '-description',
			height: 150,
			anchor: '99%'
                }, {
                        xtype: 'textfield',
			fieldLabel: _('payqr_item_htmlvalue'),
			name: 'htmlvalue',
			id: config.id + '-htmlvalue',
			anchor: '99%'
                }, {
			xtype: 'xcheckbox',
			boxLabel: _('payqr_item_active'),
			name: 'active',
			id: config.id + '-active',
			checked: true,
		}];
	}

});
Ext.reg('payqr-item-window-create', payqr.window.CreateItem);

payqr.window.UpdateItem = function (config) {
	config = config || {};
        
        payqr.connectors_data = config.record.object;
        
	if (!config.id) {
		config.id = 'payqr-item-window-update';
	}
	Ext.applyIf(config, {
		title: _('payqr_item_update'),
		width: 550,
		autoHeight: true,
		url: payqr.config.connector_url,
		action: 'mgr/item/update',
		fields: this.getFields(config),
		keys: [{
			key: Ext.EventObject.ENTER, shift: true, fn: function () {
				this.submit()
			}, scope: this
		}]
	});
	payqr.window.UpdateItem.superclass.constructor.call(this, config);
};

Ext.extend(payqr.window.UpdateItem, MODx.Window, {
        
	getFields: function (config) {
		return [{
			xtype: 'hidden',
			name: 'id',
			id: config.id + '-id',
		}, {
                        xtype: 'hidden',
			name: 'name',
			id: config.id + '-name'
                }, {
                        xtype: config.record.object.htmltype == "select"? 'doodle-combo-units' : 'textfield' ,
                        fieldLabel: _('payqr_item_htmlvalue') ,
                        name: 'htmlvalue' ,
                        hiddenName: 'htmlvalue' ,
                        anchor: '100%'
                }, {
			xtype: 'textfield',
			fieldLabel: _('payqr_item_description'),
			name: 'description',
			id: config.id + '-description',
			anchor: '99%',
		}, {
			xtype: 'xcheckbox',
			boxLabel: _('payqr_item_active'),
			name: 'active',
			id: config.id + '-active',
		}];
	}
});
Ext.reg('payqr-item-window-update', payqr.window.UpdateItem);

payqr.combo.Units = function(config) {
    
    config = config || {};
    
    var possible_values = Ext.decode(payqr.connectors_data.htmlpossiblevalues);
    var selectArrayFields = new Array();
    
    for(var iIter in possible_values)
    {
        var selectRow = new Array();
        selectRow.push(iIter);
        selectRow.push(possible_values[iIter]);
        selectArrayFields.push(selectRow);
    }
    
    Ext.applyIf(config,{
        store: new Ext.data.ArrayStore({
            id: 0
            ,fields: ['unit','display']
            ,data: selectArrayFields
        })
        ,mode: 'local'
        ,displayField: 'display'
        ,valueField: 'unit'
    });
    payqr.combo.Units.superclass.constructor.call(this, config);
};
Ext.extend(payqr.combo.Units, MODx.combo.ComboBox);
Ext.reg('doodle-combo-units',payqr.combo.Units);