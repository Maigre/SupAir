Ext.define('MainApp.view.AdherentDisplay', {
	extend		 : 'Ext.form.Panel',
	alias 		 : 'widget.adherentdisplay',
	id           : 'adherentdisplay',
	frame 		 : true,
	height		 : 200,
	//width 		 : 240,
	x     		 : 0,
	y     		 : 0,
	url   		 : BASE_URL+'data/plcontrol/save',
	frame 		 : false,
	title 		 : 'Junior Byles - R&eacute;f&eacute;rent',
	iconCls 	 : 'user',
	bodyStyle    : 'padding:5px 5px 0',
	method       : 'post',
	trackResetOnLoad : 'true',
	fieldDefaults: {
		msgTarget: 'side',
		labelWidth: 60,
		allowBlank:false//,
		//labelAlign : "top",
	},
	defaultType  : 'displayfield',
	/*defaults     : {
		anchor: '100%'
	},*/
	items 		 : [{
		fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
		//hideLabel : true,		
		name      : 'datenaissance',
		value	  : '04-12-73',
		cls       : 'cake',
		labelWidth: 20
		},{
		fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
		//hideLabel : true,		
		name      : 'email',
		value	  : 'junior.byles@supair.fr',
		cls       : 'email',
		labelWidth: 20
		},{
		fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; perso',
		//hideLabel : false,		
		name      : 'telportable',
		value	  : '0637483920',
		cls       : 'telephone'
		},{
		fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; fixe',
		//hideLabel : true,		
		name      : 'teldomicile',
		value	  : '0473829102',
		cls       : 'telephone'
		},{
		fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; pro',
		//hideLabel : true,		
		name      : 'telprofessionel',
		value	  : '0637281928',
		cls       : 'telephone'
		},{
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
				fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SVSP',
				//hideLabel : true,		
				name      : 'svsp',
				value	  : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
				cls       : 'pig',
				anchor	  : '96%'
			},{
				xtype: 'displayfield',
				fieldLabel: 'Allocataire',
				//hideLabel : true,		
				name      : 'svsp',
				value	  : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
				cls       : 'yes',
				anchor	  : '96%'
			}]},{
			xtype: 'container',
			columnWidth:0.5,
			layout: 'anchor',			
			items : 
			[{
				xtype: 'displayfield',
				fieldLabel: 'A. sortie',
				//hideLabel : true,		
				name      : 'autorisationsortie',
				value	  : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
				cls       : 'grasyes',
				anchor	  : '96%'
			},{
				xtype: 'displayfield',
				fieldLabel: 'N&deg;',
				labelWidth: 25,
				//hideLabel : true,		
				name      : 'noallocataire',
				value	  : '0458392039',
				//cls       : 'grasyes',
				anchor	  : '96%'
			}]}]},{
		fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sant&eacute;',
		//hideLabel : true,		
		name      : 'fichesanitaire',
		value	  : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
		cls       : 'pillyes',
		anchor	  : '96%'
		},{
		fieldLabel: 'Employeur',
		name      : 'employeur',
		value	  : 'BurningMan'
		//cls       : 'red',
		},{
		fieldLabel: 'N&deg; s&eacute;cu',
		name      : 'nosecu',
		value	  : '173129839849382'
		//cls       : 'red',
		}
	],
	initComponent: function() {
		this.callParent(arguments);
		Ext.define('Adherent', {
			extend: 'Ext.data.Model',
			fields: ['id', 'nom','prenom']
		});

		Ext.define('MainApp.store.AdherentStore', {
			extend: 'Ext.data.Store',
			model: 'Adherent',
			//requires: 'MainApp.model.PlModel',
			//model: 'MainApp.model.PlModel',
			proxy: {
				type: 'ajax',
				api: {
					read: BASE_URL+'user/adherent/show/1'    		
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
	}
});
