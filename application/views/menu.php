Ext.define('MainApp.view.menu', {
	extend: 'Ext.panel.Panel',
	alias : 'widget.menupanel',
	id    : 'menupanel',
	height: 100,
	title : '',
	layout: {
        	type: 'accordion'        	
    	},
    	layoutConfig: {
		// layout-specific configs go here
		hideCollapseTool : true
    	},
	initComponent: function() {
		var me = this;
		me.items = [
        	{
				xtype	: 'panel',
				id	: 'menuadherentpanel',
				title	: 'Adherents',
				iconCls	: 'user',
				bodyStyle: "background-color:#B6D0DB;",
				layout	: {
					type	: 'vbox',
					align	: 'center'
				},				
				items:[{
					xtype	: 'button',
					text 	: 'Nouvelle famille',
					width 	: 110,
					iconCls	: 'add',
					margin	: 2,
					listeners: {
						click: function() {
							
							nouvellefamilleform=Ext.getCmp('nouvellefamilleform');
							if (!nouvellefamilleform){
								//console.info('okwidget');
								nouvellefamilleform=Ext.widget('nouvellefamilleform');
							}
							nouvellefamilleform.show();
							
						}		
					}			
				},{
					xtype:'searchbar'
				}]			
			},{
				xtype	: 'panel',
				id	: 'menuactivitepanel',
				title	: 'Activites',
				iconCls	: 'palette',
				bodyStyle: "background-color:#B6D0DB;",
				layout	: {
					type	: 'vbox',
					align	: 'center'
				},				
				items:[{
					xtype	: 'button',
					text 	: 'Nouvelle activit&eacute;',
					width 	: 110,
					iconCls	: 'add',
					margin	: 2,
					listeners: {
						click: function() {
							
							nouvelleactivite_window= new Ext.window.Window({
								id	: 'nouvelleactivite_window',
								title	: 'Nouvelle Activit&eacute;',
								iconCls	: 'palette',
								modal	: true,
								items	: [{
									xtype	: 'activiteform',
									height  : 220,
									border	: false,
									frame	: false
								}]
							});
							nouvelleactivite_window.show();
							
						}		
					}			
				}]							
			},{
				xtype	: 'panel',
				id	: 'menuoutilspanel',
				title	: 'Outils',
				iconCls	: 'outils',
				bodyStyle: "background-color:#B6D0DB;",
				layout	: {
					type	: 'vbox',
					align	: 'center'
				},
				items	:[{
					xtype	: 'button',
					text 	: 'Calendrier',
					iconCls	: 'calendrier',					
					width 	: 110,
					margin	: 2,
					listeners: {
						click: function() {
							calendrier_window=Ext.widget('calendrier_window');
							calendrier_window.show();
						}		
					}			
				}]
			}];
					
		me.callParent(arguments);
  	}
});

Ext.define('MainApp.view.nouvelenfantButton', {
	extend 	  : 'Ext.Button',
	text      : 'Nouvel Enfant',
	id	  : 'nouvelenfant_button',
	alias	  : 'widget.nouvelenfant_button',
	width 	: 110,
	iconCls	: 'add',
	renderTo  : Ext.getBody(),
	arrowAlign: 'bottom',
	listeners : {
		click: function() {
			nouveladherent_window= new Ext.window.Window({
				id	: 'nouveladherent_window',
				title	: 'Nouvel Enfant',
				modal	: true,
				items	: [{
					xtype	: 'adherentform',
					border	: false,
					margin	: '0 0 5 0',
					tools	: [],
					statut  : 3	
				}]
			});
			nouveladherent_window.show();
		}		
	}
});

Ext.define('MainApp.view.nouveladherentButton', {
	extend 	  : 'Ext.Button',
	text      : 'Adh&eacute;rent',
	id	  : 'nouveladherent_button',
	width 	: 110,
	iconCls	: 'add',
	alias	: 'widget.nouveladherent_button',
	renderTo  	: Ext.getBody(),
	arrowAlign	: 'right',
	scale      : 'medium',
	iconAlign  : 'left',
	//width      : 50,
	menu      	: [
		{text: 'Nouveau Conjoint',handler: function(){
			nouveladherent_window= new Ext.window.Window({
				id	: 'nouveladherent_window',
				title	: 'Nouveau Conjoint',
				modal	: true,
				items	: [{
					xtype	: 'adherentform',
					height  : 390,
					border	: false,
					//margin	: '0 0 5 0',
					tools	: [],
					statut  : 2	
				}]
			});
			nouveladherent_window.show();
		}, iconCls : 'user'},
		{text: 'Nouvel Enfant',handler: function(){
			nouveladherent_window= new Ext.window.Window({
				id	: 'nouveladherent_window',
				title	: 'Nouvel Enfant',
				modal	: true,
				items	: [{
					xtype	: 'adherentform',
					border	: false,
					margin	: '0 0 5 0',
					tools	: [],
					statut  : 3	
				}]
			});
			nouveladherent_window.show();
		}, iconCls : 'user'}
	]
});
