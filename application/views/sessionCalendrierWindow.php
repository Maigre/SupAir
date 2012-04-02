Ext.define('MainApp.view.SessionCalendrierWindow', {
	extend	: 'Ext.window.Window',
	alias 	: 'widget.sessioncalendrierwindow',
	id	: 'sessioncalendrierwindow',
	title	: 'Calendrier de la session',
	iconCls	: 'calendrier',
	modal	: true,
	height	: 403,
	width	: 1092,
	layout	: {
		type: 'vbox',
		align: 'stretch'
	},
	tbar: [{
                text	: 'S&eacute;lection',
                iconCls	: 'select',
                menu	: [{
                	text: 'Lundi',
                	iconCls: 'select',
                	handler: function() {
                		
                		Ext.getCmp('sessioncalendrierwindow').selectDaysofweek(1);
                	}
                },{
                	text: 'Mardi',
                	iconCls: 'select',
                	handler: function() {
                		Ext.getCmp('sessioncalendrierwindow').selectDaysofweek(2);
                	}
                },{
                	text: 'Mercredi',
                	iconCls: 'select',
                	handler: function() {
                		Ext.getCmp('sessioncalendrierwindow').selectDaysofweek(3);
                	}
                },{
                	text: 'Jeudi',
                	iconCls: 'select',
                	handler: function() {
                		Ext.getCmp('sessioncalendrierwindow').selectDaysofweek(4);
                	}
                },{
                	text: 'Vendredi',
                	iconCls: 'select',
                	handler: function() {
                		Ext.getCmp('sessioncalendrierwindow').selectDaysofweek(5);
                	}
                },{
                	text: 'Samedi',
                	iconCls: 'select',
                	handler: function() {
                		Ext.getCmp('sessioncalendrierwindow').selectDaysofweek(6);
                	}
                },{
                	text: 'Dimanche',
                	iconCls: 'select',
                	handler: function() {
                		Ext.getCmp('sessioncalendrierwindow').selectDaysofweek(0);
                	}
                },]
        },{
                text	: 'D&eacute;s&eacute;lection',
                iconCls	: 'select',
                menu	: [{
                	text: 'Lundi',
                	iconCls: 'select',
                	handler: function() {
                		
                		Ext.getCmp('sessioncalendrierwindow').unselectDaysofweek(1);
                	}
                },{
                	text: 'Mardi',
                	iconCls: 'select',
                	handler: function() {
                		Ext.getCmp('sessioncalendrierwindow').unselectDaysofweek(2);
                	}
                },{
                	text: 'Mercredi',
                	iconCls: 'select',
                	handler: function() {
                		Ext.getCmp('sessioncalendrierwindow').unselectDaysofweek(3);
                	}
                },{
                	text: 'Jeudi',
                	iconCls: 'select',
                	handler: function() {
                		Ext.getCmp('sessioncalendrierwindow').unselectDaysofweek(4);
                	}
                },{
                	text: 'Vendredi',
                	iconCls: 'select',
                	handler: function() {
                		Ext.getCmp('sessioncalendrierwindow').unselectDaysofweek(5);
                	}
                },{
                	text: 'Samedi',
                	iconCls: 'select',
                	handler: function() {
                		Ext.getCmp('sessioncalendrierwindow').unselectDaysofweek(6);
                	}
                },{
                	text: 'Dimanche',
                	iconCls: 'select',
                	handler: function() {
                		Ext.getCmp('sessioncalendrierwindow').unselectDaysofweek(0);
                	}
                },]
        }],
	items	: [{
			flex	: 1,
			xtype	: 'container',
			id	: 'calendarwindowfirstrow',
			layout	: {
				type: 'hbox',
				align: 'center'
			}
		},
		{
			flex	: 1,
			xtype	: 'container',
			id	: 'calendarwindowsecondrow',
			layout	: {
				type: 'hbox',
				align: 'center'
			}
		}
	],
	initComponent: function() {
		var me=this;
		SELECTED_DATES=[];
		me.first_year=EXERCICE.split('-')[0];
		
		
		
		this.on('afterrender', function(){
			
			Ext.getCmp('sessioncalendrierwindow').getEl().mask('Loading...');
			
			
			var disabledDates = ['12/26/2011', '12/27/2011', '12/28/2011', '12/29/2011', '12/30/2011', '12/31/2011'];
			
			//Request the exercice infos to add minDate and maxDate to the datepickers
			Ext.Ajax.request({
				url: BASE_URL+'exercice/exercice/show/'+EXERCICE_ID,
				method : 'POST',
				success: function(response){
					//console.info(response.responseText);
					var response = Ext.JSON.decode(response.responseText);
					
					me.debut_calendrier=new Date(response.data.debut);
					me.fin_calendrier=new Date(response.data.fin);
					
					//Create the titles component(année et mois) 
					first_year = EXERCICE.split('-')[0];
					first_month = response.data.debut.split('-')[1];
					second_year = EXERCICE.split('-')[1];
					
					//Get the selected dates if one day of week is selected
					//me.selectDaysofweek(1);
					
					
					array_month = ['Janvier', 'F&eacute;vrier', 'Mars', 'Avril', 'Mai', 'Juin',
						'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'D&eacute;cembre'									
					];
								
					for (i=0;i<=11;i++){
						
						var month=i+parseInt(first_month,10);
						
						
						if(month<13){
							var year=first_year;
							
						}
						else{	
							month= parseInt(month,10)-12;
							var year = second_year;
							
						} 						
						//TITRE
						var panel_title=array_month[month-1]+' '+year;
						
						//CONTAINER
						if(i<6){
							var container=Ext.getCmp('calendarwindowfirstrow');
						}
						else{
							var container=Ext.getCmp('calendarwindowsecondrow');
						}
						
						//MIN & MAX DATE
						if(i==0){
							minDate=me.debut_calendrier;
														
						}
						else{
							if (month<10) month='0'+month;
							minDate=year+'-'+month+'-01';
							
						}
						if (month<12){
							nextmonth=parseInt(month,10)+1;
														
							if (nextmonth<10) nextmonth='0'+nextmonth;
							nextyear=year;
						}
						else{
							nextmonth='01';
							nextyear=parseInt(year)+1;
						}
						maxDate=nextyear+'-'+nextmonth+'-01';
						
						minDate = new Date(minDate);						
						maxDate = Ext.Date.add(new Date(maxDate), Ext.Date.DAY, -1); //la veille du premier jour du mois suivant
						
						if(i==11){
							maxDate=me.fin_calendrier;
						}
						
						container.add({
							xtype: 'panel',
							title: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+panel_title,
							items:[{
								flex: 1,
								xtype	: 'datepicker',
								id	: 'sessiondatepicker'+i,
								value	: new Date(year+","+month+",01"),
								minDate	: minDate,
								maxDate	: maxDate,
								showToday: false,
								disabledDates: ["15/03/12"], //['03/08', '09/16'],//disabledDates,
								disabledDays : [0],
								//disableAnim: true,
								handler	: function(picker, date) {
								    // do something with the selected date
								}
							}]	
						});
					}
			
			
					array_tohide= ['.x-datepicker-prev','.x-datepicker-next','.x-datepicker-footer','.x-datepicker-month','.x-datepicker-header'];
					Ext.each(array_tohide, function(name) {
						tohide=Ext.select(name);
						tohide.setStyle('display', 'none');
					});
					
					Ext.getCmp('sessioncalendrierwindow').getEl().unmask();
				}
			});
			

			
		})
		
		//this.store= Ext.getStore('activitestore');
		me.callParent(arguments);
		
	},
	selectDaysofweek: function(daytoselect) {//day of week 0 for Sunday, 1 for Monday, etc...
		var me = this;
		//Partant du 1er jour de l'exercice on cherche le premier lundi(si lundi sélectionné)
		tempdate = me.debut_calendrier;
		console.info('selectDaysofweek');
		dayofweek=tempdate.getDay();
		while (dayofweek!=daytoselect)
		{
			tempdate=Ext.Date.add(tempdate, Ext.Date.DAY, 1);
			dayofweek=tempdate.getDay();
		}
		tempdate.setHours(0,0,0);
		console.info(tempdate);
		
		first_day=Number(tempdate);
		var millisecondsinweek=3600*24*7*1000;
		
		for (j=0;j<52;j++){
			
			nextday=parseInt(first_day)+j*millisecondsinweek;
			testDate = new Date();
			testDate.setTime(nextday);
			if (testDate.getHours()==23){//Heure d'hiver rajouter une heure
				nextday=nextday+3600*1000;
			}
			SELECTED_DATES.push(nextday);
		}
		
		console.info(SELECTED_DATES);
		for(k=0;k<12;k++){
			Ext.getCmp('sessiondatepicker'+k).selectedUpdate();
		}
		
		
		//Remove doublons from the list
		/*var sorted_arr = arr.sort(); 
		
		var results = [];
		for (var i = 0; i < arr.length - 1; i++) {
			if (sorted_arr[i + 1] == sorted_arr[i]) {
				results.push(sorted_arr[i]);
			}
		}*/

	}
});
