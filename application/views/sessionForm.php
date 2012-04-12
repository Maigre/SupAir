animateurstore= new Ext.data.Store({
	storeId: 'animateurstore',
	fields: ['id', 'nom','prenom',{name:'todisplay', mapping: 'nom + " " + obj.prenom'}],
	autoLoad: true,
	proxy: {
		type: 'ajax',
		url: BASE_URL+'personnel/animateur/listAll/',  // url that will load data
		actionMethods : {read: 'POST'},
		reader : {
			type : 'json',
			totalProperty: 'size',
			root: 'combobox'
		}
	}          			
});

niveaustore= new Ext.data.Store({
	storeId: 'niveaustore',
	fields: ['id', 'nom'],
	autoLoad: true,
	proxy: {
		type: 'ajax',
		url: BASE_URL+'activite/niveau/listAll/nom',  // url that will load data
		actionMethods : {read: 'POST'},
		reader : {
			type : 'json',
			totalProperty: 'size',
			root: 'combobox'
		}
	}          			
});

periodesemainestore= new Ext.data.Store({
	storeId: 'periodesemainestore',
	fields: ['id', 'nom'],
	autoLoad: true,
	data: [
		{id: '1', nom: 'Lundi'},
		{id: '2', nom: 'Mardi'},
		{id: '3', nom: 'Mercredi'},
		{id: '4', nom: 'Jeudi'},
		{id: '5', nom: 'Vendredi'},
		{id: '6', nom: 'Samedi'},
		{id: '7', nom: 'Dimanche'}
    	]      			
});


