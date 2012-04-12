activitestore=Ext.create('Ext.data.Store', {
	storeId: 'activiteStore',
	fields:['id', 'nom'],
	autoLoad: true,
	proxy: {
		type: 'ajax',
		url: BASE_URL+'activite/activite/listAll/nom',  // url that will load data
		actionMethods : {read: 'POST'},
		reader : {
			type : 'json',
			totalProperty: 'size',
			root: 'combobox'
		}
	}
});

Ext.define('MainApp.view.ActiviteSelectionWindow', {
	extend	: 'Ext.window.Window',
	alias 	: 'widget.activiteselectionwindow',
	id	: 'activiteselectionwindow',
	title	: 'S&eacute;lectionnez une activit&eacute',
	iconCls	: 'palette',
	modal	: true,
	items	: [{
		xtype	: 'grid',
		id	: 'activiteallgrid',
		store	: 'activiteStore',
		height  : 220,
		width	: 200,
		border	: false,
		frame	: false,
		columns: [
			{ header: 'Nom',  dataIndex: 'nom', width:200},
			{ header: 'id', dataIndex: 'id', hidden: true}
		]
	},{
		xtype	  : 'container',
		layout	  : {
			type  : 'hbox',
			align : 'middle',
			pack  : 'end'
		},
		items: {
			xtype : 'button',
			text: 'OK',
			formBind: true, //only enabled once the form is valid
			//disabled: true,
			handler: function() {
				selecteditem=Ext.getCmp('activiteallgrid').getSelectionModel().getSelection();
				loadinscriptionpanel(selecteditem[0].get('id'));
			}
		}
	}]
});
