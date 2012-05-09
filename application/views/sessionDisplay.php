Ext.define('Session', {
	extend: 'Ext.data.Model',
	fields: ['id', 'nom', 'actiActivite_id','periode', 'dates', 'agemin', 'agemax', {name:'agedisplay', mapping: 'agemin + " &agrave; " + obj.agemax + " ans"'}, 'capacitemin', 'capacitemax', {name:'capacitedisplay', mapping: 'capacitemin + " &agrave; " + obj.capacitemax + " participants"'}, {name:'animdisplay', mapping: 'persAnimateur_prenom + " " + obj.persAnimateur_nom'},'persAnimateur_nom', 'actiNiveau_id', 'actiNiveau_nom', 'in', 'out', {name:'agedisplay', mapping: 'agemin + " &agrave; " + obj.agemax + " ans"'}, 'capacitemin', 'capacitemax', {name:'horairesdisplay', mapping: 'in + " &agrave; " + obj.out'}]
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
	//store		 : 'sessionstore',
	//url   		 : BASE_URL+'data/plcontrol/save',
	frame 		 : false,
	title 		 : 'Mardi - Jazz',
	iconCls 	 : 'user',
	bodyStyle    	 : 'padding:0px 0px 0',
	method       	 : 'post',
	trackResetOnLoad : 'true',
	fieldDefaults : {
		msgTarget : 'side',
		labelWidth : 60,
		allowBlank :false//,
		//labelAlign : "top",
	},
	defaultType  : 'displayfield',
	defaults     : {
		margin: '0px 5px'
	},
	items	: [{
			xtype:'toolbar',
			margin: '0px 0px 5px 0px',
			items: ['->',{
				text: '',
				iconCls: 'outils',
				menu: [{
					text: 'Modifier la session',
					iconCls: 'edit',
					handler: function() {
						idSession = this.parentMenu.floatParent.ownerCt.ownerCt.getForm().findField('id').value;
						edit_session(idSession);
					}
				}]
			}]
		},{
			fieldLabel: 'id',
			hidden	  : true,	
			//hideLabel : true,		
			name      : 'id',
			value	  : 0
		},{
			xtype	: 'container',
			anchor	: '96%',
			layout	: {
				type: 'hbox'
			},
			items	: [{
				xtype	  	: 'textfield',
				hidden		: true,
				fieldLabel	: 'Dates',
				name      	: 'dates'
			},{
				xtype : 'button',
				text: 'Calendrier',
				iconCls	: 'calendrier',	
				//formBind: true, //only enabled once the form is valid
				//disabled: true,
				handler: function() {
					SELECTED_DATES_temp = Ext.getCmp('sessiondisplay').getForm().findField('dates').value;
					
					SELECTED_DATES=[];
					SELECTED_DATES_temp=SELECTED_DATES_temp.split(',');
					Ext.each(SELECTED_DATES_temp, function(date){
						SELECTED_DATES.push(Number(date));
					});
					console.info(SELECTED_DATES);
					sessioncalendrierwindow = Ext.getCmp('sessioncalendrierwindow');
					if(!sessioncalendrierwindow){
						sessioncalendrierwindow=Ext.widget('sessioncalendrierwindow');
					}
					sessioncalendrierwindow.dateSelection = false;
					sessioncalendrierwindow.show();
					/*for(k=0;k<12;k++){
						Ext.getCmp('sessiondatepicker'+k).selectedUpdate();
					}*/
				},
				width	: 80,
				margins: '0 0 5 0'
			}]
		},{
			fieldLabel: 'Age',
			//hideLabel : false,		
			name      : 'agedisplay',
		},{
			fieldLabel: 'Capacit&eacute;',
			//hideLabel : true,		
			name      : 'capacitedisplay',
			value	  : '',
			cls       : ''
		},{
			fieldLabel: 'Animateur',
			//hideLabel : true,		
			name      : 'animdisplay',
			value	  : '',
			cls       : ''
		},{
			fieldLabel: 'Niveau',
			//hideLabel : true,		
			name      : 'actiNiveau_nom',
			value	  : '',
			cls       : ''
		},{
			fieldLabel: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ',
			//hideLabel : true,		
			name      : 'horairesdisplay',
			value	  : '',
			cls       : 'clock'
		}
	],
	initComponent : function() {
		var me = this;
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
		
		this.store = new Ext.data.Store({
			//storeId: 'sessionstore',
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
		
		this.callParent(arguments);
		
	}
});
