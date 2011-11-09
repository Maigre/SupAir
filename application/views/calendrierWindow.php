Ext.require([
	    'Ext.Window',
	    'Extensible.calendar.data.MemoryEventStore',
	    'Extensible.calendar.CalendarPanel',
	    'Extensible.example.calendar.data.Events'
]);

Ext.define('MainApp.view.CalendarWindow', {
	layout: 'fit',
	alias : 'widget.calendrier_window',
	title: 'Calendar Window',
	width: 850,
	height: 700,
	modal: true,
	closeAction: 'hide',
	items: {
	    // xtype is supported:
	    xtype: 'extensible.calendarpanel',
	    eventStore: Ext.create('Extensible.calendar.data.MemoryEventStore', {
		// defined in ../data/Events.js
		data: Ext.create('Extensible.example.calendar.data.Events')
	    })
	}
});

