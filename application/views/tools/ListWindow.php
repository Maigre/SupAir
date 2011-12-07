Ext.define('MainApp.view.ListWindow', {
	extend		: 'Ext.window.Window',
	alias 		: 'widget.listwindow',
	id            	: 'listwindow',
	closeAction	: 'hide',
	height		 : 220,
	//frame 		: true,
	//modal		: true,
	columnparams	: [['Ville','nom'],['Code Postal','cp']],
   //TO DEFINE ON CREATE NEW
	//nomliste	: 'Ville',
	store		: 'villestore',	
	title		: 'Nouvelle Ville',
   //END	
	items		: [{
		xtype	: 'grid',
		id	: 'gridlist',
		store	: 'villestore',
		columns	: [
			{header: 'Ville', dataIndex: 'nom', flex:1,
				editor: {
					xtype: 'textfield',
					allowBlank: true,
					//triggerAction: 'all',
					selectOnTab: true//,
					//lazyRender: true,
					//listClass: 'x-combo-list-small'
			    	}
			},
			{header: 'Code Postal', dataIndex: 'cp',flex: 1,
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
	},{
		xtype 	: 'form',
		frame	: true,
		url		: BASE_URL+'user/ville/save',
		items	: [{
			xtype	: 'textfield',
			fieldLabel	: 'Ville',
			name	: 'nom'
		},{
			xtype	: 'textfield',
			fieldLabel	: 'Code Postal',
			name	: 'cp'
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
								Ext.Msg.alert('Info', 'Ville Sauvegard&eacute;e');
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
	}],
	initComponent: function(){
		var me=this;
		this.on('render', function() {

			
			Ext.getCmp('gridlist').store=Ext.getStore(me.store);

			Ext.getCmp('gridlist').columns.length=0;
			Ext.each(me.columnparams, function(params){

				Ext.getCmp('gridlist').columns=(new Ext.grid.column.Column({header: params[0], dataIndex: params[1], flex:1,
					editor: {
						xtype: 'textfield',
						allowBlank: true,
						//triggerAction: 'all',
						selectOnTab: true//,
						//lazyRender: true,
						//listClass: 'x-combo-list-small'
				    	}
				}));
				Ext.getCmp('gridlist').getView().refresh(true);
			})
			
			console.info(Ext.getCmp('gridlist'));
		});
		
		this.callParent(arguments);
	}	
	
});
