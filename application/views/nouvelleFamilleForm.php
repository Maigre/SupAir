save_famille_and_referent = function(){

	familleform = Ext.getCmp('familleform').getForm();
	familleform.url=BASE_URL+'user/famille/save';
	//Sauvegarde la famille
	familleform.submit({
		//On succes, sauvegarde le referent (côté php la famille est enregistrée après le post du formulaire du referent)
		success: function(action, form) {
			referentform = Ext.getCmp('referentform').getForm();
    			referentform.url=BASE_URL+'user/adherent/save';
			referentform.submit({
				params:{
					userStatut_id : 1
				},
				success: function(form, action) {
					Ext.getCmp('familleform').hide();
					form.owner.hide();
					//Lance la sauvegarde du conjoint et des enfants
					save_conjoint_and_enfants(action.result['userFamille_id']);
				},
				failure:function(form,action) {
					allsuccess=false;
				}
				
			});
		},
		failure: function(form, action) {
			allsuccess=false;
		}
	});
};

save_adherents= function(idfamille,indiceform){
	formtosubmit=['conjointform','enfantform1','enfantform2','enfantform3','enfantform4'];
	idform=formtosubmit[indiceform];
	if (idform=='conjointform'){
		userStatut_id=2;
	}
	else{
		userStatut_id=3;
	}
	form = Ext.getCmp(idform);
	//Sauvegarde des formulaires non masqués
	if (form.masked==false){
		if (form.getForm().isValid()==false){
			allvalid=false;
		}
		form.getForm().url=BASE_URL+'user/adherent/save';
		form.getForm().submit({
			params:{
				userStatut_id : userStatut_id,
				userFamille_id: idfamille
			},
			success: function(form, action) {
				form.owner.hide();
				if (form.id=='enfantform4'){
					if ((allsuccess==true) && (allvalid==true)){
						//Dernier enfant sauvegardé fermeture de la fenêtre et affichage de la famille
						displayfamille(idfamille);
						Ext.getCmp('nouvellefamilleform').close();						
					}
				}
				else{
					//Sauvegarde de l'adherent suivant
					indiceform=indiceform+1;
					if (indiceform<5){
						save_adherents(idfamille,indiceform);
					}
				}
			},
			failure:function(form,action) {
				allsuccess=false;
			}
		});
	}
	else{
		if (form.id=='enfantform4'){
			if ((allsuccess==true) && (allvalid==true)){
				displayfamille(idfamille);
				Ext.getCmp('nouvellefamilleform').close();				
			}
		}
		else{
			//Sauvegarde de l'adherent suivant
			indiceform=indiceform+1
			if (indiceform<5){
				save_adherents(idfamille,indiceform);
			}
		}
	}
}


save_conjoint_and_enfants = function(idfamille){
	
	//fonction recursive qui lance le post de tous les formulaires les uns après les autres
	save_adherents(idfamille,0);
}

