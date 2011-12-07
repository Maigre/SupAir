/*Ext.require([
    'Ext.Window',
    'Extensible.calendar.data.MemoryEventStore',
    'Extensible.calendar.CalendarPanel',
    'Extensible.example.calendar.data.Events'
]);*/

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
	
	add_periode_window= new Ext.window.Window({
		title	: 'Nouvelle Periode',
		modal	: true,
		items	: [{
			xtype	: 'grid',
			store	: 'periodestore',
			columns	: [
				{header: 'Nom', dataIndex: 'nom', flex:1,
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
			url		: BASE_URL+'exercice/periode/save',
			items	: [{
				xtype	: 'textfield',
				fieldLabel	: 'Nom',
				name	: 'nom'
			},{
				xtype	: 'container',
				layout	: {
					type: 'hbox',
					pack: 'end'
				},
				items : [{
					xtype	: 'button',
					text	: 'Submit',
					formBind: true, //only enabled once the form is valid
					//disabled: true,
					handler: function() {
						var form = this.up('form').getForm();
						if (form.isValid()) {
							form.submit({
								success: function(form, action) {
									Ext.Msg.alert('Info', 'P&eacuteriode Sauvegard&eacute;e');
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
		}]
	});	
	
		
	Ext.override(Extensible.calendar.view.AbstractCalendar , { 
		ddCreateEventText : 'Ajouter un &eacute;v&egrave;nement au {0}',
		ddResizeEventText: 'Mettre à jour un &eacute;v&egrave;nement au {0}',
		ddMoveEventText: 'D&eacute;placer un &eacute;v&egrave;nement au {0}',
	}); 
	
	Ext.override(Extensible.calendar.form.EventDetails, { 
		titleLabelText	: 'Titre',
		title		: 'Ajout d\'un &eacute;v&egrave;nement',
		titleTextAdd	: 'Nouvel &eacute;v&egrave;nement',
		datesLabelText	: 'Du :',
		saveButtonText	: 'O.K',
		deleteButtonText: 'Supprimer',
		cancelButtonText: 'Annuler'
	});
	Ext.override(Extensible.form.field.DateRange, { 
		allDayText	: 'Journ&eacute;e',
		toText		: 'au',
		dateFormat	: 'j/n/Y'		
	});
	Ext.override(Extensible.calendar.form.EventWindow, { 
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
						//hideTrigger	: true,
						labelWidth	: 25,
						store	  	: 'periodestore',
						itemId		: this.id + '-title',
						fieldLabel	: 'Nom',
						//hideLabel 	: false,		
						name      	: Extensible.calendar.data.EventMappings.Title.name,
						displayField	: 'nom',
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
							listwindow=Ext.getCmp('listwindow');
							if(!listwindow){
								listwindow=Ext.widget('listwindow',{
									title: 'Nouvelle P&eacuteriode',
									store: 'periodestore',
									columnparams	: [['Nom','nom']],
								});
							}
							listwindow.show();
						}
					}
				] 		
			},{
			    xtype: 'extensible.daterangefield',
			    itemId: this.id + '-dates',
			    name: 'dates',
			    anchor: '95%',
			    singleLine: true,
			    fieldLabel: this.datesLabelText
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
	    	}		
	});

	// For complete details on how to customize the EventMappings object to match your
	// application data model see the header documentation for the EventMappings class.

	Extensible.calendar.data.EventMappings = {
		// These are the same fields as defined in the standard EventRecord object but the
		// names and mappings have all been customized. Note that the name of each field
		// definition object (e.g., 'EventId') should NOT be changed for the default fields
		// as it is the key used to access the field data programmatically.
		EventId		: {name: 'ID', mapping:'evt_id', type:'string'}, // int by default
		CalendarId	: {name: 'CalID', mapping: 'cal_id', type: 'string'}, // int by default
		Title		: {name: 'EvtTitle', mapping: 'evt_title', defaultValue:'Vacances de Noel'},
		StartDate	: {name: 'StartDt', mapping: 'start_dt', type: 'date', dateFormat: 'c'},
		EndDate		: {name: 'EndDt', mapping: 'end_dt', type: 'date', dateFormat: 'c'},
		RRule		: {name: 'RecurRule', mapping: 'recur_rule'},
		Location	: {name: 'AR', mapping: 'location', defaultValue: 'Lyon'},
		Notes		: {name: 'Desc', mapping: 'full_desc'},
		Url		: {name: 'LinkUrl', mapping: 'link_url'},
		IsAllDay	: {name: 'AllDay', mapping: 'all_day', type: 'boolean', defaultValue: true},
		Reminder	: {name: 'Reminder', mapping: 'reminder'},

		// We can also add some new fields that do not exist in the standard EventRecord:
		CreatedBy	: {name: 'CreatedBy', mapping: 'created_by'},
		IsPrivate	: {name: 'Private', mapping:'private', type:'boolean'}
	};
	// Don't forget to reconfigure!
	Extensible.calendar.data.EventModel.reconfigure();
	
	// One key thing to remember is that any record reconfiguration you want to perform
	// must be done PRIOR to initializing your data store, otherwise the changes will
	// not be reflected in the store's records.



	Extensible.calendar.data.CalendarMappings = {
		// Same basic concept for the CalendarMappings as above
		CalendarId:   {name:'ID', mapping: 'cal_id', type: 'string'}, // int by default
		Title:        {name:'CalTitle', mapping: 'cal_title', type: 'string'},
		Description:  {name:'Desc', mapping: 'cal_desc', type: 'string'},
		ColorId:      {name:'Color', mapping: 'cal_color', type: 'int'},
		IsHidden:     {name:'Hidden', mapping: 'hidden', type: 'boolean'}
	};
	// Don't forget to reconfigure!
	Extensible.calendar.data.CalendarModel.reconfigure();

	// Enable event color-coding:
	var calendarStore = Ext.create('Extensible.calendar.data.MemoryCalendarStore', {
		// defined in ../data/CalendarsCustom.js
		data: Ext.create('Extensible.example.calendar.data.CalendarsCustom'),
		
	});
	var eventStore = Ext.create('Extensible.calendar.data.MemoryEventStore', {
		data: Ext.create('Extensible.example.calendar.data.Events'),
		//url: BASE_URL+'exercice/calendrier/save',
		// defined in ../data/Events.js
		autoLoad: true,
		
		proxy: {
			type: 'rest',
			url: BASE_URL+'exercice/calendrier/save',
			noCache: false,
			api: {
		    		read: BASE_URL+'exercice/calendrier/load',
		    		update: BASE_URL+'exercice/calendrier/save'
		    	},
			reader: {
				type: 'json',
				root: 'data'
			},
			writer: {
				type: 'json',
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
			var title = Ext.value(operation.records[0].data[Extensible.calendar.data.EventMappings.Title.name], '(No title)');
			switch(operation.action){
			    case 'create': 
				//Extensible.example.msg('Add', 'Added "' + title + '"');
				break;
			    case 'update':
				//Extensible.example.msg('Update', 'Updated "' + title + '"');
				break;
			    case 'destroy':
				//Extensible.example.msg('Delete', 'Deleted "' + title + '"');
				break;
			}
		    }
		}//,
	});
	
	
	//Change the event form 
	/*Ext.override('Extensible.calendar.form.EventWindow', {
		getFormItemConfigs: function() {
			var items = [{
			    xtype: 'textfield',
			    itemId: this.id + '-title',
			    name: Extensible.calendar.data.EventMappings.Title.name,
			    fieldLabel: 'YA',
			    anchor: '100%'
			},{
			    xtype: 'extensible.daterangefield',
			    itemId: this.id + '-dates',
			    name: 'dates',
			    anchor: '95%',
			    singleLine: true,
			    fieldLabel: this.datesLabelText
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
	    	}
	});*/

	//
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
						    	console.log(Ext.getCmp('comboexercice').getRawValue());
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
												    	console.info(error);
												    	for (var key in error){
												    		if (error[key][0]=='alreadyexist'){
												    			Ext.Msg.alert('Failed', 'Cet exercice a d&eacutej&agrave &eacutet&eacute cr&eacute&eacute. Veuillez choisir un autre nom.');												    			
												    		}
												    		console.info(key);
												    		console.info(error[key][0]);
												    	}
												    	//console.info(error.key);
													console.info('after');
												    	Ext.each(error, function(field, value, c, d) {
   														/*console.info(field);
   														console.info(value);
   														console.info(c);
   														console.info('ok');
   														console.info(field[0]);
   														console.info(c);
   														console.info(d);*/
													});
												    	//Ext.Msg.alert('Failed', action.result.msg);
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
			xtype		: 'extensible.calendarpanel',
			id		: 'calendarpanel',
		        title		: 'Calendrier',
		        eventStore	: eventStore,		/*Ext.create('Extensible.calendar.data.MemoryEventStore', {
		                // defined in ../data/Events.js
		                data: Ext.create('Extensible.example.calendar.data.Events')
			}),*/
			calendarStore	: calendarStore,
			todayText 	: 'Aujourd\'hui',
			jumpToText	: 'Aller au',
			weekText	: 'Semaine', 
			dayText		: 'Jour',
			monthText	: 'Mois',
			multiWeekText	: '{0} Semaines',
			goText		: 'OK',
			enableEditDetails : false,
			showDayView	: false,
			showWeekView	: false,
			showMultiWeekView : false,
			listeners:{
				activate : function(panel){
					datedebut=Ext.getCmp('exerciceform').getForm().findField('debut').value;
					console.info(eventStore);
					eventStore.load();
					Ext.getCmp('calendarpanel').setStartDate(datedebut);
					
					
				}
			}
		}]
	});
	
		
	/*exercicestore= new Ext.data.Store({
		storeId: 'exercicestore',
		fields: ['id', 'nom','debut', 'fin'],
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
	});*/
	
	Ext.define('MainApp.view.calendrierWindow', {
		extend	: 'Ext.window.Window',
		layout	: 'fit',
		alias	: 'widget.calendrier_window',
		id 	: 'calendrierwindow',
		title	: 'Calendrier',
		modal	: true,
		closeAction: 'hide',
		items: [{
			xtype	: 'calendriertabpanel'
		}]
	});
});

