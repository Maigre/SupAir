/*!
 * Extensible 1.5.0
 * Copyright(c) 2010-2011 Extensible, LLC
 * licensing@ext.ensible.com
 * http://ext.ensible.com
 */
Ext.define('Extensible.example.calendar.data.CalendarsCustom', {
    constructor: function() {
        return {
            "calendars":[{
                "cal_id":"vacances",
                "cal_title":"Vacances",
                "cal_color":7
            },{
                "cal_id":"jourferme",
                "cal_title":"Jours Fermés",
                "cal_color":2
            }/*,{
                "cal_id":"C3",
                "cal_title":"School",
                "cal_color":7
            },{
                "cal_id":"C4",
                "cal_title":"Sports",
                "cal_color":26
            }*/]
        }
    }
});
