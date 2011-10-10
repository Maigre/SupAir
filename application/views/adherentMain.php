Ext.define('MainApp.view.AdherentMain', {
	extend: 'Ext.panel.Panel',
    layout:{
		type:'hbox',
		align:'stretch'
	},
    //width: 300,
    padding: 5,
    opacity:0,
    //height: 300,
    border:0,
	alias : 'widget.adherentmain',
	id    : 'adherentmain',
	items: [{
		xtype: 'panel',
		layout: {
			type: 'vbox',
			flex: 'even'
		},
		width: '215',
		items:[{
        	xtype: 'familledisplay'
        },{
        	xtype: 'panel',
        	flex: 1,
        	layout: 'accordion',
        	height: 200,
        	items:[{
				xtype: 'adherentdisplay'
			},{
				xtype: 'panel',
				title: 'Mirza Byles - Conjointe',
				iconCls: 'user_female'
			},{
				xtype: 'panel',
				title: 'Penelope Byles',
				iconCls: 'user_female'
			},{
				xtype: 'panel',
				title: 'Luke Byles',
				iconCls: 'user'
			}]
        }]
	}],
	
	initComponent: function() {
		var me = this;
		me.callParent(arguments);
	}
});