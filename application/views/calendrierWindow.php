/*Ext.require([
    'Ext.Window',
    'Extensible.calendar.data.MemoryEventStore',
    'Extensible.calendar.CalendarPanel',
    'Extensible.example.calendar.data.Events'
]);*/
/*
Ext.override(Ext.ensible.cal.EventEditForm, {
			layout: 'form',

			initComponent: function() {
				this.addEvents({
					eventadd: true,
					eventupdate: true,
					eventdelete: true,
					eventcancel: true
				});

				this.titleField = new Ext.form.TextField({
					fieldLabel: this.titleLabelText,
					name: Ext.ensible.cal.EventMappings.Title.name,
					anchor: '95%'
				});
				this.dateRangeField = new Ext.ensible.cal.DateRangeField({
					fieldLabel: this.datesLabelText,
					singleLine: false,
					anchor: '95%',
					listeners: {
						'change': this.onDateChange.createDelegate(this)
					}
				});
				this.reminderField = new Ext.ensible.cal.ReminderField({
					name: Ext.ensible.cal.EventMappings.Reminder.name,
					fieldLabel: this.reminderLabelText
				});
				this.notesField = new Ext.form.HtmlEditor({
					fieldLabel: this.notesLabelText,
					name: Ext.ensible.cal.EventMappings.Notes.name,
					grow: true,
					growMax: 150,
					anchor: '95%',
					height: 150
				});
				this.locationField = new Ext.form.TextField({
					fieldLabel: this.locationLabelText,
					name: Ext.ensible.cal.EventMappings.Location.name,
					anchor: '95%'
				});
				this.urlField = new Ext.form.TextField({
					fieldLabel: this.webLinkLabelText,
					name: Ext.ensible.cal.EventMappings.Url.name,
					anchor: '95%'
				});

				this.recurrenceField = new Ext.ensible.cal.RecurrenceField({
					name: Ext.ensible.cal.EventMappings.RRule.name,
					fieldLabel: this.repeatsLabelText,
					anchor: '95%'
				});

				this.calendarField = new Ext.ensible.cal.CalendarCombo({
					store: this.calendarStore,
					fieldLabel: this.calendarLabelText,
					name: Ext.ensible.cal.EventMappings.CalendarId.name
				});

				this.items = [this.titleField, this.locationField, this.dateRangeField, this.calendarField, this.recurrenceField, this.reminderField, this.notesField, this.urlField];

				this.fbar = [
					{
						text: this.saveButtonText, scope: this, handler: this.onSave
					}, {
						cls: 'ext-del-btn', text: this.deleteButtonText, scope: this, handler: this.onDelete
					}, {
						text: this.cancelButtonText, scope: this, handler: this.onCancel
					}
				];

				Ext.ensible.cal.EventEditForm.superclass.initComponent.call(this);
			},

			onLayout: Ext.ensible.cal.EventEditForm.prototype.onLayout.createSequence(function() {
				//This fix is not required in my application. But on this demonstration page, the form height is 0 if autoHeight is set to false.
				//But that is required for attaching scrollbars in form layout.
				this.el.child('form').dom.style.height = '';
			})
		});
*/
/*
Extensible.calendar.data.EventMappings = {
    EventId:     {name: 'ID', mapping:'evt_id', type:'int'},
    CalendarId:  {name: 'CalID', mapping: 'cal_id', type: 'int'},
    Title:       {name: 'EvtTitle', mapping: 'evt_title'},
    StartDate:   {name: 'StartDt', mapping: 'start_dt', type: 'date', dateFormat: 'c'},
    EndDate:     {name: 'EndDt', mapping: 'end_dt', type: 'date', dateFormat: 'c'},
    RRule:       {name: 'RecurRule', mapping: 'recur_rule'},
    Location:    {name: 'Ville', mapping: 'location', defaultValue: 'Lyon'},
    Notes:       {name: 'Desc', mapping: 'full_desc'},
    Url:         {name: 'LinkUrl', mapping: 'link_url'},
    IsAllDay:    {name: 'AllDay', mapping: 'all_day', type: 'boolean'},
    Jsr:         {name: 'Jsr', mapping: 'jsr', type: 'boolean'},
    Reminder:    {name: 'Reminder', mapping: 'reminder'},
    
    // We can also add some new fields that do not exist in the standard EventRecord:
    CreatedBy:   {name: 'CreatedBy', mapping: 'created_by'},
    IsPrivate:   {name: 'Private', mapping:'private', type:'boolean'}
};
// Don't forget to reconfigure!
Extensible.calendar.data.EventModel.reconfigure();
*/
Ext.onReady(function(){

	
	// For complete details on how to customize the EventMappings object to match your
	// application data model see the header documentation for the EventMappings class.

	Extensible.calendar.data.EventMappings = {
		// These are the same fields as defined in the standard EventRecord object but the
		// names and mappings have all been customized. Note that the name of each field
		// definition object (e.g., 'EventId') should NOT be changed for the default fields
		// as it is the key used to access the field data programmatically.
		EventId:     {name: 'ID', mapping:'evt_id', type:'string'}, // int by default
		CalendarId:  {name: 'CalID', mapping: 'cal_id', type: 'string'}, // int by default
		Title:       {name: 'EvtTitle', mapping: 'evt_title'},
		StartDate:   {name: 'StartDt', mapping: 'start_dt', type: 'date', dateFormat: 'c'},
		EndDate:     {name: 'EndDt', mapping: 'end_dt', type: 'date', dateFormat: 'c'},
		RRule:       {name: 'RecurRule', mapping: 'recur_rule'},
		Location:    {name: 'AR', mapping: 'location'},
		Notes:       {name: 'Desc', mapping: 'full_desc'},
		Url:         {name: 'LinkUrl', mapping: 'link_url'},
		IsAllDay:    {name: 'AllDay', mapping: 'all_day', type: 'boolean'},
		Reminder:    {name: 'Reminder', mapping: 'reminder'},

		// We can also add some new fields that do not exist in the standard EventRecord:
		CreatedBy:   {name: 'CreatedBy', mapping: 'created_by'},
		IsPrivate:   {name: 'Private', mapping:'private', type:'boolean'}
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
		title	: 'Calendar Window',
		width	: 850,
		height	: 700,
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
			enableEditDetails : false
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
