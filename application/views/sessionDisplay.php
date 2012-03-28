Ext.define('Session', {
	extend: 'Ext.data.Model',
	fields: ['id', 'nom', 'actiActivite_id','periode', 'dates', 'agemin', 'agemax', 'capacitemin', 'capacitemax', 'anim', 'niveau', 'horairein', 'horaireout']
});



Ext.define('MainApp.view.SessionDisplay', {
	extend		 : 'Ext.form.Panel',
	alias 		 : 'widget.sessiondisplay',
	id           	 : 'sessiondisplay',
	frame 		 : true,
	statut		 : '',
	height	 	 : 200,
	width 		 : 200,
	x     		 : 0,
	y     		 : 0,
	//url   		 : BASE_URL+'data/plcontrol/save',
	frame 		 : false,
	title 		 : 'Mardi - Jazz',
	iconCls 	 : 'user',
	bodyStyle    	 : 'padding:0px 0px 0',
	method       	 : 'post',
	trackResetOnLoad : 'true',
	fieldDefaults: {
		msgTarget: 'side',
		labelWidth: 60,
		allowBlank:false//,
		//labelAlign : "top",
	},
	defaultType  : 'displayfield',
	defaults     : {
		margin: '0px 5px'
	},
	items	: [{
			fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
			//hideLabel : true,		
			name      : 'periode',
			value	  : '04-12-73',
			cls       : ''
		},{
			fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
			//hideLabel : true,		
			name      : 'dates',
			value	  : 'junior.byles@supair.fr',
			cls       : '',
			labelWidth: 25
		},{
			fieldLabel: 'Age min.',
			//hideLabel : false,		
			name      : 'agemin',
			value	  : '',
			cls       : ''
		},{
			fieldLabel: 'Age max.',
			//hideLabel : true,		
			name      : 'agemax',
			value	  : '',
			cls       : ''
		},{
			fieldLabel: 'Capacite min.',
			//hideLabel : true,		
			name      : 'capacitemin',
			value	  : '',
			cls       : ''
		},{
			fieldLabel: 'Capacite max.',
			//hideLabel : true,		
			name      : 'capacitemax',
			value	  : '',
			cls       : ''
		},{
			fieldLabel: 'Animateur',
			//hideLabel : true,		
			name      : 'anim',
			value	  : '',
			cls       : ''
		},{
			fieldLabel: 'Niveau',
			//hideLabel : true,		
			name      : 'niveau',
			value	  : '',
			cls       : ''
		},{
			fieldLabel: 'Horaires',
			//hideLabel : true,		
			name      : 'horairein',
			value	  : '',
			cls       : ''
		},{
			fieldLabel: 'Horaires',
			//hideLabel : true,		
			name      : 'horairemax',
			value	  : '',
			cls       : ''
		}
	],
	initComponent: function() {
		var me=this;
		//Hide fields
		/*this.on('render', function(){
			if (me.statut=='enfant'){ //enfant, cacher certains champs
				var fieldtohide= ['bureau','fixe','noalloc','allocataire','employeur'];
				Ext.each(fieldtohide, function(tohide) {
					me.getForm().findField(tohide).hidden = true;
					console.info(me.getForm().findField(tohide));
				})
			}			
		});*/
		
		this.callParent(arguments);
		this.store= sessionstore= new Ext.data.Store({
			storeId: 'sessionstore',
			model: 'Session',
			//requires: 'MainApp.model.PlModel',
			//model: 'MainApp.model.PlModel',
			proxy: {
				type: 'ajax',
				api: {
					read: BASE_URL+'activite/session/show/1'    		
				},
				actionMethods : {read: 'POST'},   	
				reader: {
					type: 'json',
					root: 'data',
					totalProperty: 'size',
					successProperty: 'success'
				}
			}
		});
		
	}
});
