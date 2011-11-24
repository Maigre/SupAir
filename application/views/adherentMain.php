displayfamille= function(){
	//famille id stockée en variable globale : ID_FAMILLE
	
	Ext.Ajax.request({
		url: BASE_URL+'user/famille/loadFamille/'+ID_FAMILLE,
		method : 'POST',
		success: function(response){
			var response = Ext.JSON.decode(response.responseText);
			
			//FAMILLE
			var familledisplay = Ext.getCmp('familledisplay');
			if (!familledisplay){
				var familledisplay = Ext.widget('familledisplay');
			}	
			Ext.getCmp('infofamille_container').removeAll(false);
			Ext.getCmp('infofamille_container').add(familledisplay);
			var famillestore = Ext.getStore('famillestore');
			famillestore.proxy.api.read = BASE_URL+'user/famille/show/'+ID_FAMILLE; 
			famillestore.load();
			famillestore.on('load', function(database){
				var rec= database.getAt(0);
				//Remplace les champs booleens par des icones yes no
				fields=['ext','ccas','bonv'];
				Ext.each(fields, function(field){
					rec.data=seticonfield(rec.data,field);
				})
				familledisplay.getForm().loadRecord(rec);				
			});
			
			Ext.getCmp('adherent_container').removeAll();
			//REFERENT
			show_adherent(response.referent,'referentdisplay');
			
			//CONJOINT
			if (response.conjoint){
				show_adherent(response.conjoint,'conjointdisplay');
			//Modifie le bouton nouvel adhérent en nouvel enfant
				nouveladherent_button=  Ext.getCmp('nouveladherent_button');
				if(nouveladherent_button){
					nouveladherent_button.destroy();
				}
				nouvelenfant_button=  Ext.getCmp('nouvelenfant_button');
				if(nouvelenfant_button){
					nouvelenfant_button.destroy();
				}
				nouvelenfant_button=  Ext.widget('nouvelenfant_button');
				console.info(nouvelenfant_button);							
				Ext.getCmp('menuadherentpanel').add(nouvelenfant_button);				
			}
			else{
				nouveladherent_button=  Ext.getCmp('nouveladherent_button');
				if(nouveladherent_button){
					nouveladherent_button.destroy();
				}
				nouvelenfant_button=  Ext.getCmp('nouvelenfant_button');
				if(nouvelenfant_button){
					nouvelenfant_button.destroy();
				}
								
				Ext.getCmp('menuadherentpanel').add(Ext.widget('nouveladherent_button'));
			}
			
			//ENFANTS
			if (response.enfants){
				no_enfant=0;
				Ext.each(response.enfants,function(enfant){
					no_enfant=no_enfant+1;
					show_adherent(enfant,'enfantdisplay'+no_enfant);
				})
				
			}
		}
	});	
}

show_adherent= function(idadherent,idpanel){
	var adherentdisplay = Ext.getCmp(idpanel);
	if (!adherentdisplay){
		var adherentdisplay = Ext.widget('adherentdisplay');
	}
	adherentdisplay.id=idpanel;
		
	//Ext.getCmp('adherent_container').removeAll(false);
	var adherentstore = adherentdisplay.store;
	adherentstore.proxy.api.read = BASE_URL+'user/adherent/show/'+idadherent; 			
	adherentstore.load();
	adherentstore.on('load', function(database){
		var rec= database.getAt(0);
		//Remplace les champs booleens par des icones yes no
		fields=['svsp','autosortie','sante','allocataire'];
		Ext.each(fields, function(field){
			rec.data=seticonfield(rec.data,field);
		})
		//Set icon
		if (rec.data.sexe==0){
			adherentdisplay.iconCls='user';
		}
		else{
			adherentdisplay.iconCls='user_female';
		}
		//Set title
		adherentdisplay.getForm().loadRecord(rec);
		if (idpanel=='referentdisplay'){
			adherentdisplay.title=rec.data.prenom+' '+rec.data.nom+' - R&eacute;f&eacute;rent';
			adherentdisplay.statut='referent';
			Ext.getCmp('adherent_container').insert(0,adherentdisplay);
		}
		else if(idpanel=='conjointdisplay'){
			adherentdisplay.title=rec.data.prenom+' '+rec.data.nom+' - Conjoint';
			adherentdisplay.statut='conjoint';
			Ext.getCmp('adherent_container').insert(1,adherentdisplay);
		}
		else{
			adherentdisplay.title=rec.data.prenom+' '+rec.data.nom+' - Enfant';
			adherentdisplay.statut='enfant';
			Ext.getCmp('adherent_container').insert(2,adherentdisplay);						
		}
	});	
}

//Remplace les champs booleens par des icones yes no
seticonfield = function(data,field){
	if (data[field]==0){
		data[field]='<img src="interface/images/icons/cross.png">';
	}
	else{
		data[field]='<img src="interface/images/icons/accept.png">';
	}
	return data;
}

Ext.define('MainApp.view.AdherentMain', {
	extend: 'Ext.panel.Panel',
    layout:{
		type:'vbox',
		align:'stretch'
	},
    defaults: {
        // applied to each contained panel
        defaults:{height:100},
        bodyStyle: 'margin:5px',
		layout:{
			type:'hbox',
			align:'stretch'
		},
		xtype: 'container'
    },
    //width: 300,
    //padding: 5,
    opacity:0,
    //height: 300,
    border:0,
	alias : 'widget.adherentmain',
	id    : 'adherentmain',
	items: [{ //NORTH -> info famille + info inscription famille
		flex:1,
		defaults: {
			margins:5,
			frame: true,
			xtype: 'container'
		},
		items:[{
			id 	: 'infofamille_container',
			xtype	: 'container',
			width	: 400,
			layout	: 'fit'/*,
			items	: {
				xtype:'familledisplay',
				frame: true
			}*/
		},{ 
			id 	: 'infoinscription_container',
			xtype   : 'container',
			flex	:1,
			layout	: 'fit',
			items	: {
				xtype:'panel',
				frame: true
			}
		}]
	},{ //SOUTH -> adherent accordion + main panel
		flex:5,
		defaults: {
			margins:5,
			frame: true,
			xtype: 'container'
		},
		items:[{
			id 	: 'adherent_container',
			xtype   : 'panel', 
			width	: 220,
			layout	: 'accordion',
		    	layoutConfig: {
				// layout-specific configs go here
				hideCollapseTool : true
		    	}
		},{
			id 	: 'main_container',
			flex	:1,
			layout	: 'fit',
			items	: {
				xtype:'panel',
				frame: true
			}
		}]
	}],
	initComponent: function() {
		var me = this;
		me.callParent(arguments);
	}
});
