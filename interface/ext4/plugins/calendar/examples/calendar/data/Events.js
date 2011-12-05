/*!
 * Extensible 1.5.0
 * Copyright(c) 2010-2011 Extensible, LLC
 * licensing@ext.ensible.com
 * http://ext.ensible.com
 */
Ext.define('Extensible.example.calendar.data.Events', {
    constructor: function() {
        var today = Ext.Date.clearTime(new Date),
            makeDate = function(d, h, m, s){
                d = d * 86400;
                h = (h || 0) * 3600;
                m = (m || 0) * 60;
                s = (s || 0);
                return Ext.Date.add(today, Ext.Date.SECOND, d + h + m + s);
            };
            
        return {
            "evts":[{
                "id":1001,
                "cid": 'C1',
                "title":"Toussaint",
                "start":'2011-10-22 00:00:00',
                "end":'2011-11-03 00:00:00',
                "ad":true
            },{
                "id":1002,
                "cid": 'C1',
                "title":"Noel",
                "start":'2011-12-17 00:00:00',
                "end":'2012-01-03 00:00:00',
                "ad":true
            },{
                "id":1003,
                "cid": 'C1',
                "title":"F&eacute;vrier",
                "start":'2012-02-11 00:00:00',
                "end":'2012-02-27 00:00:00',
                "ad":true
            },{
                "id":1004,
                "cid": 'C1',
                "title":"Paques",
                "start":'2012-04-07 00:00:00',
                "end":'2012-04-23 00:00:00',
                "ad":true
            },{
                "id":1005,
                "cid": 'C1',
                "title":"Et&eacute;",
                "start":'2012-07-05 00:00:00',
                "end":'2012-09-04 00:00:00',
                "ad":true
            }/*,{
                "id":1003,
                "cid":3,
                "title":"Project due",
                "start":makeDate(0, 15),
                "end":makeDate(0, 15)
            },{
                "id":1004,
                "cid":1,
                "title":"Sarah's birthday",
                "start":today,
                "end":today,
                "notes":"Need to get a gift",
                "ad":true
            },{
                "id":1005,
                "cid":2,
                "title":"A long one...",
                "start":makeDate(-12),
                "end":makeDate(10, 0, 0, -1),
                "ad":true
            },{
                "id":1006,
                "cid":3,
                "title":"School holiday",
                "start":makeDate(5),
                "end":makeDate(7, 0, 0, -1),
                "ad":true,
                "rem":"2880"
            },{
                "id":1007,
                "cid":1,
                "title":"Haircut",
                "start":makeDate(0, 9),
                "end":makeDate(0, 9, 30),
                "notes":"Get cash on the way"
            },{
                "id":1008,
                "cid":3,
                "title":"An old event",
                "start":makeDate(-30),
                "end":makeDate(-28),
                "ad":true
            },{
                "id":1009,
                "cid":2,
                "title":"Board meeting",
                "start":makeDate(-2, 13),
                "end":makeDate(-2, 18),
                "loc":"ABC Inc.",
                "rem":"60"
            },{
                "id":1010,
                "cid":3,
                "title":"Jenny's final exams",
                "start":makeDate(-2),
                "end":makeDate(3, 0, 0, -1),
                "ad":true
            },{
                "id":1011,
                "cid":1,
                "title":"Movie night",
                "start":makeDate(2, 19),
                "end":makeDate(2, 23),
                "notes":"Don't forget the tickets!",
                "rem":"60"
            },{
                "id":1012,
                "cid":4,
                "title":"Gina's basketball tournament",
                "start":makeDate(8, 8),
                "end":makeDate(10, 17)
            },{
                "id":1013,
                "cid":4,
                "title":"Toby's soccer game",
                "start":makeDate(5, 10),
                "end":makeDate(5, 12)
            }*/]
        }
    }
});
