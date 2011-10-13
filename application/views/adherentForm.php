Ext.define('MainApp.view.AdherentForm', {
	extend		 : 'Ext.form.Panel',
	alias 		 : 'widget.adherentform',
	//id           : 'adherentform',
	frame 		 : true,
	height		 : 300,
	width 		 : 220,
	x     		 : 0,
	y     		 : 0,
	url   		 : BASE_URL+'data/plcontrol/save',
	frame 		 : false,
	title 		 : 'Nouvel adherent',
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
	defaultType  : 'textfield',
	/*defaults     : {
		anchor: '100%'
	},*/
	items 		 : [{
			xtype: 'hiddenfield',
			id   : 'id_famille_adherent_form',
			name : 'userFamille_id',
			value: 49
		},{
			xtype: 'hiddenfield',
			id   : 'id_statut_adherent_form',
			name : 'userStatut_id',
			value: 1
		},{
			fieldLabel: 'Pr&eacute;nom',
			//hideLabel : true,		
			name      : 'prenom',
			value	  : 'Junior',
			//cls       : 'cake',
			labelWidth: 50,
			anchor	  : '96%'
		},{
			fieldLabel: 'Nom',
			//hideLabel : true,		
			name      : 'nom',
			value	  : 'Byles',
			//cls       : 'cake',
			labelWidth: 50,
			anchor	  : '96%',
			listeners 	:{
				'change': function(me) {
					form=this.up('form');
					if (form.getForm().findField('userStatut_id').value==1){
						set_nom_enfant(form);
					}
					
					//f.hidden = true;
				}
			}			
		},{
        xtype      : 'fieldcontainer',
        fieldLabel : 'Sexe',
        defaultType: 'radiofield',
        defaults   : {
            flex: 1
        },
        layout     : 'hbox',
		listeners 	:{
			'change': function(me) {
				form=this.up('form');
				set_nosecu_begin(form);
				//f.hidden = true;
			}
		},
        items      : [
            {
                boxLabel  : 'Femme',
                hideLabel : true,
                name      : 'sexe',
                inputValue: '1'//,
                //id        : 'radiofemme'
            },{
                boxLabel  : 'Homme',
                hideLabel : true,
                name      : 'sexe',
                inputValue: '0'//,
                //id        : 'radiohomme'
            }
        ]},{
			xtype		: 'datefield',
			fieldLabel	: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
			//hideLabel : true,		
			name      	: 'naissance',
			value	  	: '04-12-73',
			cls       	: 'cake',
			labelWidth	: 20,
			listeners 	:{
				'change': function(me) {
                	
                	form=this.up('form');
					set_nosecu_begin(form);
                }
			}
		},{
			fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
			//hideLabel : true,		
			name      : 'email',
			value	  : 'junior.byles@supair.fr',
			cls       : 'email',
			labelWidth: 20,
			anchor	  : '96%'
		},{
			fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; perso',
			//hideLabel : false,		
			name      : 'portable',
			value	  : '0637483920',
			cls       : 'telephone',
			anchor	  : '96%'
		},{
			fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; fixe',
			//hideLabel : true,		
			name      : 'fixe',
			value	  : '0473829102',
			cls       : 'telephone',
			anchor	  : '96%',
			listeners 	:{
				'change': function(me) {
                	form=this.up('form');
					set_fixe_conjoint(form);
                }
			}
		},{
			fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; pro',
			//hideLabel : true,		
			name      : 'bureau',
			value	  : '0637281928',
			cls       : 'telephone',
			anchor	  : '96%'
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
				xtype: 'checkboxfield',
				fieldLabel: 'SVSP',
				//hideLabel : true,		
				name      : 'svsp',
				value	  : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
				//cls       : 'pig',
				anchor	  : '96%'
			},{
			fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sant&eacute;',
			//hideLabel : true,		
			xtype	  : 'checkboxfield',
			name      : 'sante',
			value	  : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
			cls       : 'pill',
			anchor	  : '96%'
			}]},{
			xtype: 'container',
			columnWidth:0.5,
			layout: 'anchor',			
			items : 
			[{
				xtype: 'checkboxfield',
				fieldLabel: 'A. sortie',
				//hideLabel : true,		
				name      : 'autosortie',
				value	  : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
				//cls       : 'grasyes',
				anchor	  : '96%'
			},{
				xtype: 'checkboxfield',
				fieldLabel: 'Allocataire',
				//hideLabel : true,		
				name      : 'allocataire',
				value	  : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
				//cls       : 'yes',
				anchor	  : '96%',
				listeners: {
					'activate': {
						element: 'el', //bind to the underlying el property on the panel
						fn: function(){ console.info('yo!'); }
					}
				}
			}]}]},{
			xtype: 'textfield',
			fieldLabel: 'N&deg;',
			labelWidth: 25,
			//hideLabel : true,		
			name      : 'noalloc',
			value	  : '0458392039',
			//cls       : 'grasyes',
			anchor	  : '96%'
		},{
			fieldLabel: 'Employeur',
			name      : 'employeur',
			value	  : 'BurningMan',
			anchor	  : '96%'
			//cls       : 'red',
		},{
			fieldLabel: 'N&deg; s&eacute;cu',
			name      : 'nosecu',
			value	  : '173129839849382',
			anchor	  : '96%'
			//cls       : 'red',
		},{
			xtype	  : 'container',
			layout	  : {
				type  : 'hbox',
				align : 'middle',
				pack  : 'end'
			},
			items: {
				xtype : 'button',
				text: 'OK',
				formBind: true, //only enabled once the form is valid
				disabled: true,
				handler: function() {
					console.info(Ext.getCmp('id_famille_adherent_form').value);
					var form = this.up('form').getForm();
					form.url = BASE_URL+'user/adherent/save';
					if (form.isValid()) {
						console.info(Ext.getCmp('id_famille_adherent_form').value);
						form.submit({
							success: function(form, action) {
								Ext.Msg.alert('Success', 'Adherent enregistr&eacute;');
								
								//GET FAMILLE_ID
								famille_id=Ext.getCmp('id_famille_adherent_form').value;
								
								famillecontainer=Ext.getCmp('famillecontainer');
								famillecontainer.removeAll();
								//LOAD THE FAMILY
								
								var famillestore = Ext.data.StoreManager.lookup('famillestore');
								famillestore.proxy.api.read=BASE_URL+'user/famille/show/'+famille_id;
								famillestore.load();
								famillestore.on('load', function(database){
									var rec= database.getAt(0);
									familledisplay=Ext.getCmp('familledisplay');
									if(!familledisplay){
										familledisplay=Ext.widget('familledisplay');
									}
									familledisplay.getForm().loadRecord(rec);
									famillecontainer.add(familledisplay);
									//LOAD ALL HER ADHERENTS
								
									var adherentstore = Ext.data.StoreManager.lookup('adherentstore');
									adherentstore.proxy.api.read=BASE_URL+'user/adherent/show/'+action.result.id;
									adherentstore.load();
									adherentstore.on('load', function(database){
										
										var rec= database.getAt(0);
										adherentdisplay=Ext.getCmp('adherentdisplay');
										if(!adherentdisplay){
											adherentdisplay=Ext.widget('adherentdisplay');
										}
										adherentdisplay.getForm().loadRecord(rec);
										if(rec.data.sexe==0){
											adherentdisplay.iconCls='user';
										}
										else{
											adherentdisplay.iconCls='user_female';
										}
										famillecontainer.add(adherentdisplay);				
									});				
								});
									
								
								
								Ext.Ajax.request({
									url: BASE_URL+'data/process/menumensuel',
									method : 'POST',
									success: function(response){
										var options = Ext.decode(response.responseText).data;
						
										//console.info(options);
										Ext.each(options, function(op) {
											
										})
										// process server response here
									}
								});
								
							},
							failure: function(form, action) {
								Ext.Msg.alert('Failed', action.result.msg);
							}
						});
					}
				}
			}
		}
	],
	initComponent: function() {
		
		
		this.callParent(arguments);
		
	}
});