Ext.define('MainApp.view.NouvelleFamilleForm', {
	extend		: 'Ext.window.Window',
	alias 		: 'widget.nouvellefamilleform',
	id              : 'nouvellefamilleform',
	title		: 'Nouvelle Famille',
	height		: 615,
	autoHeight	: true,
	width		: 1150,
	layout		:{
		type	: 'vbox', //1er item avec tous les formulaires. 2eme item avec button "enregistrer"
		align	: 'stretch',
		flex	: 'ratio'
	},
	items		:[{
		xtype 	: 'container',
		id	: 'famillerefconjpanel',
		height 	: 550,
		layout	:{
			type	: 'hbox',  //1 item par adherent
			align	: 'stretch',
			flex	: 'ratio'
		},
		items	:[{
			xtype	: 'container',
			id	: 'familleformcontainer',
			items	: [{
				xtype	: 'familleform',
				id	: 'familleform',
				height	: '300'
			}]
		},{
			xtype	: 'container',
			id	: 'referentformcontainer',
			items	: [{
				xtype	: 'adherentform',
				title	: 'R&eacute;f&eacute;rent',
				id	: 'referentform',
				height	: 550
				
			}]
		},{
			xtype	: 'container',
			id	: 'conjointformcontainer',
			height	: 550,
			items	: [{
				xtype	: 'adherentform',
				title	: 'Conjoint',
				id	: 'conjointform',
				height	: 550,
			}]
		},{
			xtype	: 'container',
			flex	: 1,
			layout  : {
				type:'vbox',
				align:'stretch'
			},
			items:[{
				xtype	: 'container',
				id	: 'enfantformcontainer',
				width   : 200,
				flex    : 1,
				layout  : {
					type:'hbox',
					align:'stretch'
				},
				items:[{
					xtype	: 'adherentform',
					title	: 'Enfant 1',
					id	: 'enfantform1',
					flex    : 1
				},{
					xtype	: 'adherentform',
					title	: 'Enfant 2',
					id	: 'enfantform2',
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
					id	: 'enfantform3',
					flex    : 1
				},{
					xtype	: 'adherentform',
					title	: 'Enfant 4',
					id	: 'enfantform4',
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
			margins: 5,
			text: 'Enregistrer toute la famille',
			formBind: true, //only enabled once the form is valid
			//disabled: true,
			handler: function() {
				familleform 	= Ext.getCmp('familleform').getForm();
				allsuccess	= true;
				allvalid  	= true;
				if (familleform){
					save_famille_and_referent();
				}
				else{
					save_conjoint_and_enfants();
				}
											
			}
		}
	}],		
	initComponent: function() {
		
		var enfantform = ["enfantform1", "enfantform2", "enfantform3", "enfantform4"];
		
		
		this.on('render', function(){
			/*Ext.getCmp('referentform').getForm().findField('userStatut_id').value=1;
			console.info(Ext.getCmp('referentform').getForm().findField('userStatut_id').value);
			Ext.getCmp('conjointform').getForm().findField('userStatut_id').value=2;*/
			
			Ext.getCmp('referentform').statut = 1;
			console.info(Ext.getCmp('referentform'));
			var fieldtohide= ['bureau','fixe','noalloc','allocataire','employeur'];
			i=0;
			Ext.each(enfantform, function(form) {
				i=i+1;
				f = Ext.getCmp(form);
				Ext.each(fieldtohide, function(field) {
					f.getForm().findField(field).hidden = true;
				})
				f.getForm().findField('sexe').id='sexefield'+i;
				//console.info(form.getEl());
				//form.getEl().mask();
				//form.disable();
				f.down('button').hide();
			})
			Ext.getCmp('enfantform1').enable();
			//Ext.getCmp('familleform').down('button').hide();
			Ext.getCmp('referentform').down('button').hide();
			Ext.getCmp('conjointform').down('button').hide();
		});
		
		this.on('afterrender', function(){
			//Masque tous les enfantform
			
			Ext.each(enfantform, function(form) {
				form=Ext.getCmp(form);
				form.getEl().mask();
				form.masked=true,
				form.getEl().on('click', function() {
					form.getEl().unmask();
					form.masked=false;
				});
				
			})
			conjointform=Ext.getCmp('conjointform');
			conjointform.getEl().on('click', function() {
				conjointform.getEl().unmask();
				conjointform.masked=false;
			});
			//Excepte enfantform1
			Ext.getCmp('enfantform1').getEl().unmask();
			Ext.getCmp('enfantform1').masked=false;
			//console.info(Ext.getCmp('referentform').getForm().findField('userStatut_id').value);
		});
		
		
		//////PREREMPLISSAGE
		//préremplit le numero du telephone fixe du conjoint avec celui du referent
		set_fixe_conjoint = function(form){
				var fixe = form.getForm().findField('fixe').value;
				Ext.getCmp('conjointform').getForm().findField('fixe').setValue(fixe);				
		};
		
		
		set_icon = function(form){
			var hf = form.getForm().findField('sexe').value;
			//hf= sexe.value;
			//console.info(hf);
			if (hf==0){
				form.iconCls='user'; //homme
			}
			else if (hf==1){
				form.iconCls='user_female'; //femme
			}
		};
		
		//préremplit le numéro de sécu avec homme=1 femme=2 + annee + mois
		set_nosecu_begin = function(form){
			var date = form.getForm().findField('naissance');
			mois=date.value.getMonth()+1;
			//mois à deux chiffres
			if (mois<10){
				mois= '0'+mois;
			}
			annee=date.value.getFullYear();
			annee="'"+annee+"'";
			//annee à deux chiffres
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