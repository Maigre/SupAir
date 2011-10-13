Ext.define('MainApp.view.AdherentMain', {
	extend: 'Ext.panel.Panel',
    layout:{
		type:'vbox',
		align:'stretch'
	},
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
	alias : 'widget.adherentmain',
	id    : 'adherentmain',
	items: [{ //NORTH -> info famille + info inscription famille
		flex:1,
		defaults: {
			margins:5,
			frame: true,
			xtype: 'container'
		},
		items:[{
			id 		: 'infofamille_container',
			width	: 400,
			layout	: 'fit',
			items	: {
				xtype:'panel',
				frame: true
			}
		},{ 
			id 		: 'infoinscription_container',
			flex	:1,
			layout	: 'fit',
			items	: {
				xtype:'panel',
				frame: true
			}
		}]
	},{ //SOUTH -> adherent accordion + main panel
		flex:5,
		defaults: {
			margins:5,
			frame: true,
			xtype: 'container'
		},
		items:[{
			id 		: 'adherent_container',
			width	: 220,
			layout	: 'fit',
			items	: {
				xtype	:'panel',
				frame	: true,
				layout	: 'accordion'
			}
		},{
			id 		: 'main_container',
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