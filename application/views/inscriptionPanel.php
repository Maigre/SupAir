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

inscrits_store= new Ext.data.Store({
	storeId: 'inscrits_store',
	fields: ['id', 'userAdherent_nom', 'userAdherent_prenom'],
	//requires: 'MainApp.model.PlModel',
	//model: 'MainApp.model.PlModel',
	proxy: {
		type: 'ajax',
		api: {
			read: BASE_URL+'activite/inscription/listall/id/2'    		
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

loadinscriptionpanel= function(idactivite, nomactivite){
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
		
		Ext.getCmp('main_container').add(inscriptionpanel);
		Ext.getCmp('sessions_activite_gridpanel').setTitle('Session - ' + nomactivite);
	}); 	
};

load_session_inscription= function(idsession){
	
	//Affiche les infos de la session
	sessiondisplay_inscription = Ext.getCmp('sessiondisplay_inscription');
	sessiondisplay_inscription.show();
	sessiondisplay_inscription.store.proxy.api.read = BASE_URL+'activite/session/show/'+idsession;
	sessiondisplay_inscription.store.load();
	
	sessiondisplay_inscription.store.un('load', function(){});
	sessiondisplay_inscription.store.on('load', function(database){
		console.info('onload');
		var rec = database.getAt(0);
		//Remplace les champs booleens par des icones yes no
		fields=[];
		Ext.each(fields, function(field){
			rec.data=seticonfield(rec.data,field);
		});
		
		sessiondisplay_inscription.getForm().loadRecord(rec);
		
		//Set title
		sessiondisplay_inscription.setTitle(rec.data.nom);
		sessiondisplay_inscription.show();
	});
	
	//Affiche les adherents inscrits à cette session.
	var inscrits_store = Ext.getStore('inscrits_store');
	inscrits_store.load({ params: {"where[actiSession_id]": idsession}});
	inscrits_store.on('load',function(){
		Ext.getCmp('inscrits_panel').show();
		Ext.getCmp('inscriptionform_panel').show();
		Ext.getCmp('inscritsgrid').doLayout();
	});
	
};

Ext.define('MainApp.view.InscriptionPanel', {
	extend	: 'Ext.panel.Panel',
	alias 	: 'widget.inscriptionpanel',
	id      : 'inscriptionpanel',
	frame 	: true,
	anchor	: '96%',
	layout	: {
		type	: 'hbox',
		align 	: 'stretch'
	},	
	items	:[{
		xtype: 'container',
		anchor	: '96%',
		layout	: {
			type	: 'vbox',
			align 	: 'center',
			flex	: 'ratio'
		},
		items	: [{
			flex	: 2,
			xtype	: 'panel',
			id	: 'sessions_activite_gridpanel',
			title	: 'Session',
			frame	: true,
			items	: [{
				xtype	: 'grid',
				id	: 'session_activite_grid',
				store	: 'session_activite_store',
				hideHeaders : true,
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
							ID_SESSION = b.data.id;
							load_session_inscription(b.data.id);
						}
					}
				}
			}]
		},{
			flex	: 1,
			xtype	: 'panel',
			id	: 'inscrits_panel',
			title	: 'Inscrits',
			anchor	: '96%',
			items	: [{
				xtype	: 'grid',
				id	: 'inscritsgrid',
				store	: 'inscrits_store',
				autoHeight: true,
				hideHeaders : 	true,
				columns	:[
					{ header: 'Nom',  dataIndex: 'userAdherent_nom'},
					{ header: 'Pr&eacute;nom', dataIndex: 'userAdherent_prenom'}
				],
				minHeight : 300,
				width	: 150,
				scroll	: 'vertical'		
			}],
			hidden	: true //initially hidden before one session has been selected
		}]
	},{
		xtype	: 'sessiondisplay',
		id	: 'sessiondisplay_inscription',
		height	: 300,
		//width	: 210,
		hidden	: true //initially hidden before one session has been selected
	},{
		xtype	: 'panel',
		id	: 'inscriptionform_panel',
		title	: 'Inscription',
		anchor	: '96%',
		items	: [{
			xtype	: 'inscriptionform',
			id	: 'inscriptionform'
		}],
		hidden	: true //initially hidden before one session has been selected
	}]
});
