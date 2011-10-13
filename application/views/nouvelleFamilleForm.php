Ext.define('MainApp.view.NouvelleFamilleForm', {
	extend		: 'Ext.window.Window',
	alias 		: 'widget.nouvellefamilleform',
	id          : 'nouvellefamilleform',
	//frame 		: true,
	title		: 'Nouvelle Famille',
	height		: 600,
	width		: 1150,
	layout		:{
		type	: 'vbox', //1er item avec tous les formulaires. 2eme item avec button "enregistrer"
		align	: 'stretch',
		flex	: 'ratio'
	},
	items		:[{
		xtype 	:	'container',
		height 	: 550,
		layout	:{
			type	: 'hbox',  //1 item par adherent
			align	: 'stretch',
			flex	: 'ratio'
		},
		items		:[{
			xtype	: 'familleform',
			id		: 'familleform',
			height	: '300'
		},{
			xtype	: 'adherentform',
			title	: 'R&eacute;f&eacute;rent',
			id		: 'referentform'
		},{
			xtype	: 'adherentform',
			title	: 'Conjoint',
			id		: 'conjointform'
		},{
			xtype	: 'container',
			flex	: 1,
			layout  : {
				type:'vbox',
				align:'stretch'
			},
			items:[{
				xtype	: 'container',
				width   : 200,
				flex    : 1,
				layout  : {
					type:'hbox',
					align:'stretch'
				},
				items:[{
					xtype	: 'adherentform',
					title	: 'Enfant 1',
					id		: 'enfantform1',
					flex    : 1
				},{
					xtype	: 'adherentform',
					title	: 'Enfant 2',
					id		: 'enfantform2',
					flex    : 1
				}]
			},{
				xtype	: 'container',
				flex    : 1,
				layout  : {
					type:'hbox',
					align:'stretch'
				},
				items:[{
					xtype	: 'adherentform',
					title	: 'Enfant 3',
					id		: 'enfantform3',
					flex    : 1
				},{
					xtype	: 'adherentform',
					title	: 'Enfant 4',
					id		: 'enfantform4',
					flex    : 1
				}]
			}]
		}]
	},{
		xtype	: 'panel',
		layout	  : {
			type  : 'hbox',
			align : 'middle',
			pack  : 'end'
		},
		items: {
			xtype : 'button',
			text: 'Enregistrer toute la famille',
			formBind: true, //only enabled once the form is valid
			//disabled: true,
			handler: function() {
				console.info('enregistrer maintenant');
			}
		}
	}],		
	initComponent: function() {
		
		var enfantform = ["enfantform1", "enfantform2", "enfantform3", "enfantform4"];
		
		this.on('render', function(){
			Ext.getCmp('referentform').getForm().findField('userStatut_id').value=1;
			
			var fieldtohide= ['bureau','fixe','noalloc','allocataire','employeur'];
			Ext.each(enfantform, function(form) {
				f = Ext.getCmp(form);
				Ext.each(fieldtohide, function(field) {
					f.getForm().findField(field).hidden = true;
				})
				//console.info(form.getEl());
				//form.getEl().mask();
				//form.disable();
				f.down('button').hide();
			})
			Ext.getCmp('enfantform1').enable();
			Ext.getCmp('familleform').down('button').hide();
			Ext.getCmp('referentform').down('button').hide();
			Ext.getCmp('conjointform').down('button').hide();
		});
		
		this.on('afterrender', function(){
			//Masque tous les enfantform
			Ext.each(enfantform, function(form) {
				form=Ext.getCmp(form).getEl();
				form.mask();
				form.on('click', function() {
					form.unmask();
				});
				
			})
			//Excepte enfantform1
			Ext.getCmp('enfantform1').getEl().unmask();
		});
		
		
		//////PREREMPLISSAGE
		//préremplit le numero du fixe du conjoint avec celui du referent
		set_fixe_conjoint = function(form){
				var fixe = form.getForm().findField('fixe').value;
				Ext.getCmp('conjointform').getForm().findField('fixe').setValue(fixe);				
		};
		
		//préremplit le numéro de sécu avec homme=1 femme=2 + annee + mois
		set_nosecu_begin = function(form){
			var date = form.getForm().findField('naissance');
			mois=date.value.getMonth()+1;
			if (mois<10){
				mois= '0'+mois;
			}
			annee=date.value.getFullYear();
			annee="'"+annee+"'";
			annee=annee.substr(3, 2);
			var sexe = form.getForm().findField('sexe');
			hf= sexe.value;
			console.info(hf);
			if (hf==0){
				hf=1; //homme
			}
			else if (hf==1){
				hf=2; //femme
			}
			n=hf+annee+mois;
			
			var nosecu = form.getForm().findField('nosecu');
			
			nosecu.setValue(n);
		};
		
		//Préremplit le nom des enfants avec celui du referent
		set_nom_enfant = function(form){
			
			var nom = form.getForm().findField('nom').value;
			var enfantform = ["enfantform1", "enfantform2", "enfantform3", "enfantform4"];
			Ext.each(enfantform, function(formenfant) {
				formenfant = Ext.getCmp(formenfant);
				var nomenfant = formenfant.getForm().findField('nom');
				nomenfant.setValue(nom);
			})
		};
		
		
		
		this.callParent(arguments);
	}
});