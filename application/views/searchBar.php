Ext.define('MainApp.view.tools.SearchBar', {
	extend: 'Ext.form.field.ComboBox',
	alias : 'widget.searchbar',
	displayField: 'todisplay',
	valueField: 'userFamille_id',
	enableKeyEvents: true,
	//loadingText: 'Recherche...',
	//typeAhead: true,
	minChars: 1,
	//renderTo: Ext.getBody(),
	border: 0,
	width: 140,
	height: 30,
	queryParam: 'text',
	typeAheadDelay : 250,
	hideTrigger: true,
	listeners:{
		select: {fn : function(a,b){
			ID_FAMILLE=a.getValue();
			displayfamille();
			//console.info(a.getValue());
			//console.info(b.getValue());
			//console.info(this);
			//ID_FAMILLE=1;
			//displayfamille(ID_FAMILLE);
			//var famillestore = Ext.data.StoreManager.lookup('famillestore');
			//
			//this.store.url=BASE_URL+'user/adherent/search'
			//this.store.load();
			
			//this.store.on('load', function(database){
				
			//	console.info(database);
				/*var familledisplay = Ext.getCmp('familledisplay');
				if (!familledisplay){
					var familledisplay = Ext.widget('familledisplay');
				}	
				var rec= database.getAt(0);
				familledisplay.getForm().loadRecord(rec);*/
				//displayfamille(1);				
			//});
		}}
	},
	
	initComponent: function() {
		var searchstore = Ext.create('Ext.data.Store', {
			//extend: 'Ext.data.Store',
			fields: ['id', 'nom', 'prenom', 'userFamille_id', {name:'todisplay', mapping: 'prenom + " " + obj.nom'}], //put more field here like 'idfamille'
			proxy: {
				type: 'ajax',
				api: {
					read: BASE_URL+'user/adherent/search',
				},
				actionMethods : {read: 'POST'},   	
				reader: {
					type: 'json',
					root: 'data',
					successProperty: 'success'
				}
			},
			baseParams: {
					text_search:'' 
			}
		});
		
		this.store = searchstore;
		
		var me = this;
		me.callParent(arguments);
	}
});

