Ext.define('TranchesQf', {
	extend: 'Ext.data.Model',
	fields: ['id', 'QF','exExercice_id']
});

tranchesQfstore= new Ext.data.Store({
	storeId: 'tranchesqfStore',
	model: 'TranchesQf',
	//autoLoad: true,
	autoSync: true,
	proxy: {
		type: 'ajax',
		api: {
	    		read	: BASE_URL+'exercice/tranchesqf/listAll',
	    		update	: BASE_URL+'exercice/tranchesqf/savewithroot',
	    		create	: BASE_URL+'exercice/tranchesqf/savewithroot',
	    		destroy : BASE_URL+'exercice/tranchesqf/deletewithroot'
	    	},
		actionMethods : {read: 'POST', update: 'POST'},
		reader: {
	    		type: 'json',
	    		root: 'data',
	    		successProperty: 'success'
	    	},
		writer: {
			type: 'json',
			encode: 'false',
			writeAllFields: false,
			root: 'data',
	    		successProperty: 'success'
		}
	},
	listeners: {
		'update': function(store, records) {
			console.info('datachanged');
			grid = Ext.getCmp('tranchesqfgrid');
			console.info(grid);
			grid.store.load();
			grid.getView().refresh();
		}
	}          			
});

var rowEditing = Ext.create('Ext.grid.plugin.RowEditing', {
        clicksToMoveEditor: 1,
        autoCancel: false
});

Ext.define('MainApp.view.tranchesQfForm', {
	extend		: 'Ext.panel.Panel',
	alias 		: 'widget.tranchesqfform',
	//id         	   : 'activiteform',
	frame 		: true,
	height		: 240,
	width 		: 250,
	x     		: 0,
	y     		: 0,
	bodyStyle    	: 'padding:5px 5px 0',
	method  	: 'post',
	trackResetOnLoad: 'true',
	/*fieldDefaults	: {
		msgTarget : 'side',
		labelWidth: 80,
		anchor	  : '96%',
		allowBlank:false
	},*/
	//defaultType  	: 'textfield',
	items 		: [{
			xtype	: 'grid',
			title	: 'Tranches QF',
			//hideHeaders 	: true,
			id	: 'tranchesqfgrid',
			store	: Ext.getStore('tranchesqfStore'),
			tbar: [{
				text: 'Ajouter une tranche',
				handler : function(){
					// Create a model instance
					var r = Ext.create('TranchesQf', {
						min: '0',
						max: '0',
					});
					console.info(this);
					var tranchesqfStore = Ext.getStore('tranchesqfStore');
					row_number = tranchesqfStore.count();
					tranchesqfStore.insert(row_number, r);
					rowEditing.startEdit(row_number, 0);
				}
			}, {
				itemId: 'removeTranche',
				text: 'Enlever une tranche',
				iconCls: 'cancel',
				handler: function() {
					var row = Ext.getCmp('tranchesqfgrid').getSelectionModel();
					rowEditing.cancelEdit();
					
					var tranchesqfStore = Ext.getStore('tranchesqfStore');
					tranchesqfStore.remove(row.getSelection());
					if (tranchesqfStore.getCount() > 0) {
						row.select(0);
					}
				},
				disabled: true
			}],
			columns	: [
				{ header: 'Min',  dataIndex: 'min', flex:1,
					editor: {
						xtype: 'numberfield',
						allowBlank: false,
						minValue: 0,
						maxValue: 100000
					}
				},
				{ header: 'Max', dataIndex: 'max', flex:1}
			],
			height	: 200,
			width	: '100%',
			scroll	: 'vertical',
			plugins	: [rowEditing],
			listeners: {
				'selectionchange': function(view, records) {
					Ext.getCmp('tranchesqfgrid').down('#removeTranche').setDisabled(!records.length);
				}
			}
		},{
			xtype	  	: 'container',
			layout	  	: {
				type  : 'hbox',
				align : 'middle',
				pack  : 'end'
			},
			items: {
				xtype 	: 'button',
				text	: 'OK',
				formBind: true, //only enabled once the form is valid
				disabled: true,
				handler	: function() {
					
				}
			}
		}
	]
});
	

