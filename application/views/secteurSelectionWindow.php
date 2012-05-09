secteurstore=Ext.create('Ext.data.Store', {
	storeId: 'secteurStore',
	fields:['id', 'nom'],
	autoLoad: true,
	proxy: {
		type: 'ajax',
		url: BASE_URL+'activite/secteur/listAll/nom',  // url that will load data
		actionMethods : {read: 'POST'},
		reader : {
			type : 'json',
			totalProperty: 'size',
			root: 'combobox'
		}
	}
});

Ext.define('MainApp.view.SecteurSelectionWindow', {
	extend	: 'Ext.window.Window',
	alias 	: 'widget.secteurselectionwindow',
	id	: 'secteurselectionwindow',
	title	: 'S&eacute;lectionnez un secteur',
	iconCls	: '',
	modal	: true,
	items	: [{
		xtype	: 'grid',
		id	: 'secteurallgrid',
		store	: 'secteurStore',
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
				//console.info('ok');
				selecteditem = Ext.getCmp('secteurallgrid').getSelectionModel().getSelection();
				idsecteur = selecteditem[0].get('id');
				
				//console.info(idsecteur);
				
				Ext.getStore('activiteStore').load({
					params: {"where[actiSecteur_id]": idsecteur}
				})
				Ext.getCmp('secteurselectionwindow').close();
				activiteselectionwindow = Ext.widget('activiteselectionwindow');              		
				activiteselectionwindow.show();
				
				
			}
		}
	}]
});
