Ext.onReady(function(){

	periodestore= new Ext.data.Store({
		storeId: 'periodestore',
		fields: ['id', 'nom'],
		autoLoad: true,
		proxy: {
			type: 'ajax',
			url: BASE_URL+'exercice/periode/listAll/nom',  // url that will load data
			actionMethods : {read: 'POST'},
			reader : {
				type : 'json',
				totalProperty: 'size',
				root: 'combobox'
			}
		}          			
	});
	
	Ext.override(Extensible.calendar.form.EventWindow, { 
		id		: 'formeventwindow',
		titleTextAdd	: 'Nouvel &eacute;v&egrave;nement',
		titleTextEdit	: 'Nouvel &eacute;v&egrave;nement',
		width		: 600,
		labelWidth	: 65,
		detailsLinkText	: 'Détails...',
		savingMessage	: 'Enregistrement...',
		deletingMessage	: 'Suppression...',
		saveButtonText	: 'O.K',
		deleteButtonText: 'Delete',
		cancelButtonText: 'Cancel',
		titleLabelText	: 'Nom',
    		datesLabelText  : 'Du :',    		
    		
    		getFormItemConfigs: function() {
			var items = [{
				xtype		: 'container',
				anchor		: '56%',
				layout		: 'hbox',
				items		:[
					{
						flex	  	: 5,
						xtype	  	: 'combobox',
						typeAhead	: true,  //allow typing text to select value.
						allowBlank	: false,
						labelWidth	: 30,
						store	  	: 'periodestore',
						itemId		: this.id + '-title',
						fieldLabel	: 'Nom',
						//hideLabel 	: false,		
						name      	: Extensible.calendar.data.EventMappings.Title.name,
						displayField	: 'nom',
						valueField	: 'nom',
						listeners	: {
							select: function(a,b) {
								
							    	idperiode=a.valueModels[0].data.id;
							    	console.info(idperiode);
							    	form=this.up('form');
							    	form.getForm().findField('exPeriode_id').setValue(idperiode);
								//exPeriode_id.setValue(idperiode);
								//console.info(form.getForm().findField('exPeriode_id'));
								
								
								var exExercice_id = form.getForm().findField('exExercice_id');
								exExercice_id.setValue(EXERCICE_ID);
							}
						} 
						//cls       : 'red'
					},{
						xtype		: 'textfield',
						hidden		: true,
						name		: 'exPeriode_id'
					},{
						flex	  	: 1,
						margin		: '0 0 0 10',
						xtype		: 'button',
						//text		: 'Add',
						iconCls		: 'add',
						style		: "padding-left:6px",	
						handler		: function () {
							listwindow=Ext.getCmp('listwindowperiode');
							if(!listwindow){
								listwindow=Ext.widget('listwindow',{
									id	: 'listwindowperiode',
									nom	: 'periode',
									title	: 'Nouvelle P&eacuteriode',
									url	: BASE_URL+'exercice/periode/save',
									gridtitle: 'Modifier une periode existante',
									formfield1: ['Nom', 'nom'],
									store	: 'periodestore'							
								});
							}
							listwindow.show();
						}
					}
				] 		
			},{
				xtype	: 'extensible.daterangefield',
				itemId	: this.id + '-dates',
				name	: 'dates',
				anchor	: '95%',
				singleLine: true,
				fieldLabel: this.datesLabelText
			},{
				xtype	: 'textfield',
				name	: 'exExercice_id',
				defaultValue: EXERCICE_ID,
				hidden  : true							
			}];
		
			if(this.calendarStore){
			    items.push({
				xtype: 'extensible.calendarcombo',
				itemId: this.id + '-calendar',
				name: Extensible.calendar.data.EventMappings.CalendarId.name,
				anchor: '100%',
				fieldLabel: this.calendarLabelText,
				store: this.calendarStore
			    });
			}
			
			return items;
	    	},
	    	onRender : function(ct, position){        
			this.formPanel = Ext.create('Ext.FormPanel', Ext.applyIf({
			    id: 'formevent',
			    fieldDefaults: {
				labelWidth: this.labelWidth
			    },
			    items: this.getFormItemConfigs()
			}, this.formPanelConfig));
		
			this.add(this.formPanel);
		
			this.callParent(arguments);
		}		
	});
	
	
	Extensible.calendar.data.EventMappings = {
		// These are the same fields as defined in the standard EventRecord object but the
		// names and mappings have all been customized. Note that the name of each field
		// definition object (e.g., 'EventId') should NOT be changed for the default fields
		// as it is the key used to access the field data programmatically.
		EventId		: {name: 'ID', mapping:'id', type:'string'}, // int by default
		CalendarId	: {name: 'CalID', mapping: 'exExercice_id'}, // int by default
		Title		: {name: 'EvtTitle', mapping: 'exPeriode_id'},
		StartDate	: {name: 'StartDt', mapping: 'debut', type: 'date', /*convert: function(v,record){console.info(record)},*/ dateFormat: 'Y-m-d'},
		EndDate		: {name: 'EndDt', mapping: 'fin', type: 'date', dateFormat: 'Y-m-d'},
		RRule		: {name: 'RecurRule', mapping: 'recur_rule'},		
		IsAllDay	: {name: 'AllDay', mapping: 'all_day', type: 'boolean', defaultValue: true},
		Location	: {name: 'AR', mapping: 'location', defaultValue: 'Lyon'},
		Notes		: {name: 'Desc', mapping: 'full_desc'},
		Url		: {name: 'LinkUrl', mapping: 'link_url'},
		Reminder	: {name: 'Reminder', mapping: 'reminder'},

		// We can also add some new fields that do not exist in the standard EventRecord:
		exExercice	: {name: 'exExercice_id', mapping: 'exExercice_id'},
		exPeriode	: {name: 'exPeriode_id', mapping: 'exPeriode_id'},
		CreatedBy	: {name: 'CreatedBy', mapping: 'created_by'},
		IsPrivate	: {name: 'Private', mapping:'private', type:'boolean'}
	};
	// Don't forget to reconfigure!
	Extensible.calendar.data.EventModel.reconfigure();
	console.info('reconfigured');
	
	var reader = new Ext.data.JsonReader({
		totalProperty: 'total',
		successProperty: 'success',
		root: 'data',
		messageProperty: 'message',

		// read the id property generically, regardless of the mapping:
		idProperty: Extensible.calendar.data.EventMappings.EventId.mapping  || 'id'//,

		// this is also a handy way to configure your reader's fields generically:
		//fields: Extensible.calendar.EventRecord.prototype.fields.getRange()
	});
	
	var eventStore = Ext.create('Extensible.calendar.data.MemoryEventStore', {
		autoLoad: true,
		autoSync: true,
		storeId: 'eventstore',
		reloaded:true,
		proxy: {
			type: 'ajax',
			url: BASE_URL+'exercice/calendrier/save',
			//noCache: false,
			actionMethods : {read: 'POST', write: 'POST'},
			api: {
		    		read: BASE_URL+'exercice/calendrier/listAll',
		    		create: BASE_URL+'exercice/calendrier/save',
		    		update: BASE_URL+'exercice/calendrier/update',
		    		destroy: BASE_URL+'exercice/calendrier/delete'
		    	},
			reader: {
				type: 'json',
				root: 'data',
				idProperty: 'id'
			},
			writer: {
				type: 'singlepost',
				//encode: false,
				nameProperty: 'mapping'
			},
			listeners: {
				exception: function(proxy, response, operation, options){
					var msg = response.message ? response.message : Ext.decode(response.responseText).message;
					// ideally an app would provide a less intrusive message display
					Ext.Msg.alert('Server Error', msg);
				}
			}
		},
		// It's easy to provide generic CRUD messaging without having to handle events on every individual view.
		// Note that while the store provides individual add, update and remove events, those fire BEFORE the
		// remote transaction returns from the server -- they only signify that records were added to the store,
		// NOT that your changes were actually persisted correctly in the back end. The 'write' event is the best
		// option for generically messaging after CRUD persistence has succeeded.
		listeners: {
			'write': function(store, operation){
				console.info(operation);
				console.info(operation.records[0]);
				var title = Ext.value(operation.records[0].data[Extensible.calendar.data.EventMappings.Title.name], '(No title)');
				/*switch(operation.action){
					case 'create': 
						Extensible.example.msg('Add', 'Added "' + title + '"');
						break;
				    	case 'update':
						Extensible.example.msg('Update', 'Updated "' + title + '"');
						break;
					case 'destroy':
						Extensible.example.msg('Delete', 'Deleted "' + title + '"');
						break;
				}
				if (Ext.getCmp('ext-cal-editwin')){
					Ext.getCmp('ext-cal-editwin').close();
				}*/
				store.load();
				
			},
			'beforeload': function(store, operation){
				console.info('ok');
			},
			'load': function(store, operation){
				//store.proxy.baseParams = {where: 1};
				console.info(store.data.items);
				
				var compteur=0;
				Ext.each(store.data.items, function(event){
					compteur=compteur+1;
					console.info(event);					
					//event.data.ID=compteur;
					
					switch(event.data.EvtTitle){
						case '3':
							console.info('ok3');
							event.data.EvtTitle= 'Vacances de Noel';
							break;
							//store.load();
						case '4':
							console.info('ok4');
							event.data.EvtTitle= 'Jour de l\'an';
							break;
							//store.load();
						case '5':
							console.info('ok5');
							event.data.EvtTitle= 'Vacances de Toussaint';
							break;
							//store.load();
						case '6':
							console.info('ok6');
							event.data.EvtTitle= 'Vacances d\'ete';
							break;
							//store.load();
						case '7':
							console.info('ok7');
							event.data.EvtTitle= 'Fete du travail';
							break;	
							//store.load();	
						case '8':
							console.info('ok8');
							event.data.EvtTitle= 'Vacances de Paques';
							break;	
							//store.load();								
					}
				});
				console.info(store.data.items);				
			}
		}
	});
	
	// Now just create a standard calendar using our custom data
	//
	Ext.define('MainApp.view.calendriertabpanel', {
		extend	: 'Ext.TabPanel',
		layout	: 'fit',
		id	: 'calendriertabpanel',
		alias	: 'widget.calendriertabpanel',
		width	: 850,
		height	: 600,
		modal	: true,
		closeAction: 'hide',
		items: [{
			//premier onglet contient 
			//  **une combobox permettant de selectionner un exercice parmis ceux déjà enregistrés.
			//  **un formulaire permettant de créer un nouvel exercice
			xtype	: 'panel',
			title	: 'Exercice',
			id	: 'exercicepanel',
			items: [{
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
							console.info();
							EXERCICE_ID=Ext.getCmp('comboexercice').valueModels[0].data.id;
						    	EXERCICE= Ext.getCmp('comboexercice').getRawValue();
						    	Ext.getCmp('calendarpanel').setTitle('Exercice '+Ext.getCmp('comboexercice').getRawValue());
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
						anchor	: '40%'
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
		},{
		//DEBUT DE LA DEFINITION DU CALENDRIER
			xtype		: 'extensible.calendarpanel',
			id		: 'calendarpanel',
		        title		: 'Calendrier',
		        eventStore	: eventStore,		/*Ext.create('Extensible.calendar.data.MemoryEventStore', {
		                // defined in ../data/Events.js
		                data: Ext.create('Extensible.example.calendar.data.Events')
			}),*/
			//calendarStore	: calendarStore,
			/*todayText 	: 'Aujourd\'hui',
			jumpToText	: 'Aller au',
			weekText	: 'Semaine', 
			dayText		: 'Jour',
			monthText	: 'Mois',
			multiWeekText	: '26 Semaines',
			goText		: 'OK',
			enableEditDetails : false,
			showDayView	: false,
			showWeekView	: false,
			showMultiWeekView : true,*/
			listeners:{
				activate : function(panel){
					//datedebut=Ext.getCmp('exerciceform').getForm().findField('debut').value;
					//eventStore.load();
					//Ext.getCmp('calendarpanel').setStartDate(datedebut);
				}
			}
		}]
	});
	
	Ext.define('MainApp.view.calendrierWindow', {
		extend	: 'Ext.window.Window',
		layout	: 'fit',
		alias	: 'widget.calendrier_window',
		id 	: 'calendrier_window',
		title	: 'Calendrier',
		modal	: true,
		closeAction: 'hide',
		items: [{
			xtype	: 'calendriertabpanel'
		}]
	});	
	
	
	
});
