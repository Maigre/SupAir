session_activite_store= new Ext.data.Store({
	storeId: 'session_activite_store',
	model: 'Session',
	//requires: 'MainApp.model.PlModel',
	//model: 'MainApp.model.PlModel',
	proxy: {
		type: 'ajax',
		api: {
			read: BASE_URL+'activite/session/listall'    		
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

loadinscriptionpanel= function(idactivite){
	session_activite_store=Ext.getStore('session_activite_store');
	//session_activite_store.proxy.api.read = BASE_URL+'activite/session/listall'; 			
	session_activite_store.load({ params: {"where[actiActivite_id]": idactivite}});
	
	session_activite_store.un('load', function(){});
	session_activite_store.on('load', function(){
		Ext.getCmp('activiteselectionwindow').close();
		console.info('ok');
		Ext.getCmp('main_container').removeAll(true);
		inscriptionpanel= Ext.getCmp('inscriptionpanel');
		if(!inscriptionpanel){
			inscriptionpanel= Ext.widget('inscriptionpanel');
		}
		console.info(inscriptionpanel);
		
		Ext.getCmp('main_container').add(inscriptionpanel);
	}); 	
};

load_session_inscription= function(idsession){
	
	console.info(idsession);
	sessiondisplay_inscription=Ext.getCmp('sessiondisplay_inscription');
	sessiondisplay_inscription.store.proxy.api.read = BASE_URL+'activite/session/show/'+idsession;
	sessiondisplay_inscription.store.load();
	sessiondisplay_inscription.store.on('load', function(database){
		var rec= database.getAt(0);
		//Remplace les champs booleens par des icones yes no
		fields=[];
		Ext.each(fields, function(field){
			rec.data=seticonfield(rec.data,field);
		})
		//Set icon
		/*if (rec.data.sexe==0){
			sessiondisplay.iconCls='';
		}
		else{
			sessiondisplay.iconCls='';
		}*/
		//Set title
		sessiondisplay_inscription.getForm().loadRecord(rec);
		//if (idpanel=='referentdisplay'){
			//sessiondisplay.title=rec.data.nom;
			//adherentdisplay.statut='referent';
			//session_number=Ext.getCmp('adherent_container').items.items.length;
			//Ext.getCmp('adherent_container').insert(session_number, sessiondisplay);
		//}
	});
	sessiondisplay_inscription.show();
}

Ext.define('MainApp.view.InscriptionPanel', {
	extend	: 'Ext.panel.Panel',
	alias 	: 'widget.inscriptionpanel',
	id      : 'inscriptionpanel',
	frame 	: true,
	items	:[{
		xtype	: 'grid',
		id	: 'session_activite_grid',
		store	: 'session_activite_store',
		columns	:[
			{ header: 'Sessions',  dataIndex: 'nom', width:200},
			{ header: 'id', dataIndex: 'id', hidden: true}
		],
		minHeight : 70,
		width	: 150,
		scroll	: 'vertical',
		listeners: {
			itemclick: {
				fn: function(a,b){
					load_session_inscription(b.data.id);
				}
			}
		}
		
	},{
		xtype	: 'sessiondisplay',
		id	: 'sessiondisplay_inscription'
	}]
});
