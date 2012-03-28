displayactivite= function(idactivite){

	
	Ext.Ajax.request({
		url: BASE_URL+'activite/activite/loadActivite/'+idactivite,
		method : 'POST',
		success: function(response){
			var response = Ext.JSON.decode(response.responseText);
			
			//ACTIVITE
			Ext.getCmp('infofamille_container').removeAll(true);
			Ext.getCmp('adherent_container').removeAll(true);
			var activitedisplay = Ext.getCmp('activitedisplay');
			if (!activitedisplay){
				var activitedisplay = Ext.widget('activitedisplay');
			}	
			
			Ext.getCmp('infofamille_container').add(activitedisplay);
			
			var activitestore = Ext.getStore('activitestore');
			activitestore.proxy.api.read = BASE_URL+'activite/activite/show/'+idactivite; 
			activitestore.load();
			activitestore.on('load', function(database){
				var rec= database.getAt(0);
				//Set le titre du panel avec le nom de l'activitedisplay
				console.info(rec.data.nom);
				console.info(activitedisplay.title);
				activitedisplay.title=rec.data.nom;
				console.info(activitedisplay);
				
				//Remplace les champs booleens par des icones yes no
				fields=['redmulti','majext','certificat'];
				Ext.each(fields, function(field){
					rec.data=seticonfield(rec.data,field);
				})
				activitedisplay.getForm().loadRecord(rec);				
			});
			
			//ENFANTS
			if (response.session){
				no_session=0;
				Ext.each(response.session,function(session){
					no_session=no_session+1;
					show_session(session,'sessiondisplay'+no_session);
				})
				
			}
		}
	});	
}

show_session= function(idsession,idpanel){
	var sessiondisplay = Ext.getCmp(idpanel);
	if (!sessiondisplay){
		var sessiondisplay = Ext.widget('sessiondisplay');
	}
	sessiondisplay.id=idpanel;
		
	//Ext.getCmp('adherent_container').removeAll(false);
	var sessionstore = sessiondisplay.store;
	sessionstore.proxy.api.read = BASE_URL+'activite/session/show/'+idsession; 			
	sessionstore.load();
	sessionstore.on('load', function(database){
		var rec= database.getAt(0);
		//Remplace les champs booleens par des icones yes no
		fields=[];
		Ext.each(fields, function(field){
			rec.data=seticonfield(rec.data,field);
		})
		//Set icon
		if (rec.data.sexe==0){
			sessiondisplay.iconCls='';
		}
		else{
			sessiondisplay.iconCls='';
		}
		//Set title
		sessiondisplay.getForm().loadRecord(rec);
		//if (idpanel=='referentdisplay'){
			sessiondisplay.title=rec.data.nom;
			//adherentdisplay.statut='referent';
			Ext.getCmp('adherent_container').insert(0,sessiondisplay);
		//}
	});	
}

Ext.define('Activite', {
	extend: 'Ext.data.Model',
	fields: ['id', 'nom','actiTypeacti_id','actiSecteur_id', 'analytique','redmulti','majext','certificat']
});



Ext.define('MainApp.view.ActiviteDisplay', {
	extend		 : 'Ext.form.Panel',
	alias 		 : 'widget.activitedisplay',
	id           	 : 'activitedisplay',
	frame 		 : true,
	preventHeader	 : true,
	statut		 : '',
	height	 	 : 200,
	width 		 : 200,
	x     		 : 0,
	y     		 : 0,
	title 		 : 'Activite',
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
	rbar: [{
                iconCls: 'outils',
                menu: [{
                	text: 'Ajouter une session',
                	iconCls: 'add',
                	handler: function() {
                		nouvellesession_window= new Ext.window.Window({
					id	: 'nouvellesession_window',
					title	: 'Nouvelle Session',
					modal	: true,
					items	: [{
						xtype	: 'sessionform',
						height  : 240,
						border	: false,
						frame	: false
					}]
				});
				nouvellesession_window.show();
                	}
                }]
        }],
	items	: [{
			xtype: 'container',
			anchor: '100%',
			layout: 'column',
			items:[{
				xtype: 'container',
				columnWidth:0.4,
				layout: 'anchor',
				defaultType  : 'displayfield',
				defaults     : {
					labelWidth: 100
				},
				//height: 15,		
				items : 
				[{
					fieldLabel: '',
					//hideLabel : true,		
					name      : 'nom',
					value	  : '',
					fieldCls  : 'strong'					
			
				},{
					fieldLabel: '',
					//hideLabel : true,		
					name      : 'actiTypeacti_id',
					value	  : '',
					cls       : ''
				},{
					fieldLabel: '',
					//hideLabel : false,		
					name      : 'actiSecteur_id',
					value	  : '',
					cls       : ''
				},{
					fieldLabel: 'Code Analytique',
					//hideLabel : true,		
					name      : 'analytique',
					value	  : '',
					cls       : ''
				}]},{
				xtype: 'container',
				columnWidth:0.5,
				layout: 'anchor',
				defaultType  : 'displayfield',
				defaults     : {
					labelWidth: 130
				},			
				items : 
				[{
					fieldLabel: 'Reduction multi',
					//hideLabel : true,		
					name      : 'redmulti',
					value	  : '',
					cls       : '',
					tpl : [
						'<tpl if={redmulti}" == 0;">',
						'<img src="interface/images/icons/cross.png">',
						'</tpl>',
						'<tpl if={redmulti}" == 1;">',
						'<img src="interface/images/icons/accept.png">',
						'</tpl>'
					]
				},{
					fieldLabel: 'Majoration Ext&eacute;rieure',
					//hideLabel : true,		
					name      : 'majext',
					value	  : '',
					cls       : '',
					tpl : [
						'<tpl if={majext}" == 0;">',
						'<img src="interface/images/icons/cross.png">',
						'</tpl>',
						'<tpl if={majext}" == 1;">',
						'<img src="interface/images/icons/accept.png">',
						'</tpl>'
					]
				},{
					fieldLabel: 'Certificat m&eacute;dical',
					//hideLabel : true,		
					name      : 'certificat',
					value	  : '',
					cls       : '',
					tpl : [
						'<tpl if={certificat}" == 0;">',
						'<img src="interface/images/icons/cross.png">',
						'</tpl>',
						'<tpl if={certificat}" == 1;">',
						'<img src="interface/images/icons/accept.png">',
						'</tpl>'
					]
				}]}]}
	],
	initComponent: function() {
		var me=this;
		
		this.callParent(arguments);
		
		this.store= activitestore= new Ext.data.Store({
			storeId: 'activitestore',
			model: 'Activite',
			//requires: 'MainApp.model.PlModel',
			//model: 'MainApp.model.PlModel',
			proxy: {
				type: 'ajax',
				api: {
					read: BASE_URL+'activite/activite/show/1'    		
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
