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
					iconCls: 'add',
					listeners: {
						click: function() {
							
							//nouvellefamilleform=Ext.getCmp('nouvellefamilleform');
							//if (!nouvellefamilleform){
								console.info('okwidget');
								nouvellefamilleform=Ext.widget('nouvellefamilleform');
							//}
							nouvellefamilleform.show();
							
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
			},{
				xtype: 'panel',
				id: 'menuoutilspanel',
				title: 'Outils',
				iconCls: 'outils',
				items:[{
					xtype: 'button',
					text : 'Calendrier',
					iconCls: 'calendrier',
					listeners: {
						click: function() {
							calendrier_window=Ext.widget('calendrier_window');
							calendrier_window.show();
						}		
					}			
				},{
					xtype: 'button',
					text : 'Nouvelle famille',
					listeners: {
						click: function() {
														
						}		
					}			
				},{
					xtype: 'button',
					text : 'Nouvelle famille',
					listeners: {
						click: function() {
														
						}		
					}			
				}]
			}];
					
		me.callParent(arguments);
  	}
});
