facturestore = new Ext.data.Store({
	storeId: 'facturestore',
	fields: ['id', 'numero', 'valeur', 'commentaire'],
	autoLoad: true,
	proxy: {
		type: 'ajax',
		url: BASE_URL+'activite/reduction/listAll',  // url that will load data
		actionMethods : {read: 'POST'},
		reader : {
			type : 'json',
			totalProperty: 'size',
			root: 'combobox'
		}
	}
}); 

lignecomptablestore = new Ext.data.Store({
	storeId: 'lignecomptablestore',
	fields: ['id', 'numero', 'valeur', 'commentaire'],
	autoLoad: false,
	proxy: {
		type: 'ajax',
		url: BASE_URL+'activite/reduction/listAll',  // url that will load data
		actionMethods : {read: 'POST'},
		reader : {
			type : 'json',
			totalProperty: 'size',
			root: 'combobox'
		}
	}
}); 

versementstore = new Ext.data.Store({
	storeId: 'versementstore',
	fields: ['id', 'numero', 'valeur', 'commentaire'],
	autoLoad: false,
	proxy: {
		type: 'ajax',
		url: BASE_URL+'activite/reduction/listAll',  // url that will load data
		actionMethods : {read: 'POST'},
		reader : {
			type : 'json',
			totalProperty: 'size',
			root: 'combobox'
		}
	}
}); 

Ext.define('MainApp.view.ComptaFamillePanel', {
	extend	: 'Ext.panel.Panel',
	alias 	: 'widget.comptafamillepanel',
	id      : 'comptafamillepanel',
	title	: 'Comptes de la famille',
	frame 	: true,
	anchor	: '96%',
	layout	: {
		type	: 'vbox',
		align 	: 'stretch'
	},	
	items	:[{
		flex	: 2,
		xtype	: 'grid',
		id	: 'facture_famille_grid',
		title	: 'Facture de la famille',
		store	: facturestore,
		columns	: [
			{ header: 'Num&eacute;ro',  dataIndex: 'numero', width:200},
			{ header: 'Valeur', dataIndex: 'valeur', flex: 1},
			{ header: 'Info', dataIndex: 'commentaire', flex: 1}
		],
		resizable : true,
		minHeight : 50,
		//forceFit: true,
		//width: 1000,
		margin	: 5,
		frame	: true
	},{
		flex	: 2,
		xtype	: 'grid',
		id	: 'ligne_comptable_famille_grid',
		title	: 'Ligne comptable de la famille',
		store	: lignecomptablestore,
		columns	: [
			{ header: 'Num&eacute;ro',  dataIndex: 'numero', width:200},
			{ header: 'Valeur', dataIndex: 'valeur', flex: 1},
			{ header: 'Info', dataIndex: 'commentaire', flex: 1}
		],
		resizable : true,
		minHeight : 50,
		//forceFit: true,
		//width: 1000,
		margin	: 5,
		frame	: true
	},{
		flex	: 2,
		xtype	: 'grid',
		id	: 'versement_famille_grid',
		title	: 'Versement de la famille',
		store	: versementstore,
		columns	: [
			{ header: 'Num&eacute;ro',  dataIndex: 'numero', width:200},
			{ header: 'Valeur', dataIndex: 'valeur', flex: 1},
			{ header: 'Info', dataIndex: 'commentaire', flex: 1}
		],
		resizable : true,
		minHeight : 50,
		//forceFit: true,
		//width: 1000,
		margin	: 5,
		frame	: true
	}]
});
