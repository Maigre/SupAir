Ext.define('MainApp.view.EnfantForm', {
	extend		 : 'Ext.form.Panel',
	alias 		 : 'widget.enfantform',
	frame 		 : true,
	height		 : 300,
	width 		 : 220,
	x     		 : 0,
	y     		 : 0,
	url   		 : BASE_URL+'data/plcontrol/save',
	frame 		 : false,
	title 		 : 'Nouvel enfant',
	iconCls 	 : 'user',
	bodyStyle    : 'padding:5px 5px 0',
	method       : 'post',
	trackResetOnLoad : 'true',
	fieldDefaults: {
		msgTarget: 'side',
		labelWidth: 60,
		allowBlank:false//,
		//labelAlign : "top",
	},
	defaultType  : 'textfield',
	/*defaults     : {
		anchor: '100%'
	},*/
	items 		 : [{
		fieldLabel: 'Pr&eacute;nom',
		//hideLabel : true,		
		id		: 'prenomfield',
		name    : 'prenom',
		value	: 'Junior',
		//cls       : 'cake',
		labelWidth: 50,
		anchor	: '96%'
	}],
	initComponent: function() {
		this.callParent(arguments);
		
	}
});
