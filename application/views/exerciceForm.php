exercicestore = new Ext.data.Store({
	storeId: 'exercicestore',
	fields: ['id', 'nom', 'debut', 'fin'],
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

Ext.define('MainApp.view.exerciceForm', {
	extend		: 'Ext.panel.Panel',
	alias 		: 'widget.exerciceformpanel',
	id		: 'exerciceformpanel',
	//id         	   : 'activiteform',
	frame 		: true,
	height		: 450,
	width 		: 400,
	xtype		: 'panel',
	title		: 'Exercice',
	items	: [{
		xtype	: 'form',
		url 	: BASE_URL+'exercice/exercice/save',
		id	: 'exerciceform',
		items	:[{
			xtype		: 'combo',
			id		: 'comboexercice',
			fieldLabel	: 'Exercice',
			store		: exercicestore,
			displayField	: 'nom',
			valueField	: 'id',
			padding		: 10,
			listeners: {
				select: {
				    //element: 'el', //bind to the underlying body property on the panel
				    fn: function(){ 
					/*
					EXERCICE_ID=Ext.getCmp('comboexercice').valueModels[0].data.id;
				    	EXERCICE= Ext.getCmp('comboexercice').getRawValue();
				    	Ext.getCmp('calendarpanel').setTitle('Exercice '+Ext.getCmp('comboexercice').getRawValue());*/
				    }
				}
			}				
		},{
			xtype		: 'fieldset',
			id		: 'fieldsetexercice',
			title		: 'Nouvel Exercice',					
			collapsible	: true,
			collapsed	: true,
			layout		: 'anchor',
			defaults	: {
				anchor	: '96%'
			},
			items :[{
				xtype	: 'form',
				frame	: false,
				border  : 0,
				width	: 500, 
				fieldDefaults	: {
					allowBlank:false
				},
				items	:[
					{
						xtype		: 'textfield',
						fieldLabel	: 'Nom de l\'exercice',
						name		: 'nom',
						value		: '2011 - 2012'
					},{
						xtype		: 'datefield',
						format		: 'd/m/Y',
						fieldLabel	: 'D&eacute;but',
						name		: 'debut'
					},{
						xtype		: 'datefield',
						format		: 'd/m/Y',
						fieldLabel	: 'Fin',
						name		: 'fin'
					},{
						xtype	  : 'container',
						layout	  : {
							type  : 'hbox',
							align : 'middle',
							pack  : 'end'
						},
						items: {
							xtype 	: 'button',
							margin 	: 2,
							text: 'OK',
							formBind: true, //only enabled once the form is valid
							disabled: true,
							handler	: function() {
						
								var form = this.up('form').getForm();
								form.url= BASE_URL+'exercice/exercice/save';
								if (form.isValid()) {
									form.submit({
										success: function(form, action) {
											Ext.Msg.alert('Info', 'Exercice Sauvegard&eacute;');
										   	//Close the window
										   	Ext.getCmp('fieldsetexercice').collapse();
										   	Ext.getStore('exercicestore').load();
										},
										failure: function(form, action) {
										    	error=action.result.error;

										    	for (var key in error){
										    		if (error[key][0]=='alreadyexist'){
										    			Ext.Msg.alert('Failed', 'Cet exercice a d&eacutej&agrave &eacutet&eacute cr&eacute&eacute. Veuillez choisir un autre nom.');
										    		}
										    	}
										    	Ext.each(error, function(field, value, c, d) {
											});
										}	
									});
								}
								Ext.getCmp('fieldsetexercice').collapse();
							}
						}
					}
				]
			}]
		}]
	}]
});
