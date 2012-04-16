build_secteur_menu = function(){	
	Ext.Ajax.request({
		url	: BASE_URL+'activite/secteur/listAll',
		method 	: 'POST',
		success	: function(response){
		
			var options = Ext.decode(response.responseText);
		

			
			Ext.each(options, function(op) {				
				console.info(op);
				console.info(op.nom);
				// Ecriture des motifs à rempalcer
				var regAccentA = new RegExp('[àâä]', 'gi');
				var regAccentE = new RegExp('[éèêë]', 'gi');
				var regEspace = new RegExp('[ ]', 'gi');
				// Application de la fonction replace() au nom

				nomsecteur = op.nom.replace(regAccentA, 'a');
				nomsecteur = nomsecteur.replace(regAccentE, 'e');
				nomsecteur = nomsecteur.replace(regEspace, '');   
				//Dynamically create the store
			
			
				activitestore=Ext.create('Ext.data.Store', {
					storeId: nomsecteur+'Store',
					fields:['id', 'nom'],
					autoLoad: false,
					proxy: {
						type: 'ajax',
						url: BASE_URL+'activite/activite/listAll/nom',  // url that will load data
						actionMethods : {read: 'POST'},
						reader : {
							type : 'json',
							totalProperty: 'size',
							root: 'combobox'
						}
					}
				});
			
				//console.info(where_array);
				activitestore.load({ params: {"where[actiSecteur_id]": op.id}});
			
				//console.info('store');
				//console.info(Ext.getStore(op.nom+'Store'));
			
				secteurpanel= new Ext.Panel({
					title: op.nom,
					iconCls: op.icon,
					layout	: {
						type	: 'vbox',
						align	: 'center'
					},				
					items:[{
						xtype	: 'button',
						text 	: 'Nouvelle activit&eacute;',
						width 	: 110,
						iconCls	: 'add',
						margin	: 2,
						listeners: {
							click: function() {
								SECTEUR=op.id;
								nouvelleactivite_window= new Ext.window.Window({
									id	: 'nouvelleactivite_window',
									title	: 'Nouvelle Activit&eacute;',
									iconCls	: 'palette',
									modal	: true,
									items	: [{
										xtype	: 'activiteform',
										height  : 220,
										border	: false,
										frame	: false
									}]
								});
								nouvelleactivite_window.show();
					
							}		
						}			
					},{
						xtype: 		'grid',
						title: 		'Activit&eacute;s',
						hideHeaders : 	true,
						id:		nomsecteur+'grid',
						store: 		Ext.getStore(nomsecteur+'Store'),
						columns: [
							{ header: 'Nom',  dataIndex: 'nom', width:200},
							{ header: 'id', dataIndex: 'id', hidden: true}
						],
						height: 	200,
						width: 		'80%',
						scroll: 	'vertical',
						listeners: {
							itemclick: {
								//element: 'el', //bind to the underlying el property on the panel
								fn: function(a,b,c){ 
									console.info(b.data.id);
									ACTIVITE_ID = b.data.id;
									displayactivite(b.data.id);
								}
							}
						}
					}/*,{
						xtype	: 'button',
						text 	: 'New session*',
						width 	: 110,
						iconCls	: 'add',
						margin	: 2,
						listeners: {
							click: function() {
								SECTEUR=op.id;
								nouvellesession_window= new Ext.window.Window({
									id	: 'nouvellesession_window',
									title	: 'Nouvelle Session',
									iconCls	: 'palette',
									modal	: true,
									items	: [{
										xtype	: 'sessionform',
										height  : 220,
										border	: false,
										frame	: false
									}]
								});
								nouvellesession_window.show();							
							}		
						}			
					}*/]
				});
				menupanel=Ext.getCmp('menupanel')
				menupanel.items.insert(1,secteurpanel);
				menupanel.doLayout();
				console.info(Ext.getCmp(nomsecteur+'grid'));
			})
		}
	});
};

