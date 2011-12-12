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
		dateFormat	: 'j/n/Y',
		initComponent: function() {
			var me = this;
			/**
			 * @cfg {String} timeFormat
			 * The time display format used by the time fields. By default the DateRange uses the
			 * {@link Extensible.Date.use24HourTime} setting and sets the format to 'g:i A' for 12-hour time (e.g., 1:30 PM) 
			 * or 'G:i' for 24-hour time (e.g., 13:30). This can also be overridden by a static format string if desired.
			 */
			me.timeFormat = me.timeFormat || (Extensible.Date.use24HourTime ? 'G:i' : 'g:i A');
		
			me.items = me.getFieldConfigs();
			me.addCls('ext-dt-range');
			me.on('render', function() {
				
				Ext.getCmp(me.id + '-allday').setValue(true);
			});
			
			me.callParent(arguments);
			
			me.initRefs();
		},
		getStartTimeConfig: function() {
			return {
			    xtype: 'timefield',
			    id: this.id + '-start-time',
			    hidden: true,
			    labelWidth: 0,
			    hideLabel: true,
			    width: 90,
			    //format: this.timeFormat,
			    listeners: {
				'select': {
				    fn: function(){
					this.onFieldChange('time', 'start');
				    },
				    scope: this
				}
			    }
			};
		},
		getEndTimeConfig: function() {
			return {
			    xtype: 'timefield',
			    id: this.id + '-end-time',
			    hidden: true,//this.showTimes === false,
			    labelWidth: 0,
			    hideLabel: true,
			    width: 90,
			    //format: this.timeFormat,
			    defaultValue: '',
			    listeners: {
				'select': {
				    fn: function(){
				        this.onFieldChange('time', 'end');
				    },
				    scope: this
				}
			    }
			};
		},
		getAllDayConfig: function() {
			return {
			    xtype	: 'checkbox',
			    //checked	: true,
			    //defaultValue: true,
			    id		: this.id + '-allday',
			    //hidden	: true,//this.showTimes === false || this.showAllDay === false,
			    boxLabel	: this.allDayText,
			    margins	: { top: 2, right: 5, bottom: 0, left: 0 },
			    handler	: this.onAllDayChange,
			    scope	: this
			};
		},		
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
						//hideTrigger	: true,
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
							    	var exPeriode_id = form.getForm().findField('exPeriode_id');
								exPeriode_id.setValue(idperiode);
								
								var exExercice_id = form.getForm().findField('exExercice_id');
								exExercice_id.setValue(EXERCICE_ID);
							}
						} 
						//cls       : 'red'
					},{
						xtype		: 'textfield',
						hidden		: true,
						name		: 'exPeriode_id',
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
		CalendarId	: {name: 'CalID', mapping: 'type', type: 'string'}, // int by default
		Title		: {name: 'EvtTitle', mapping: 'exPeriode', defaultValue:'Vacances de Noel'},
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
	
	//Pour que le writer puisse envoyer en post
	Ext.define('Ext.data.writer.SinglePost', {
	    extend: 'Ext.data.writer.Writer',
	    alternateClassName: 'Ext.data.SinglePostWriter',
	    alias: 'writer.singlepost',

	    writeRecords: function(request, data) {
		request.params = data[0];
		return request;
	    }
	});

	
	var eventStore = Ext.create('Extensible.calendar.data.MemoryEventStore', {
		//data: Ext.create('Extensible.example.calendar.data.Events'),
		//url: BASE_URL+'exercice/calendrier/save',
		// defined in ../data/Events.js
		autoLoad: true,
		
		proxy: {
			type: 'rest',
			url: BASE_URL+'exercice/calendrier/save',
			noCache: false,
			actionMethods : {read: 'POST', write: 'POST'},
			api: {
		    		read: BASE_URL+'exercice/calendrier/load',
		    		update: BASE_URL+'exercice/calendrier/save'
		    	},
			reader: {
				type: 'json',
				root: 'data'
			},
			writer: {
				type: 'singlepost',
				nameProperty: 'mapping'
			},
			listeners: {
				beforewrite: function() {
				    	console.info('ok');
				},
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
		}

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

