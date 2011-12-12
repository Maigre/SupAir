Ext.define('MainApp.view.ListWindow', {
	extend		: 'Ext.window.Window',
	alias 		: 'widget.listwindow',
	id            	: 'listwindow',
	closeAction	: 'hide',
	height		: 300,
	width		: 600,
	
	//frame 	: true,
	//modal		: true,
	
   //TO DEFINE ON CREATE NEW
	nom		: 'ville',
	store		: 'villestore',
	url		: BASE_URL+'user/ville/save',
	gridtitle	: 'Modifier une ville existante',
	formfield1	: ['Ville','nom'],
	formfield2	: '',
	grid		: '',	
	title		: 'Nouvelle Ville',
   //END	
	
	initComponent: function(){
		var me=this;
		this.on('render', function() {
			
			//CREATE GRID & FORM WITH ONE OR TWO FIELDS
			
			if (me.formfield2!=''){
				grid= Ext.create('Ext.grid.Panel', {
					id	: 'gridlist'+me.nom,
					title	: me.gridtitle,
					store	: me.store,
					height	: 181,
					columns	: [
						{header: me.formfield1[0], dataIndex: me.formfield1[1], flex:1,
							editor: {
								xtype: 'textfield',
								allowBlank: true,
								//triggerAction: 'all',
								selectOnTab: true//,
								//lazyRender: true,
								//listClass: 'x-combo-list-small'
						    	}
						},
						{header: me.formfield2[0], dataIndex: me.formfield2[1],flex: 1,
							editor: {
								xtype: 'numberfield',
								allowBlank: true,
								//triggerAction: 'all',
								selectOnTab: true//,
								//lazyRender: true,
								//listClass: 'x-combo-list-small'
						    	}
						}
					],
					plugins : [
					    Ext.create('Ext.grid.plugin.CellEditing', {
						clicksToEdit: 1
					    })
					]
				});
				
				form=Ext.create('Ext.form.Panel', {
					id	: 'listform'+me.nom,
					frame	: true,
					url	: me.url,
					items	: [{
						id	: 'listformfield1',
						xtype	: 'textfield',
						fieldLabel	: me.formfield1[0],
						name	: me.formfield1[1]
					},{
						id	: 'listformfield2',			
						xtype	: 'textfield',
						fieldLabel	: me.formfield2[0],
						name	: me.formfield2[1]
					},{
						xtype	: 'container',
						layout	: {
							type: 'hbox',
							pack: 'end'
						},
						items : [{
							xtype	: 'button',
							text: 'O.K',
							formBind: true, //only enabled once the form is valid
							//disabled: true,
							handler: function() {
								var form = this.up('form').getForm();
								if (form.isValid()) {
									form.submit({
										success: function(form, action) {
											Ext.Msg.alert('Info', 'Sauvegarde effectu&eacutee');
										   	//Close the window
										   	Ext.getStore(me.store).load();
										   	this.form.owner.ownerCt.close();
										},
										failure: function(form, action) {
										    	Ext.Msg.alert('Failed', action.result.msg);
										}	
									});
								}
							}
						}]
					}]
				});
			}
			else{
				grid= Ext.create('Ext.grid.Panel', {
					id	: 'gridlist'+me.nom,
					title	: me.gridtitle,
					store	: me.store,
					columns	: [
						{header: me.formfield1[0], dataIndex: me.formfield1[1], flex:1,
							editor: {
								xtype: 'textfield',
								allowBlank: true,
								//triggerAction: 'all',
								selectOnTab: true//,
								//lazyRender: true,
								//listClass: 'x-combo-list-small'
						    	}
						}
					],
					plugins : [
					    Ext.create('Ext.grid.plugin.CellEditing', {
						clicksToEdit: 1
					    })
					]
				});
				
				form=Ext.create('Ext.form.Panel', {
					id	: 'listform'+me.nom,
					frame	: true,
					url	: me.url,
					items	: [{
						id	: 'listformfield1',
						xtype	: 'textfield',
						fieldLabel	: me.formfield1[0],
						name	: me.formfield1[1]
					},{
						xtype	: 'container',
						layout	: {
							type: 'hbox',
							pack: 'end'
						},
						items : [{
							xtype	: 'button',
							text: 'Submit',
							formBind: true, //only enabled once the form is valid
							//disabled: true,
							handler: function() {
								var form = this.up('form').getForm();
								if (form.isValid()) {
									form.submit({
										success: function(form, action) {
											Ext.Msg.alert('Info', 'Sauvegarde effectu&eacutee');
											//Reload the store
										   	Ext.getStore(me.store).load();
										   	//Close the window
										   	this.form.owner.ownerCt.close();
										},
										failure: function(form, action) {
										    	Ext.Msg.alert('Failed', action.result.msg);
										}	
									});
								}
							}
						}]
					}]
				});
				
			}
			
			me.insert(0,form);
			
			me.insert(1,grid);

		});
		
		this.callParent(arguments);
	}	
	
});
