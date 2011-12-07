exercicestore= new Ext.data.Store({
	storeId: 'exercicestore',
	fields: ['id', 'nom','datedebut', 'datefin'],
	autoLoad: true,
	proxy: {
		type: 'ajax',
		url: BASE_URL+'exercice/exercice/listAll/debut',  // url that will load data
		actionMethods : {read: 'POST'},
		reader : {
			type : 'json',
			totalProperty: 'size',
			root: 'combobox'
		}
	}          			
});

Ext.define('MainApp.view.ActiviteForm', {
	extend		: 'Ext.form.Panel',
	alias 		: 'widget.activiteform',
	//id         	   : 'activiteform',
	statut		: '',
	frame 		: true,
	height		: 220,
	//width 		: 300,
	x     		: 0,
	y     		: 0,
	url   		: '',
	bodyStyle    	: 'padding:5px 5px 0',
	method  	: 'post',
	trackResetOnLoad: 'true',
	fieldDefaults	: {
		msgTarget : 'side',
		labelWidth: 80,
		allowBlank:false
	},
	defaultType  	: 'textfield',
	items 		: [{
			xtype	  	: 'combobox',
			typeAhead	: true,  //allow typing text to select value.
			//hideTrigger	: true,
			store	  	: exercicestore,
			fieldLabel	: 'Exercice',
			hideLabel 	: false,		
			name      	: 'exerciceExercice_id',
			displayField	: 'nom',
			valueField	: 'id'
		},{
			xtype		: 'textfield',
			fieldLabel	: 'Nom',
			name      	: 'nom',
			value	  	: 'Chant'
		},{
			xtype	  	: 'combobox',
			typeAhead	: true,  //allow typing text to select value.
			//hideTrigger	: true,
			store	  	: exercicestore,
			fieldLabel	: 'Type',
			hideLabel 	: false,		
			name      	: 'secteurtype_id',
			displayField	: 'nom',
			valueField	: 'id'
		},{
			xtype		: 'numberfield',
			fieldLabel	: 'Code Analytique',
			name      	: 'codeanalytique',
			value	  	: '350'
		},{
			xtype		: 'checkboxfield',
			fieldLabel	: 'R&eacute;duction Multi',
			//hideLabel 	: true,		
			name      	: 'reducmulti',
			value	  	: true,
			anchor	  	: '96%',
			labelWidth	: 120
		},{
			xtype		: 'checkboxfield',
			fieldLabel	: 'Pack (si dispo)',
			//hideLabel 	: true,		
			name      	: 'pack',
			value	  	: true,
			//cls       	: 'yes',
			anchor	  	: '96%',
			labelWidth	: 120
		},{
			xtype		: 'checkboxfield',
			fieldLabel	: 'Certificat M&eacute;dical',
			//hideLabel 	: true,		
			name      	: 'certificat',
			value	  	: true,
			//cls       	: 'yes',
			anchor	  	: '96%',
			labelWidth	: 120
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
					form.url = BASE_URL+'activite/activite/save';
					if (form.isValid()) {
						form.submit({
							params:{
							
							},success: function(form, action) {
								Ext.Msg.alert('Success', 'Activit&eacute; enregistr&eacute;');
								Ext.getCmp('nouvelleactivite_window').close();
								//displayactivite();
							}
						});
					}
				}
			}
		}
	]
});
	

