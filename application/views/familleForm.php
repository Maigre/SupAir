villestore= new Ext.data.Store({
	storeId: 'villestore',
	fields: ['id', 'nom', 'cp',{name:'todisplay', mapping: 'nom + " " + obj.cp'}],
	autoLoad: true,
	autoSync: true,
	/*proxy: {
		type: 'ajax',
		url: BASE_URL+'user/ville/listAll/nom',  // url that will load data
		actionMethods : {read: 'POST'},
		reader : {
			type : 'json',
			totalProperty: 'size',
			root: 'combobox'
		}
	},*/
	proxy: {
		type: 'ajax',
		url: BASE_URL+'user/ville/listAll/nom',  // url that will load data
		api: {
			read: BASE_URL+'user/ville/listAll/nom',
			update: BASE_URL+'user/ville/save',
		},
		actionMethods : {read: 'POST', update: 'POST'},   	
		reader: {
			type: 'json',
			totalProperty: 'size',
			root: 'combobox'
		},
		writer: {
			type: 'json',
			//encode: 'false',
			writeAllFields: true//,
			//root: 'data'
		}
	},          			
});

Ext.define('MainApp.view.FamilleForm', {
	extend		 : 'Ext.form.Panel',
	alias 		 : 'widget.familleform',
	id           	 : 'familleform',
	frame 		 : true,
	height		 : 220,
	//ui		 : 'bubble',
	width 		 : 240,
	x     		 : 0,
	y     		 : 0,
	url   		 : BASE_URL+'user/famille/save',
	frame 		 : true,
	title 		 : 'Nouvelle Famille',
	iconCls 	 : 'group',
	bodyStyle    	 : 'padding:5px 5px 0',
	method       	 : 'post',
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
			labelWidth: 25
		},{
			fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
			//hideLabel : true,
			labelSeparator : '',		
			name      : 'adresse2',
			allowBlank: true,
			value	  : '64, bd des canuts',
			//cls       : 'house',
			labelWidth: 25
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
					labelWidth	: 25,
					store	  	: 'villestore',
					fieldLabel	: 'Ville',
					hideLabel 	: false,		
					name      	: 'userVille_id',
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
						listwindow=Ext.getCmp('listwindowville');
						if(!listwindow){
							listwindow=Ext.widget('listwindow',{
								id	: 'listwindowville',
								nom	: 'ville',
								title	: 'Nouvelle Ville',
								url	: BASE_URL+'user/ville/save',
								gridtitle : 'Modifier une ville existante',
								formfield1: ['Ville', 'nom'],
								formfield2: ['Code Postal', 'cp'],
								store	: 'villestore'
							
							});
						}
						listwindow.show();
						//console.info(Ext.widget('listwindow'));
					}
				}
			] 		
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
				labelWidth: 40
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
	/*buttons: [{
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
    }],*/
	initComponent: function() {
		this.callParent(arguments);		
	}
});
