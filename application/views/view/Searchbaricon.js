Ext.define('MainApp.view.Searchbaricon', {
	extend: 'Ext.Img',
	alias : 'widget.searchbaricon',
	src: 'app/images/icons/find.png',
	height: 17,
	margin: 1.5,
	border: 5,
	
	bodyStyle:{"background-color":"red"}, 
	initComponent: function() {
		var me = this;
		me.callParent(arguments);
	}
});