Ext.define('MainApp.view.SessionForm', {
	extend		: 'Ext.form.Panel',
	alias 		: 'widget.sessionform',
	id		: 'sessionform',
	statut		: '',
	frame 		: true,
	height		: 800,
	width 		: 600,
	x     		: 0,
	y     		: 0,
	url   		: '',
	bodyStyle    	: 'padding:5px 5px 0',
	method  	: 'post',
	trackResetOnLoad: 'true',
	fieldDefaults	: {
		msgTarget : 'side',
		labelWidth: 80,
		anchor	  : '96%',
		allowBlank:false
	},
	defaultType  	: 'textfield',
	layout	: {
		type: 'hbox'
	},
	items 		: [{
		flex	: 1,
		height	: 800,
		xtype	: 'container',
		anchor	: '96%',
		/*layout	: {
			type: 'vbox'
		},*/
		defaultType  	: 'textfield',
		items	: [{
				xtype		: 'textfield',
				hidden		: true,
				fieldLabel	: 'Nom',
				name      	: 'actiActivite_id',
				value	  	: 1
			},{
				//xtype	  	: 'displayfield',
				fieldLabel	: 'Nom',
				//hideLabel 	: false,		
				name      	: 'nom',
				anchor		: '96%'
			},{
				xtype		: 'container',
				anchor		: '96%',
				layout		: {
					type: 'hbox'
				},
				items		: [{
					flex		: 5,
					xtype		: 'combobox',
					fieldLabel	: 'P&eacuteriode',
					name      	: 'periode',
					store		: 'periodesemainestore',
					displayField	: 'nom',
					valueField	: 'id'
				}]
			},{
				xtype	: 'container',
				anchor	: '96%',
				layout	: {
					type: 'hbox'
				},
				items	: [{
					xtype	  	: 'textfield',
					hidden		: true,
					fieldLabel	: 'Dates',
					//hideLabel 	: false,		
					name      	: 'dates',
					value		: '02/10/2012',
					labelWidth	: 80,
					width		: 90
				},{
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
				}]
			},{
				xtype		: 'container',
				anchor		: '96%',
				layout		: {
					type: 'hbox'
				},
				items		: [{
					flex		: 5, 
					xtype	  	: 'numberfield',
					fieldLabel	: 'Age Min',
					//hideLabel 	: false,		
					name      	: 'agemin',
					margins		: '0 10 0 0'
				},{
					flex		: 3, 
					xtype	  	: 'numberfield',
					fieldLabel	: 'Max',
					name      	: 'agemax',
					labelWidth	: 25
				}]
			},{
				xtype		: 'container',
				anchor		: '96%',
				layout		: {
					type: 'hbox'
				},
				items		: [{
					flex		: 5, 
					xtype	  	: 'numberfield',
					fieldLabel	: 'Capacite Min',
					//hideLabel 	: false,		
					name      	: 'capacitemin',
					margins		: '0 10 0 0'
				},{
					flex		: 3, 
					xtype	  	: 'numberfield',
					fieldLabel	: 'Max',
					name      	: 'capacitemax',
					labelWidth	: 25
				}]
			},{
				xtype		: 'container',
				anchor		: '96%',
				layout		: 'hbox',
				items		:[
					{
						flex	  	: 5,
						xtype	  	: 'combobox',
						typeAhead	: true,  //allow typing text to select value.
						hideTrigger	: true,
						labelWidth	: 80,
						store	  	: 'animateurstore',
						fieldLabel	: 'Animateur',
						hideLabel 	: false,		
						name      	: 'persAnimateur_id',
						displayField	: 'todisplay',
						valueField	: 'id'
						//cls       : 'red'
					},{
						flex	  	: 1,
						margin		: '0 0 0 10',
						xtype		: 'button',
						//text		: 'Add',
						iconCls		: 'add',
						style		: "padding-left:6px",	
						handler		: function () {
							listwindow=Ext.getCmp('listwindowanimateur');
							if(!listwindow){
								listwindow=Ext.widget('listwindow',{
									id	: 'listwindowanimateur',
									nom	: 'anim',
									title	: 'Nouvel Animateur',
									url	: BASE_URL+'personnel/animateur/save',
									gridtitle : 'Modifier un animateur',
									formfield1: ['Nom', 'nom'],
									formfield2: ['Prenom', 'prenom'],
									store	: 'animateurstore'
						
								});
							}
							listwindow.show();
							//console.info(Ext.widget('listwindow'));
						}
					}
				] 		
			},{
				xtype		: 'container',
				anchor		: '96%',
				layout		: {
					type: 'hbox'
				},
				items		: [{
					flex		: 3,
					xtype		: 'checkboxfield',
					fieldLabel	: 'Niveau',
					//hideLabel 	: true,		
					name      	: 'niveau',
					value	  	: true,
					anchor	  	: '30%',	
					handler		: function (chk, checked) {
						Ext.getCmp('cbniveau').setVisible(checked);
						Ext.getCmp('buttonniveau').setVisible(checked);
				
					}
					//labelWidth	: 120
				},{
					flex	  	: 3,
					xtype	  	: 'combobox',
					id		: 'cbniveau',
					typeAhead	: true,  //allow typing text to select value.
					hidden		: true,
					//hideTrigger	: true,
					labelWidth	: 25,
					store	  	: 'niveaustore',
					fieldLabel	: '',
					hideLabel 	: true,		
					name      	: 'actiNiveau_id',
					displayField	: 'nom',
					valueField	: 'id'
					//cls       : 'red'
				},{
					flex	  	: 1,
					hidden		: true,
					margin		: '0 0 0 10',
					xtype		: 'button',
					id		: 'buttonniveau',
					//text		: 'Add',
					iconCls		: 'add',
					style		: "padding-left:6px",	
					handler		: function () {
						listwindow=Ext.getCmp('listwindowniveau');
						if(!listwindow){
							listwindow=Ext.widget('listwindow',{
								id	: 'listwindowniveau',
								nom	: 'niveau',
								title	: 'Nouveau Niveau',
								url	: BASE_URL+'activite/niveau/save',
								gridtitle : 'Modifier un niveau existant',
								formfield1: ['Niveau', 'nom'],
								//formfield2: ['Code Postal', 'cp'],
								store	: 'niveaustore'						
							});
						}
						listwindow.show();
						//console.info(Ext.widget('listwindow'));
					}
				}]
			},{
				xtype		: 'container',
				anchor		: '96%',
				layout		: {
					type: 'hbox'
				},
				items		: [{
					flex		: 4,
					xtype		: 'checkboxfield',
					fieldLabel	: 'Horaires',
					//hideLabel 	: true,		
					name      	: 'horaire',
					value	  	: true,
					anchor	  	: '30%',	
					handler		: function (chk, checked) {
						console.info('ok');
						Ext.getCmp('horairein').setVisible(checked);
						Ext.getCmp('horaireout').setVisible(checked);
				
					}
				},{
					flex		: 3,
					labelWidth	: 15,
					xtype		: 'timefield',
					id		: 'horairein',
					hidden		: true,
					name		: 'in',
					fieldLabel	: 'De',
					minValue	: '7:30 AM',
					maxValue	: '8:00 PM',
					increment	: 5,
					anchor		: '70%',
					margins		: '0 10 0 0'
				},{
					flex		: 3,
					labelWidth	: 15,
					xtype		: 'timefield',
					id		: 'horaireout',
					hidden		: true,
					name		: 'out',
					hideLabel	: false,
					fieldLabel	: '&agrave',
					minValue	: '7:30 AM',
					maxValue	: '8:00 PM',
					increment	: 5,
					anchor		: '70%'
				}]
			}
		]},
		//2eme colonne 
		{
			xtype	: 'container',
			flex	: 1,
			anchor	: '96%',
			height	: 800,
			margin	: '0 0 0 20',
			/*layout	: {
				type: 'vbox'
			},*/
			items	: [{
				xtype      : 'fieldcontainer',
				fieldLabel : '',
				defaultType: 'radiofield',
				items: [
				{
					boxLabel  : 'Tarif Qf Palier',
					name      : 'tarif',
					inputValue: 'palier',
					id        : 'radio_tarif_palier',
					handler	  : function(checkbox, checked){
						if(checked){
							Ext.getCmp('tarif_palier_container').show();
						}
						else{
							Ext.getCmp('tarif_palier_container').hide();
						}
					}		
				},{
					boxLabel  : 'Tarif unique',
					name      : 'tarif',
					inputValue: 'unique',
					id        : 'radio_tarif_unique',
					handler	  : function(checkbox, checked){
						if(checked){
							Ext.getCmp('tarif_unique_field').show();
						}
						else{
							Ext.getCmp('tarif_unique_field').hide();
						}
					}		
				},{
					boxLabel  : 'Tarif QF Lin&eacute;aire',
					name      : 'tarif',
					inputValue: 'palier',
					id        : 'radio_tarif_lineaire',
					handler	  : function(checkbox, checked){
						if(checked){
							Ext.getCmp('tarif_lineaire_field').show();
						}
						else{
							Ext.getCmp('tarif_lineaire_field').hide();
						}
					}		
				}]
			},{
				xtype	: 'container',
				id	: 'tarif_container',
				anchor	: '96%',
				items	:[{
					xtype		: 'textfield',
					id		: 'tarif_unique_field',
					hidden		: true,
					fieldLabel	: 'Prix (&euro;)',
					//hideLabel 	: false,		
					name      	: 'tarif_unique',
					value		: '0',
					labelWidth	: 80					
				},{
					xtype		: 'textfield',
					id		: 'tarif_lineaire_field',
					hidden		: true,
					fieldLabel	: 'Prix Max (&euro;)',
					//hideLabel 	: false,		
					name      	: 'tarif_lineaire',
					value		: '0',
					labelWidth	: 80
				},{
					xtype	: 'container',
					id	: 'tarif_palier_container',
					anchor	: '100%',
					hidden	: true
				}]
			}]
		}
	],
	buttons: [{
		text: 'O.K' ,
		formBind: true, //only enabled once the form is valid
		disabled: true,
		handler: function() {
			var form = this.up('form').getForm();
			form.url = BASE_URL+'activite/session/save';
			form.findField('actiActivite_id').setValue(ACTIVITE_ID);
			//form.findField('exExercice_id').setValue(EXERCICE_ID);
			if (form.isValid()) {
				form.submit({
					success: function(form, action) {
						Ext.Msg.alert('Success', 'Session enregistr&eacute;e', function(){
							Ext.getCmp('nouvellesession_window').close();
							displayactivite(ACTIVITE_ID);
						});
				
						//displayactivite();
					},
					failure: function(form, action){
						Ext.Msg.alert('Failed', action.result.error.nom[0]);
					}
				});
			}
		}
	}],
	initComponent: function() {
		//Création du tableau des tarifs par palier de QF
		this.on('render', function(){
			Ext.Ajax.request({
				url	: BASE_URL+'exercice/tranchesqf/listAll',
				method 	: 'POST',
				success	: function(response){
					var options = Ext.decode(response.responseText);			
					console.info(options);
					i=0;
					Ext.each(options, function(tranche) {
						field = Ext.create('Ext.form.field.Text', {
							fieldLabel 	: tranche.min+' - '+tranche.max,
							name		:'tarif'+i,
							id		: 'tarif_field'+i,
							value		: '0',
							labelWidth 	: 80		
						});
						i++;
						Ext.getCmp('tarif_palier_container').add(field);
						//console.info(me.getForm().findField(tohide));
					})
				}
			});
		});
		this.callParent(arguments);
	}
});
	