build_menu = function(){
	Ext.define('MainApp.view.menu', {
		extend: 'Ext.panel.Panel',
		alias : 'widget.menupanel',
		id    : 'menupanel',
		height: 100,
		title : '',
		layout: {
			type: 'accordion'        	
	    	},
	    	layoutConfig: {
			// layout-specific configs go here
			hideCollapseTool : true
	    	},
		initComponent: function() {
			var me = this;
			me.items = [{
				xtype	: 'panel',
				id	: 'menuadherentpanel',
				title	: 'Adherents',
				iconCls	: 'user',
				bodyStyle: "background-color:#B6D0DB;",
				layout	: {
					type	: 'vbox',
					align	: 'center'
				},				
				items:[{
					xtype : 'button',
					text: 'Calendrier',
					//formBind: true, //only enabled once the form is valid
					//disabled: true,
					handler: function() {
						sessioncalendrierwindow=Ext.getCmp('sessioncalendrierwindow');
						if(!sessioncalendrierwindow){
							sessioncalendrierwindow=Ext.widget('sessioncalendrierwindow');
						}
						sessioncalendrierwindow.show();
					},
					width	: 80,
					margins: '0 0 5 0'
				},{
					xtype	: 'button',
					text 	: 'Nouvelle famille',
					width 	: 110,
					iconCls	: 'add',
					margin	: 2,
					listeners: {
						click: function() {
						
							nouvellefamilleform=Ext.getCmp('nouvellefamilleform');
							if (!nouvellefamilleform){
								//console.info('okwidget');
								nouvellefamilleform=Ext.widget('nouvellefamilleform');
							}
							nouvellefamilleform.show();
						
						}		
					}			
				},{
					xtype: 'container',
					width: 130,
					height: 30,
					layout:{
						type:'hbox',
						align: 'center',
						pack: 'start'
					},
					items:[{
						xtype:'searchbar',
						flex:1,					
						margin: '0 0 0 5'
					},{
						xtype:'searchbaricon',
						width:17,
						margin: '1 0 0 1'
					}]
				}]			
			},{
				xtype	: 'panel',
				id	: 'menuoutilspanel',
				title	: 'Outils',
				iconCls	: 'outils',
				bodyStyle: "background-color:#B6D0DB;",
				layout	: {
					type	: 'vbox',
					align	: 'center'
				},
				items	:[{
					xtype	: 'button',
					text 	: 'Calendrier',
					iconCls	: 'calendrier',					
					width 	: 110,
					margin	: 2,
					listeners: {
						click: function() {
							calendrier_window=Ext.widget('calendrier_window');
							calendrier_window.show();
						}		
					}			
				},{
					xtype	: 'button',
					text 	: 'Secteur',
					iconCls	: 'add',					
					width 	: 110,
					margin	: 2,
					listeners: {
						click: function() {
							nouveausecteur_window= new Ext.window.Window({
								id	: 'nouveausecteur_window',
								title	: 'Nouveau Secteur',
								//iconCls	: 'palette',
								modal	: true,
								items	: [{
									xtype	: 'secteurform',
									height  : 220,
									border	: false,
									frame	: false
								}]
							});
							nouveausecteur_window.show();
						}		
					}			
				},{
					xtype	: 'button',
					text 	: 'Tranches QF',
					iconCls	: 'calculator',					
					width 	: 110,
					margin	: 2,
					listeners: {
						click: function() {
							tranchesQf_window= new Ext.window.Window({
								id	: 'tranchesQf_window',
								title	: 'Tranches Q.F',
								//iconCls	: 'palette',
								modal	: true,
								items	: [{
									xtype	: 'tranchesqfform',
									height  : 230,
									border	: false,
									frame	: false
								}]
							});
							tranchesQf_window.show();
							Ext.getStore('tranchesqfStore').load();
						}		
					}			
				}]
			}];
		
			build_secteur_menu();
					
			me.callParent(arguments);
	  	}
	});
};

build_menu();

Ext.define('MainApp.view.nouvelenfantButton', {
	extend 	  : 'Ext.Button',
	text      : 'Nouvel Enfant',
	id	  : 'nouvelenfant_button',
	alias	  : 'widget.nouvelenfant_button',
	width 	: 110,
	iconCls	: 'add',
	renderTo  : Ext.getBody(),
	arrowAlign: 'bottom',
	listeners : {
		click: function() {
			nouveladherent_window= new Ext.window.Window({
				id	: 'nouveladherent_window',
				title	: 'Nouvel Enfant',
				modal	: true,
				items	: [{
					xtype	: 'adherentform',
					border	: false,
					margin	: '0 0 5 0',
					tools	: [],
					statut  : 3	
				}]
			});
			nouveladherent_window.show();
		}		
	}
});

Ext.define('MainApp.view.nouveladherentButton', {
	extend 	  : 'Ext.Button',
	text      : 'Adh&eacute;rent',
	id	  : 'nouveladherent_button',
	width 	: 110,
	iconCls	: 'add',
	alias	: 'widget.nouveladherent_button',
	renderTo  	: Ext.getBody(),
	arrowAlign	: 'right',
	scale      : 'medium',
	iconAlign  : 'left',
	//width      : 50,
	menu      	: [
		{text: 'Nouveau Conjoint',handler: function(){
			nouveladherent_window= new Ext.window.Window({
				id	: 'nouveladherent_window',
				title	: 'Nouveau Conjoint',
				modal	: true,
				items	: [{
					xtype	: 'adherentform',
					height  : 390,
					border	: false,
					//margin	: '0 0 5 0',
					tools	: [],
					statut  : 2	
				}]
			});
			nouveladherent_window.show();
		}, iconCls : 'user'},
		{text: 'Nouvel Enfant',handler: function(){
			nouveladherent_window = new Ext.window.Window({
				id	: 'nouveladherent_window',
				title	: 'Nouvel Enfant',
				modal	: true,
				items	: [{
					xtype	: 'adherentform',
					border	: false,
					margin	: '0 0 5 0',
					tools	: [],
					statut  : 3	
				}]
			});
			nouveladherent_window.show();
		}, iconCls : 'user'}
	]
});
