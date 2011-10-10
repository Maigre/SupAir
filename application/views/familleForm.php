Ext.define('MainApp.view.FamilleForm', {
	extend		 : 'Ext.form.Panel',
	alias 		 : 'widget.familleform',
	id           : 'familleform',
	frame 		 : true,
	height		 : 220,
	//ui			 : 'bubble',
	//width 		 : 240,
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
		name      : 'adresse2',
		value	  : '64, bd des canuts',
		cls       : 'house',
		labelWidth: 20
		},{
		fieldLabel: '',
		hideLabel : true,		
		name      : 'userVille_id',
		value	  : 'Lyon'
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
				xtype: 'textfield',
				fieldLabel: 'Ext&eacute;rieur',
				//hideLabel : true,		
				name      : 'exterieur',
				value	  : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
				cls       : 'yes',
				anchor	  : '96%',
				labelWidth: 80
				},{
				xtype: 'textfield',
				fieldLabel: 'Bon vacances',
				//hideLabel : true,		
				name      : 'bonvacance',
				value	  : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
				cls       : 'yes',
				anchor	  : '96%',
				labelWidth: 80
			}]},{
			xtype: 'container',
			columnWidth:0.4,
			layout: 'anchor',
			//height: 15,		
			items : 
			[{
				xtype: 'textfield',
				fieldLabel: 'CCAS',
				//hideLabel : true,		
				name      : 'CCAS',
				value	  : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
				cls       : 'yes',
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
			fieldLabel: 'Groupe',
			//hideLabel : true,		
			name      : 'groupe',
			value	  : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
			cls       : 'yes'
		}
	],
	buttons: [{
        text: 'Submit',
        formBind: true, //only enabled once the form is valid
        disabled: true,
        handler: function() {
            var form = this.up('form').getForm();
            form.url = BASE_URL+'user/famille/save';
            console.info(form);
            if (form.isValid()) {
                form.submit({
                    success: function(form, action) {
                       Ext.Msg.alert('Success', action.result.msg);
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
