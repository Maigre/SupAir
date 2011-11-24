/*Ext.require([
    'Ext.Window',
    'Extensible.calendar.data.MemoryEventStore',
    'Extensible.calendar.CalendarPanel',
    'Extensible.example.calendar.data.Events'
]);*/

Ext.onReady(function(){

	
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
		titleTextEdit	: 'Edit Event',
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

	var eventStore = Ext.create('Extensible.calendar.data.MemoryEventStore', {
	// defined in ../data/EventsCustom.js
		data: Ext.create('Extensible.example.calendar.data.EventsCustom')
	});

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
		data: Ext.create('Extensible.example.calendar.data.CalendarsCustom')
	});
	var eventStore = Ext.create('Extensible.calendar.data.MemoryEventStore', {
	});
	/*
		// defined in ../data/Events.js
		autoLoad: true,
		proxy: {
			type: 'rest',
			url: BASE_URL+'exercice/calendrier/save',
			noCache: false,

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
				Extensible.example.msg('Add', 'Added "' + title + '"');
				break;
			    case 'update':
				Extensible.example.msg('Update', 'Updated "' + title + '"');
				break;
			    case 'destroy':
				Extensible.example.msg('Delete', 'Deleted "' + title + '"');
				break;
			}
		    }
		}//,
	});*/

	//
	// Now just create a standard calendar using our custom data
	//
	Ext.define('MainApp.view.calendrierWindow', {
		extend	: 'Ext.window.Window',
		layout	: 'fit',
		alias	: 'widget.calendrier_window',
		title	: 'Calendrier',
		width	: 850,
		height	: 600,
		modal	: true,
		closeAction: 'hide',
		items: [{
			xtype		: 'extensible.calendarpanel',
		        eventStore	: eventStore,
			calendarStore	: calendarStore,
		        title		: 'Custom Event Mappings',
			todayText 	: 'Aujourd\'hui',
			jumpToText	: 'Aller au',
			weekText	: 'Semaine', 
			dayText		: 'Jour',
			monthText	: 'Mois',
			multiWeekText	: '{0} Semaines',
			goText		: 'OK',
			enableEditDetails : false,
			showDayView	: false
		}]
	});
	
	exercicestore= new Ext.data.Store({
		storeId: 'exercicestore',
		fields: ['id', 'nom','datedebut', 'datefin'],
		autoLoad: true,
		proxy: {
			type: 'ajax',
			url: BASE_URL+'calendrier/calendrier/listAll/nom',  // url that will load data
			actionMethods : {read: 'POST'},
			reader : {
				type : 'json',
				totalProperty: 'size',
				root: 'combobox'
			}
		}          			
	});
	
	Ext.define('MainApp.view.exerciceWindow', {
		extend	: 'Ext.window.Window',
		layout	: 'fit',
		alias	: 'widget.exercice_window',
		title	: 'S&eacute;lection de l\'exercice',
		
		//width	: 850,
		//height	: 600,
		modal	: true,
		closeAction: 'hide',
		items: [{
			xtype	: 'form',
			//margins : 2,
			items	:[{
				xtype		: 'combo',
				fieldLabel	: 'Exercice',
				store		: exercicestore,
				margins  	: 2,	
				
			},{
				xtype		:'fieldset',
				title		: 'Nouvel Exercice',
				collapsible	: true,
				collapsed	: true,
				//defaultType	: 'textfield',
				layout		: 'anchor',
				defaults	: {
					anchor	: '100%'
				},
				items :[{
					xtype		: 'textfield',
					fieldLabel	: 'Nom de l\'exercice',
					name		: 'nom',
					value		: '2011/2012'
					},{
					xtype		: 'datefield',
					fieldLabel	: 'D&eacute;but',
					name		: 'debut_exercice'
					},{
					xtype		: 'datefield',
					fieldLabel	: 'Fin',
					name		: 'fin_exercice'
				}]
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
						calendrier_window=Ext.widget('calendrier_window');
						calendrier_window.show();
					}
				}
			}]
		}]
	});
});

















/*showDayView: false,
		todayText : 'Aujourd\'hui',
		jumpToText: 'Aller au',
		weekText : 'Semaine', 
		monthText: 'Mois',
		multiWeekText: '{0} Semaines',
		
		
		/*Ext.create('Extensible.calendar.data.MemoryEventStore', {
		// defined in ../data/Events.js
		autoLoad: true,
		proxy: {
			type: 'rest',
			url: BASE_URL+'exercice/calendrier/save',
			noCache: false,

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
				Extensible.example.msg('Add', 'Added "' + title + '"');
				break;
			    case 'update':
				Extensible.example.msg('Update', 'Updated "' + title + '"');
				break;
			    case 'destroy':
				Extensible.example.msg('Delete', 'Deleted "' + title + '"');
				break;
			}
		    }
		}//,

		})*/
