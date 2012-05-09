Ext.define('MainApp.view.ActiviteMain', {
	extend: 'Ext.panel.Panel',
	layout:{
		type:'vbox',
		align:'stretch'
	},
	bodyStyle: "background-image:url(interface/images/NASA1.jpg); background-repeat:no-repeat; background-position:center center;-moz-background-size: cover; -webkit-background-size: cover;-o-background-size: cover;background-size: cover;",
	defaults: {
		// applied to each contained panel
		defaults:{height:100},
		bodyStyle: 'margin:5px',
		layout:{
			type:'hbox',
			align:'stretch'
		},
		xtype: 'container'
	},
	//width: 300,
	//padding: 5,
	opacity:0,
	//height: 300,
	border:0,
	alias : 'widget.activitemain',
	id    : 'activitemain',
	items: [{ //NORTH -> info activite
		flex:1,
		defaults: {
			margins:5,
			frame: true,
			xtype: 'container'
		},
		items:[{
			id 	: 'infoactivite_container',
			xtype	: 'container',
			width	: 400,
			layout	: 'fit'/*,
			items	: {
				xtype:'familledisplay',
				frame: true
			}*/
		},{ 
			//id 	: 'infoinscription_container',
			xtype   : 'container',
			flex	:1,
			layout	: 'fit',
			items	: {
				xtype:'panel',
				frame: true
			}
		}]
	},{ //SOUTH -> session accordion + main panel
		flex:5,
		defaults: {
			margins:5,
			frame: true,
			xtype: 'container'
		},
		items:[{
			id 	: 'session_container',
			xtype   : 'panel', 
			width	: 220,
			layout	: 'accordion',
		    	layoutConfig: {
				// layout-specific configs go here
				hideCollapseTool : true
		    	}
		},{
			//id 	: 'main_container',
			flex	:1,
			layout	: 'fit',
			items	: {
				xtype:'panel',
				frame: true
			}
		}]
	}],
	initComponent: function() {
		var me = this;
		me.callParent(arguments);
	}
});
