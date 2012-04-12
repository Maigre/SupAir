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
				activitedisplay.title=rec.data.nom;
				
				//Remplace les champs booleens par des icones yes no
				fields=['red_multi','maj_ext','certificat'];
				activitedisplay.getForm().loadRecord(rec);
				Ext.each(fields, function(field){
					//rec.data=seticonfield(rec.data,field);
					if (rec.data[field]==0){
						activitedisplay.getForm().findField(field).setValue('<img src="interface/images/icons/cross.png">');
					}
					else{
						activitedisplay.getForm().findField(field).setValue('<img src="interface/images/icons/accept.png">');
					}
				})
								
			});
			
			//SESSIONS
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
			session_number=Ext.getCmp('adherent_container').items.items.length;
			Ext.getCmp('adherent_container').insert(session_number, sessiondisplay);
		//}
	});	
}

Ext.define('Activite', {
	extend: 'Ext.data.Model',
	fields: ['id', 'nom','actiTypeacti_id', 'actiTypeacti_nom', 'actiSecteur_id', 'actiSecteur_nom', 'analytique','red_multi','maj_ext','certificat']
});

activitestore= new Ext.data.Store({
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
						height  : 540,
						border	: false,
						frame	: false
					}]
				});
				nouvellesession_window.show();
                	}
                },{
                	text: 'Modifier l\'activit&eacute;',
                	iconCls: 'edit',
                	handler: function() {
                		modifier_activite();                		
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
					fieldLabel: 'Activit&eacute;',
					labelSeparator: ' ',
					labelWidth: 40,
					//hideLabel : true,		
					name      : 'actiTypeacti_nom',
					value	  : '',
					cls       : ''
				},{
					fieldLabel: '',
					//hideLabel : false,		
					name      : 'actiSecteur_nom',
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
					name      : 'red_multi',
					value	  : '',
					cls       : '',
					tpl : [
						'<tpl if={red_multi}" == 0;">',
						'<img src="interface/images/icons/cross.png">',
						'</tpl>',
						'<tpl if={red_multi}" == 1;">',
						'<img src="interface/images/icons/accept.png">',
						'</tpl>'
					]
				},{
					fieldLabel: 'Majoration Ext&eacute;rieure',
					//hideLabel : true,		
					name      : 'maj_ext',
					value	  : '',
					cls       : '',
					tpl : [
						'<tpl if={maj_ext}" == 0;">',
						'<img src="interface/images/icons/cross.png">',
						'</tpl>',
						'<tpl if={maj_ext}" == 1;">',
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
		
		this.store= Ext.getStore('activitestore');
		
	}
});
