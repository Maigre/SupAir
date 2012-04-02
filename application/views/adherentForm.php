Ext.define('MainApp.view.AdherentForm', {
	extend		: 'Ext.form.Panel',
	alias 		: 'widget.adherentform',
	//id         	   : 'adherentform',
	statut		: '',
	masked		: false,
	frame 		: true,
	height		: 300,
	width 		: 220,
	x     		: 0,
	y     		: 0,
	url   		: '', //given before submit
	frame 		: false,
	bodyStyle    	: 'padding:5px 5px 0',
	method  	: 'post',
	trackResetOnLoad: 'true',
	fieldDefaults	: {
		msgTarget : 'side',
		labelWidth: 60,
		allowBlank:false
	},
	defaultType  	: 'textfield',
	items 		: [{
			fieldLabel: 'Pr&eacute;nom',	
			name      : 'prenom',
			value	  : 'Junior',
			//labelWidth: 50,
			anchor	  : '96%'
		},{
			fieldLabel: 'Nom',		
			name      : 'nom',
			value	  : 'Byles',
			//labelWidth: 50,
			anchor	  : '96%',
			listeners 	:{
				'change': function(me) {
					form=this.up('form');
					if (form.statut==1){
						set_nom_enfant(form);
					}
				}
			}			
		},{
			xtype		: 'radiogroup',
			fieldLabel 	: 'Sexe',
			columns		: 2,
			vertical	: true,
			items      : [
				{ boxLabel: 'Homme', name: 'sexe', inputValue: '0'},
				{ boxLabel: 'Femme', name: 'sexe', inputValue: '1', checked: true}
        		]
        	},{
			xtype		: 'datefield',
			fieldLabel	: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',	
			name      	: 'naissance',
			format		: 'd/m/Y',
			value	  	: '04/12/1973',
			cls       	: 'cake',
			anchor		: '96%',
			//labelWidth	: 50,
			/*listeners 	:{
				'change': function(me) {
                			form=this.up('form');
					set_nosecu_begin(form);
               			}
			}*/
		},{
			fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',	
			name      : 'email',
			value	  : 'junior.byles@supair.fr',
			cls       : 'email',
			//labelWidth: 20,
			anchor	  : '96%'
		},{
			fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; perso',
			name      : 'portable',
			value	  : '0637483920',
			cls       : 'telephone',
			anchor	  : '96%'
		},{
			fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; fixe',
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
			items : 
			[{
				xtype: 'checkboxfield',
				fieldLabel: 'SVSP',		
				name      : 'svsp',
				value	  : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
				anchor	  : '96%'
			},{
			fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sant&eacute;',
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
				name      : 'autosortie',
				anchor	  : '96%'
			},{
				xtype: 'checkboxfield',
				fieldLabel: 'Allocataire',	
				name      : 'allocataire',
				value	  : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
				anchor	  : '96%',
				listeners: {
					'activate': {
						element: 'el', //bind to the underlying el property on the panel
						fn: function(){ console.info('yo!'); }
					}
				}
			}]}]},{
			xtype: 'textfield',
			fieldLabel: 'N&deg; Alloc',
			//labelWidth: 25,		
			name      : 'noalloc',
			value	  : '0458392039',
			anchor	  : '96%'
		},{
			fieldLabel: 'Employeur',
			name      : 'employeur',
			value	  : 'BurningMan',
			anchor	  : '96%'
		},{
			fieldLabel: 'N&deg; s&eacute;cu',
			name      : 'nosecu',
			value	  : '173129839849382',
			anchor	  : '96%'
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
					var form = this.up('form').getForm();
					form.url = BASE_URL+'user/adherent/save';
					console.info(this.up('form'));
					if (form.isValid()) {
						form.submit({
							params:{
								userStatut_id : this.up('form').statut,
								userFamille_id: ID_FAMILLE
							},success: function(form, action) {
								Ext.Msg.alert('Success', 'Adherent enregistr&eacute;');
								Ext.getCmp('nouveladherent_window').close();
								displayfamille();								
							},
							failure: function(form, action){
								Ext.Msg.alert('Failed', action.result.error.nom[0]);
							}
						});
					}
				}
			}
		}
	],
	tools:[{
	    type:'close',
	    tooltip: 'D&eacute;sactiver',
	    handler: function(event, toolEl, panel){
		if (panel.ownerCt.statut!=1){
			panel.up('form').getEl().mask();
		}
	    }
	}],
	initComponent: function() {
		this.on('render', function(){
			me=this;
			if(this.statut==3){ //enfant, cacher ces champs
				var fieldtohide= ['bureau','fixe','noalloc','allocataire','employeur'];
				Ext.each(fieldtohide, function(field) {
					me.getForm().findField(field).hidden = true;
				})
			}				
		})
		this.callParent(arguments);		
	}
});
