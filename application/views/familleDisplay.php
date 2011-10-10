Ext.define('MainApp.view.FamilleDisplay', {
	extend		 : 'Ext.form.Panel',
	alias 		 : 'widget.familledisplay',
	id           : 'familledisplay',
	frame 		 : true,
	height		 : 170,
	ui			 : 'bubble',
	//width 		 : 240,
	x     		 : 0,
	y     		 : 0,
	url   		 : BASE_URL+'data/plcontrol/save',
	frame 		 : true,
	title 		 : 'Famille Byles',
	iconCls 	 : 'group',
	bodyStyle    : 'padding:5px 5px 0',
	method       : 'post',
	trackResetOnLoad : 'true',
	fieldDefaults: {
		msgTarget: 'side',
		labelWidth: 60,
		allowBlank:false
	},
	defaultType  : 'displayfield',
	/*defaults     : {
		anchor: '100%'
	},*/
	items 		 : [{
		fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
		//hideLabel : true,		
		name      : 'adresse1',
		value	  : '10, rue des charmettes',
		cls       : 'house',
		labelWidth: 20
		},{
		fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
		//hideLabel : true,		
		name      : 'adresse2',
		value	  : '64, bd des canuts',
		cls       : 'house',
		labelWidth: 20
		},{
		fieldLabel: '',
		hideLabel : true,		
		name      : 'ville',
		value	  : 'Lyon'
		//cls       : 'red'
		},{
		xtype: 'container',
		anchor: '100%',
		layout: 'column',
		items:[{
			xtype: 'container',
			columnWidth:0.6,
			layout: 'anchor',
			//height: 15,		
			items : 
			[{
				xtype: 'displayfield',
				fieldLabel: 'Ext&eacute;rieur',
				//hideLabel : true,		
				name      : 'exterieur',
				value	  : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
				cls       : 'yes',
				anchor	  : '96%',
				labelWidth: 80
				},{
				xtype: 'displayfield',
				fieldLabel: 'Bon vacances',
				//hideLabel : true,		
				name      : 'bonvacance',
				value	  : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
				cls       : 'yes',
				anchor	  : '96%',
				labelWidth: 80
			}]},{
			xtype: 'container',
			columnWidth:0.4,
			layout: 'anchor',
			//height: 15,		
			items : 
			[{
				xtype: 'displayfield',
				fieldLabel: 'CCAS',
				//hideLabel : true,		
				name      : 'CCAS',
				value	  : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
				cls       : 'yes',
				anchor	  : '96%',
				labelWidth: 40
				},{
				xtype: 'displayfield',
				fieldLabel: 'Q.F',
				//hideLabel : true,		
				name      : 'Q.F',
				value	  : '150',
				anchor	  : '96%',
				labelWidth: 40
				//cls       : 'yes'
			}]}]},{
			fieldLabel: 'Groupe',
			//hideLabel : true,		
			name      : 'groupe',
			value	  : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
			cls       : 'yes'
		}
	],
	initComponent: function() {
		this.callParent(arguments);
		
		Ext.define('Famille', {
			extend: 'Ext.data.Model',
			fields: ['id', 'adresse1','adresse2']
		});
		
		this.famillestore= new Ext.data.Store({
			storeId: 'famillestore',
			model: 'Famille',
			//requires: 'MainApp.model.PlModel',
			//model: 'MainApp.model.PlModel',
			proxy: {
				type: 'ajax',
				api: {
					read: BASE_URL+'famille/show/1'    		
				},
				actionMethods : {read: 'POST'},   	
				reader: {
					type: 'json',
					root: 'data',
					totalProperty: 'size',
					successProperty: 'success'
				}
			},
			baseParams: {
				idPl:'' 
			}
		});
		
		
		var nbstore = Ext.data.StoreManager.getCount();
		console.info(nbstore);
	}
});
