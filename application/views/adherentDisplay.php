Ext.define('Adherent', {
	extend: 'Ext.data.Model',
	fields: ['id', 'nom','prenom','noalloc',{name:'sexe', mapping: 'sexe'},'naissance','sante','svsp','autosortie','email','portable','fixe','bureau','employeur']
});



Ext.define('MainApp.view.AdherentDisplay', {
	extend		 : 'Ext.form.Panel',
	alias 		 : 'widget.adherentdisplay',
	id           	 : 'adherentdisplay',
	frame 		 : true,
	statut		 : '',
	height	 	 : 200,
	width 		 : 200,
	x     		 : 0,
	y     		 : 0,
	//url   		 : BASE_URL+'data/plcontrol/save',
	frame 		 : false,
	title 		 : 'Junior Byles - R&eacute;f&eacute;rent',
	iconCls 	 : 'user',
	bodyStyle    : 'padding:0px 0px 0',
	method       : 'post',
	trackResetOnLoad : 'true',
	fieldDefaults: {
		msgTarget: 'side',
		labelWidth: 60,
		allowBlank:false//,
		//labelAlign : "top",
	},
	defaultType  : 'displayfield',
	defaults     : {
		margin: '0px 5px'
	},
	items	: [{
			xtype:'toolbar',
			margin: '0px 0px 5px 0px',
			items: [
			'->',
			{
			    text: '',
			    iconCls: 'outils',
			    menu: {
				xtype: 'menu',
				//plain: true,
				/*items: {
				    xtype: 'buttongroup',
				    title: 'User options',
				    //columns: 2,
				    defaults: {
				        xtype: 'button',
				        scale: 'large',
				        iconAlign: 'left'
				    },*/
				    items: [{
				        text: 'Inscrire &agrave; une activit&eacute;',
				        iconCls: 'palette',
				        width: 'auto',
					handler: function() {
						activiteselectionwindow = Ext.widget('activiteselectionwindow');              		
						activiteselectionwindow.show();
					}
				    },{
				        iconCls: 'money',
				        colspan: 2,
				        text: 'Acc&eacute;der aux factures',
				        scale: 'small',
				        width: 'auto'
				    },{
				        iconCls: 'cancel',
				        colspan: 2,
				        text: 'Supprimer cet adh&eacute;rent',
				        scale: 'small',
				        width: 'auto'
				    }]
				//}
			    }
			}]
		},{
			fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
			//hideLabel : true,		
			name      : 'naissance',
			value	  : '04-12-73',
			cls       : 'cake',
			labelWidth: 25
		},{
			fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
			//hideLabel : true,		
			name      : 'email',
			value	  : 'junior.byles@supair.fr',
			cls       : 'email',
			labelWidth: 25
		},{
			fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; perso',
			//hideLabel : false,		
			name      : 'portable',
			value	  : '0637483920',
			cls       : 'telephone'
		},{
			fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; fixe',
			//hideLabel : true,		
			name      : 'fixe',
			value	  : '0473829102',
			cls       : 'telephone'
		},{
			fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; pro',
			//hideLabel : true,		
			name      : 'bureau',
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
					//cls       : 'pigyes',
					anchor	  : '96%'
				},{
					xtype: 'displayfield',
					fieldLabel: 'Allocataire',
					//hideLabel : true,		
					name      : 'allocataire',
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
					name      : 'autosortie',
					value	  : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
					//cls       : 'grasyes',
					anchor	  : '96%'
				},{
					xtype: 'displayfield',
					fieldLabel: 'N&deg; Alloc',
					labelWidth: 25,
					//hideLabel : true,		
					name      : 'noalloc',
					value	  : '0458392039',
					//cls       : 'grasyes',
					anchor	  : '96%'
			}]}]},{
				fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sant&eacute;',
				//hideLabel : true,		
				name      : 'sante',
				value	  : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
				//cls       : 'pillyes',
				anchor	  : '96%',
				tpl : [
					'<tpl if={sante}" == 0;">',
					'<img src="interface/images/icons/cross.png">',
					'</tpl>',
					'<tpl if={sante}" == 1;">',
					'<img src="interface/images/icons/accept.png">',
					'</tpl>'
				]
			},{
				fieldLabel: 'Employeur',
				name      : 'employeur',
				value	  : ''
				//cls       : 'red',
			},{
				fieldLabel: 'N&deg; s&eacute;cu',
				name      : 'nosecu',
				value	  : '173129839849382'
				//cls       : 'red',
			}
	],
	initComponent: function() {
		var me=this;
		this.on('render', function(){
			if (me.statut=='enfant'){ //enfant, cacher certains champs
				var fieldtohide= ['bureau','fixe','noalloc','allocataire','employeur'];
				Ext.each(fieldtohide, function(tohide) {
					me.getForm().findField(tohide).hidden = true;
					console.info(me.getForm().findField(tohide));
				})
			}			
		});
		this.callParent(arguments);
		this.store= adherentstore= new Ext.data.Store({
			storeId: 'adherentstore',
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
			}
		});
		
	}
});
