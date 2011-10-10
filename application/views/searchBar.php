Ext.define('MainApp.view.tools.SearchBar', {
	extend: 'Ext.form.field.ComboBox',
	alias : 'widget.searchbar',
	displayField: 'todisplay',
	valueField: 'id',
	enableKeyEvents: true,
	//loadingText: 'Recherche...',
	//typeAhead: true,
	minChars: 1,
    //renderTo: Ext.getBody(),
    border: 0,
	width: 150,
	height: 30,
	queryParam: 'text_search',
	typeAheadDelay : 250,
	hideTrigger: true,
	
	initComponent: function() {
		var searchstore = Ext.create('Ext.data.Store', {
			//extend: 'Ext.data.Store',
			fields: ['id', 'todisplay'], //put more field here like 'idfamille'
			proxy: {
				type: 'ajax',
				api: {
					read: BASE_URL+'data/search/sc',
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

