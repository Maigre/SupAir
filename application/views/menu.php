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
					xtype: 'button',
					text : 'Nouvelle famille',
					listeners: {
						click: function() {
							
							nouvellefamilleform=Ext.getCmp('nouvellefamilleform');
							if (!nouvellefamilleform){
								nouvellefamilleform=Ext.widget('nouvellefamilleform');
							}
							nouvellefamilleform.show();
							/*console.info('ok');
							familleform=Ext.getCmp('familleform');
							if (!familleform){
								familleform= new Ext.widget('familleform');
							}
							famillecontainer=Ext.getCmp('famillecontainer');
							famillecontainer.removeAll();
							famillecontainer.add(familleform);*/
						}		
					}			
				},{
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