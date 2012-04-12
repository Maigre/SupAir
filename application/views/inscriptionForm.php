reductionstore= new Ext.data.Store({
	storeId: 'reductionstore',
	fields: ['id', 'nom', 'valeur'],
	autoLoad: true,
	proxy: {
		type: 'ajax',
		url: BASE_URL+'activite/reduction/listAll',  // url that will load data
		actionMethods : {read: 'POST'},
		reader : {
			type : 'json',
			totalProperty: 'size',
			root: 'combobox'
		}
	}
});

update_tarif= function(){
	var tarif = Ext.getCmp('tarif_field').value;
	
	
	var nombre_seances = Ext.getCmp('nombre_seances_field').value;
	var total_seances = Ext.getCmp('total_seances').value;

	var reduc_id = Ext.getCmp('reduc_combobox').getValue();
	
	if (reduc_id){
		var reduc = Ext.getStore('reductionstore').getById(reduc_id).data.valeur;
		total_facture = Math.round(tarif * (nombre_seances/total_seances) * (1+parseInt(reduc)/100));
		Ext.getCmp('total_facture_field').setValue(total_facture);
		Ext.getCmp('total_facture_display_field').setValue(total_facture);
	}
		
	
	
}




Ext.define('MainApp.view.InscriptionForm', {
	extend		: 'Ext.form.Panel',
	alias 		: 'widget.inscriptionform',
	//id   		: 'activiteform',
	statut		: '',
	frame 		: true,
	height		: 220,
	width 		: 200,
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
		xtype	: 'hiddenfield',
		name	: 'userAdherent_id'
	},{
		xtype	: 'hiddenfield',
		name	: 'actiSession_id'
	},{
		xtype	: 'hiddenfield',
		id	: 'tarif_initial_field',
		name	: 'tarif_initial',
		value	: 250
	},{
		xtype	: 'container',
		layout	: 'hbox',
		items:[{
			xtype		: 'textfield',
			id		: 'nombre_seances_field',
			fieldLabel	: '',
			labelSeparator	: ' ',
			margin		: '0 0 0 3',
			//labelWidth	: 80,
			//hideLabel	: true,
			name		: 'nbre_seances',
			width		: 76,
			listeners 	:{
				'change': function(me) {
					update_tarif();
				}
			}
		},{
			xtype		: 'displayfield',
			name		: 'stringfield',
			hideLabel	: true,
			value		: ' / ',
			margin		: '0 0 0 3',
			flex		: 1
		},{
			xtype		: 'displayfield',
			id		: 'total_seances',
			name		: 'total_seances',
			hideLabel	: true,
			value		: 31,
			flex		: 1
		},{
			xtype		: 'displayfield',
			name		: 'stringfield2',
			hideLabel	: true,
			value		: 's&eacute;ances',
			margin		: '0 0 0 3',
			flex		: 3
		}]
	},{
		xtype	  	: 'textfield',
		id		: 'tarif_field',
		fieldLabel	: 'Tarif (&euro;)',	
		name      	: 'tarif'
	},{
		xtype	  	: 'combobox',
		id		: 'reduc_combobox',
		fieldLabel	: 'R&eacute;duction',
		name      	: 'reduc',
		store	  	: 'reductionstore',
		displayField	: 'nom',
		valueField	: 'id',
		listeners 	:{
			'change': function(me) {
				update_tarif();
			}
		}
	},{
		xtype		: 'displayfield',
		fieldLabel	: 'Total Facture',
		name		: 'total_facture_display',
		id		: 'total_facture_display_field'
	},{
		xtype		: 'hiddenfield', //this field because the displayfield above can't be send on form submit
		name		: 'total_facture',
		id		: 'total_facture_field'
	}],
	buttons: [{
		text	: 'Inscription' ,
		formBind: true, //only enabled once the form is valid
		disabled: true,
		handler	: function() {
			var form = this.up('form').getForm();
			form.url = BASE_URL+'activite/inscription/save';
			
			form.findField('actiSession_id').setValue(ID_SESSION);
			form.findField('userAdherent_id').setValue(ID_ADHERENT);
			
			if (form.isValid()) {
				form.submit({
					success: function(form, action) {
						Ext.Msg.alert('Success', 'inscription effectu&eacute;e', function(){
							//Ext.getCmp('nouvellesession_window').close();
							//displayactivite(ACTIVITE_ID);
						});
				
					},
					failure: function(form, action){
						Ext.Msg.alert('Failed', action.result.error.nom[0]);
					}
				});
			}
		}
	}],
});
	

