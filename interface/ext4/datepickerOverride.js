Ext.override(Ext.picker.Date, {
	/*renderTpl: [
		'<div class="{cls}" id="{id}" role="grid" title="{ariaTitle} {value:this.longDay}">',
		    '<div role="presentation" class="{baseCls}-header">',
		        '<div class="{baseCls}-prev"><a id="{id}-prevEl" href="#" role="button" title="{prevText}"></a></div>',
		        '<div class="{baseCls}-month"></div>',
		        '<div class="{baseCls}-next"><a id="{id}-nextEl" href="#" role="button" title="{nextText}"></a></div>',
		    '</div>',
		    '<table id="{id}-eventEl" class="{baseCls}-inner" cellspacing="0" role="presentation">',
		        '<thead role="presentation"><tr role="presentation">',
		            '<tpl for="dayNames">',
		                '<th role="columnheader" title="{.}"><span>{.:this.firstInitial}</span></th>',
		            '</tpl>',
		        '</tr></thead>',
		        '<tbody role="presentation"><tr role="presentation">',
		            '<tpl for="days">',
		                '{#:this.isEndOfWeek}',
		                '<td role="gridcell" id="{[Ext.id()]}">',
		                    '<a role="presentation" href="#" hidefocus="on" class="{parent.baseCls}-date" tabIndex="1">',
		                        '<em role="presentation"><span role="presentation"></span></em>',
		                    '</a>',
		                '</td>',
		            '</tpl>',
		        '</tr></tbody>',
		    '</table>',
		    '<tpl if="showToday">',
		        '<div id="{id}-footerEl" role="presentation" class="{baseCls}-footer"></div>',
		    '</tpl>',
		'</div>',
		{
		    firstInitial: function(value) {
		        return value.substr(0,1);
		    },
		    isEndOfWeek: function(value) {
		        // convert from 1 based index to 0 based
		        // by decrementing value once.
		        value--;
		        var end = value % 7 === 0 && value !== 0;
		        return end ? '</tr><tr role="row">' : '';
		    },
		    longDay: function(value){
		        return Ext.Date.format(value, this.longDayFormat);
		    }
		}
    	],*/
    	handleDateClick : function(e, t){
		console.info('ok');
		var me = this,
			handler = me.handler;

		e.stopEvent();
		if(!me.disabled && t.dateValue && !Ext.fly(t.parentNode).hasCls(me.disabledCellCls)){
			//console.info(me.selectedDates);
			//console.info(me);
			//me.cancelFocus = me.focusOnSelect === false;
			var el = Ext.get(t);
			//console.info(el.up('td'));
			
			//Vérifie que la date n'existe pas déjà dans la liste des SELECTED_DATES
			array_indice= SELECTED_DATES.indexOf(t.dateValue);
			if(array_indice == -1){  
				SELECTED_DATES.push(t.dateValue);
			}
			//Si elle existe déjà, c'est que la case a été cliquée pour enlever cette date
			//Elle est enlevée avec la méthode slice qui laisse la case vide donc on décale ensuite toutes les dates suivantes d'un cran dans le tableau
			else{
				delete SELECTED_DATES[array_indice];
				SELECTED_DATES.slice(1,1);
				temp_array=[];
				for (i=0;i<=SELECTED_DATES.length;i++){
					
					if (SELECTED_DATES[i]!== undefined){
						temp_array.push(SELECTED_DATES[i]);
						var myDate = new Date();
						myDate.setTime(SELECTED_DATES[i]);
						console.info(myDate);
					}					
				}
				SELECTED_DATES=temp_array;
				console.info(SELECTED_DATES);
			}
			
			me.setValue(new Date(t.dateValue));
			delete me.cancelFocus;
			me.fireEvent('select', me, me.value);
			if (handler) {
			handler.call(me.scope || me, me, me.value);
			}
			// event handling is turned off on hide
			// when we are using the picker in a field
			// therefore onSelect comes AFTER the select
			// event.
			me.onSelect();
		}
	},
	selectedDates : [],
	selectedUpdate: function(){
		var me = this,
		    //t = date.getTime(),
		    cells = me.cells,
		    cls = me.selectedCls;

		cells.removeCls(cls);
		cells.each(function(c){
			
			if(SELECTED_DATES.indexOf(c.dom.firstChild.dateValue) != -1){  
				
				me.el.dom.setAttribute('aria-activedescendent', c.dom.id);
				c.addCls(cls);
				if(me.isVisible() && !me.cancelFocus){
				    //Ext.fly(c.dom.firstChild).focus(50);
				}
			}

			
		}, this);
    	},
    	handleMouseWheel : function(e){

    	},
	
});

