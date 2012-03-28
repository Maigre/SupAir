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
		{id: '7', nom: 'Dimanche'},
    	]      			
});


Ext.define('MainApp.view.SessionForm', {
	extend		: 'Ext.form.Panel',
	alias 		: 'widget.sessionform',
	//id         	   : 'activiteform',
	statut		: '',
	frame 		: true,
	height		: 800,
	width 		: 300,
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
	items 		: [{
			xtype		: 'textfield',
			hidden		: true,
			fieldLabel	: 'Nom',
			name      	: 'actiActivite_id',
			value	  	: 1
		},{
			//xtype	  	: 'displayfield',
			fieldLabel	: 'Nom',
			//hideLabel 	: false,		
			name      	: 'nom'
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
			//xtype	  	: 'displayfield',
			fieldLabel	: 'Dates',
			//hideLabel 	: false,		
			name      	: 'dates',
			value		: '02/10/2012'
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
					form.url = BASE_URL+'activite/session/save';
					form.findField('actiActivite_id').setValue(ACTIVITE_ID);
					//form.findField('exExercice_id').setValue(EXERCICE_ID);
					if (form.isValid()) {
						form.submit({
							success: function(form, action) {
								Ext.Msg.alert('Success', 'Session enregistr&eacute;e');
								Ext.getCmp('nouvellesession_window').close();
								//displayactivite();
							}
						});
					}
				}
			}
		}
	]
});
	

