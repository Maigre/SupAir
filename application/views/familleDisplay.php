Ext.define('MainApp.view.FamilleDisplay', {
	extend		: 'Ext.form.Panel',
	alias 		: 'widget.familledisplay',
	id        	: 'familledisplay',
	frame 		: true,
	height		: 170,
	//ui	 	: 'bubble',
	width 		: 200,
	x     		: 0,
	y     		: 0,
	url   		: BASE_URL+'data/plcontrol/save',
	frame 		: true,
	title 		: '',
	iconCls 	: 'group',
	bodyStyle    	: 'padding:5px 5px 0',
	method       	: 'post',
	trackResetOnLoad: 'true',
	fieldDefaults	: {
		msgTarget: 'side',
		labelWidth: 60,
		allowBlank:false
	},
	defaultType  	: 'displayfield',
	items 		: [{
		xtype: 'container',
		anchor: '100%',
		layout: 'column',
		items:[{
			xtype: 'container',
			columnWidth:0.5,
			layout: 'anchor',
			//height: 15,		
			items : 
			[{
				xtype: 'displayfield',
				fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',		
				name      : 'adresse1',
				value	  : '10, rue des charmettes',
				cls       : 'house',
				anchor	  : '96%',
				labelWidth: 20
				},{
				xtype: 'displayfield',
				hideLabel : true,		
				name      : 'adresse2',
				value	  : '3ème étage',
				anchor	  : '96%',
				labelWidth: 20
				},{
				xtype: 'displayfield',
				fieldLabel: '',
				hideLabel : true,		
				name      : 'villedisplay',
				value	  : 'Lyon 69001',
				anchor	  : '96%'
				}
			]},{
			xtype: 'container',
			columnWidth:0.3,
			layout: 'anchor',	
			items : 
			[{
				xtype: 'displayfield',
				fieldLabel: 'Groupe',		
				name      : 'groupe',
				value	  : ''
			},{
				xtype: 'displayfield',
				fieldLabel: 'Ext&eacute;rieur',
				name      : 'ext',
				value	  : '',
				anchor	  : '96%',
				labelWidth: 80
			},{
				xtype: 'displayfield',
				fieldLabel: 'Bon vacances',		
				name      : 'bonv',
				value	  : '',
				anchor	  : '96%',
				labelWidth: 80
			}
			]},{
			xtype: 'container',
			columnWidth:0.2,
			layout: 'anchor',	
			items :	[{
				xtype: 'displayfield',
				fieldLabel: 'CCAS',		
				name      : 'ccas',
				value	  : '',
				anchor	  : '96%',
				labelWidth: 40
			},{
				xtype: 'displayfield',
				fieldLabel: 'Q.F',		
				name      : 'qf',
				value	  : '150',
				anchor	  : '96%',
				labelWidth: 40
			}]}]}
	],
	initComponent: function() {
		this.callParent(arguments);
		
		Ext.define('Famille', {
			extend: 'Ext.data.Model',
			fields: ['id', 'adresse1','adresse2','ext','qf','bonv','ccas','userVille_nom','userVille_cp',{name:'villedisplay', mapping: 'userVille_nom + " " + obj.userVille_cp'}]
		});
		
		this.famillestore= new Ext.data.Store({
			storeId: 'famillestore',
			model: 'Famille',
			proxy: {
				type: 'ajax',
				api: {
					read: BASE_URL+'user/famille/show/1'    		
				},
				actionMethods : {read: 'POST'},   	
				reader: {
					type: 'json',
					root: 'data',
					totalProperty: 'size',
					successProperty: 'success'
				}
			}/*,
			baseParams: {
				id:'' 
			}*/
		});

	}
});
