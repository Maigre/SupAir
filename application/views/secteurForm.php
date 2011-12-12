secteurstore= new Ext.data.Store({
	storeId: 'secteurstore',
	fields: ['id', 'nom', 'icon'],
	autoLoad: true,
	proxy: {
		type: 'ajax',
		url: BASE_URL+'activite/secteur/listAll/nom',  // url that will load data
		actionMethods : {read: 'POST'},
		reader : {
			type : 'json',
			totalProperty: 'size',
			root: 'combobox'
		}
	}          			
});

convert_nom_icon= function(v, record){
    
    console.info(record);
    console.info('<img border="0" src="interface/images/icons/'+record.data.file+'.png"/>');
    
    return '<img border="0" src=\"interface/images/icons/'+record.data.file+'.png\"/>';
};

iconsecteurstore= Ext.create('Ext.data.Store', {
	storeId: 'iconsecteurstore',
	fields: ['id', 'file', 'nom', {name: 'todisplay', convert: convert_nom_icon}],
	autoLoad: true,
	proxy: {
		type: 'ajax',
		url: BASE_URL+'system/img/listAll/iconsecteur',  // url that will load data
		actionMethods : {read: 'POST'},
		reader : {
			type : 'json',
			totalProperty: 'size',
			root: 'combobox'
		}
	}
});



Ext.define('MainApp.view.SecteurForm', {
	extend		: 'Ext.form.Panel',
	alias 		: 'widget.secteurform',
	//id         	   : 'activiteform',
	statut		: '',
	frame 		: true,
	height		: 220,
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
			fieldLabel	: 'Nom',
			name      	: 'nom',
			value	  	: 'Activites'
		},{
			xtype		: 'combobox',
			fieldLabel	: 'Icone',
			name      	: 'icon',
			//value	  	: 'Activites',
			store		: 'iconsecteurstore',
			displayField	: 'todisplay',
			valueField	: 'id'
			
			//typeAhead	: false,
			//hideLabel	: true,
			//hideTrigger	:true,
			/*
			anchor	: '50%',

			listConfig: {
				//loadingText: 'Searching...',
				//emptyText: 'No matching posts found.',

				// Custom rendering template for each item
				getInnerTpl: function() {
				    return '<img border="0" src="interface/images/icons/{nom}.png"/>'
				}
			}*/
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
					form.url = BASE_URL+'activite/secteur/save';
					if (form.isValid()) {
						form.submit({
							params:{
							
							},success: function(form, action) {
								Ext.Msg.alert('Success', 'Secteur enregistr&eacute;');
								Ext.getCmp('nouveausecteur_window').close();
								//displayactivite();
							}
						});
					}
				}
			}
		}
	]
});
	

