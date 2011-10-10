Ext.define('MainApp.view.menu', {
	extend: 'Ext.panel.Panel',
	alias : 'widget.menupanel',
	id    : 'menupanel',
	height: 100,
  	//requires:['MainApp.view.tools.GridAlerteAllView'],
	//bodyPadding: 5,
	//collapsible: true,
	//collapseDirection: 'left',
	//floatable: true,
	layout: {
        type: 'accordion'//,
        //align: 'center',
        //padding: 5
    },
	initComponent: function() {
		var me = this;
		me.items = [
        	{
				xtype: 'panel',
				id: 'menuadherentpanel',
				title: 'Adherents',
				iconCls: 'user',
				items:[{
					xtype:'searchbar'
				}]
								
			},{
				xtype: 'panel',
				id: 'menuactivitepanel',
				title: 'Activites',
				iconCls: 'palette'								
			}];
					
		me.callParent(arguments);
  	}
});