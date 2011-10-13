villestore= new Ext.data.Store({
	storeId: 'villestore',
	fields: ['id', 'nom', 'cp',{name:'todisplay', mapping: 'nom + " " + obj.cp'}],
	autoLoad: true,
	proxy: {
		type: 'ajax',
		url: BASE_URL+'user/ville/listAll',  // url that will load data
		actionMethods : {read: 'POST'},
		reader : {
			type : 'json',
			totalProperty: 'size',
			root: 'combobox'
		}
	}          			
});

Ext.define('MainApp.view.FamilleForm', {
	extend		 : 'Ext.form.Panel',
	alias 		 : 'widget.familleform',
	id           : 'familleform',
	frame 		 : true,
	height		 : 220,
	//ui			 : 'bubble',
	width 		 : 240,
	x     		 : 0,
	y     		 : 0,
	url   		 : BASE_URL+'user/famille/save',
	frame 		 : true,
	title 		 : 'Nouvelle Famille',
	iconCls 	 : 'group',
	bodyStyle    : 'padding:5px 5px 0',
	method       : 'post',
	trackResetOnLoad : 'true',
	fieldDefaults: {
		msgTarget: 'side',
		labelWidth: 60,
		allowBlank:false
	},
	defaultType  : 'textfield',
	/*defaults     : {
		anchor: '100%'
	},*/
	items 		 : [{
			fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
			//hideLabel : true,		
			name      : 'adresse1',
			value	  : '10, rue des charmettes',
			cls       : 'house',
			labelWidth: 20
		},{
			fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
			//hideLabel : true,
			labelSeparator : '',		
			name      : 'adresse2',
			value	  : '64, bd des canuts',
			//cls       : 'house',
			labelWidth: 20
		},{
			xtype	  : 'combobox',
			store	  : 'villestore',
			fieldLabel: '',
			hideLabel : true,		
			name      : 'userVille_id',
			value	  : '',
			/*listConfig: {
                loadingText: 'Searching...',
                emptyText: 'No matching posts found.',

                // Custom rendering template for each item
                getInnerTpl: function() {
                    return '{nom} {cp}';
                }
            },*/
			displayField: 'todisplay',
			valueField: 'id'
			//cls       : 'red'
		},{
		xtype: 'container',
		anchor: '100%',
		layout: 'column',
		items:[{
			xtype: 'container',
			columnWidth:0.6,
			layout: 'anchor',
			//height: 15,		
			items : 
			[{
				xtype: 'checkboxfield',
				fieldLabel: 'Ext&eacute;rieur',
				//hideLabel : true,		
				name      : 'exterieur',
				value	  : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
				//cls       : 'yes',
				anchor	  : '96%',
				labelWidth: 80
				},{
				xtype: 'checkboxfield',
				fieldLabel: 'Bon vacances',
				//hideLabel : true,		
				name      : 'bonvacance',
				value	  : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
				//cls       : 'yes',
				anchor	  : '96%',
				labelWidth: 80
			}]},{
			xtype: 'container',
			columnWidth:0.4,
			layout: 'anchor',
			//height: 15,		
			items : 
			[{
				xtype: 'checkboxfield',
				fieldLabel: 'CCAS',
				//hideLabel : true,		
				name      : 'CCAS',
				value	  : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
				//cls       : 'yes',
				anchor	  : '96%',
				labelWidth: 40, 
				tpl : new Ext.XTemplate(
					'<tpl if="ccas == 0">',
					'no',
					'</tpl>', 
					'<tpl if="ccas == 1">', 
					'yes', 
					'</tpl>'
				) 
				},{
				xtype: 'textfield',
				fieldLabel: 'Q.F',
				//hideLabel : true,		
				name      : 'qf',
				value	  : '150',
				anchor	  : '96%',
				labelWidth: 40
				//cls       : 'yes'
			}]}]},{
			xtype: 'checkboxfield',
			fieldLabel: 'Groupe',
			//hideLabel : true,		
			name      : 'groupe',
			value	  : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
			//cls       : 'yes'
		}
	],
	buttons: [{
        text: 'Submit',
        formBind: true, //only enabled once the form is valid
        disabled: true,
        handler: function() {
            var form = this.up('form').getForm();
            form.url = BASE_URL+'user/famille/save';
            if (form.isValid()) {
                form.submit({
                    success: function(form, action) {
						Ext.Msg.alert('Success', action.result.msg);
						//SWITCH from form to display
						famillecontainer=Ext.getCmp('famillecontainer');
						famillecontainer.removeAll();
						
						familledisplay=Ext.getCmp('familledisplay');
						if(!familledisplay){
							familledisplay=Ext.widget('familledisplay');
						}						
						adherentform=Ext.getCmp('adherentform');						
						if(!adherentform){
							adherentform=Ext.widget('adherentform');
						}
						
						//set the idFamille (into hiddenfield of the adherentform)
						Ext.getCmp('id_famille_adherent_form').value=action.result.id;
						//console.info(Ext.getCmp('id_famille_adherent_form').value);
						//set the idStatut to Referent (=1) (into hiddenfield of the adherentform)
						Ext.getCmp('id_statut_adherent_form').value=1;
																		
						famillecontainer.add(familledisplay);
						famillecontainer.add(adherentform);
						
						//LOAD the famille store
						var famillestore = Ext.data.StoreManager.lookup('famillestore');
						famillestore.proxy.api.read=BASE_URL+'user/famille/show/'+action.result.id;
						famillestore.load();
						
						famillestore.on('load', function(database){
							var rec= database.getAt(0);
							familledisplay.getForm().loadRecord(rec);				
						});
						
                    },
                    failure: function(form, action) {
                        Ext.Msg.alert('Failed', action.result.msg);
                    }
                });
            }
        }
    }],
	initComponent: function() {
		this.callParent(arguments);		
	}
});
