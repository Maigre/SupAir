Ext.define('MainApp.view.Viewport', {
    extend: 'Ext.container.Viewport',
    id: 'viewport',
    layout: 'border',
 	
    initComponent: function() {
        //Ext.QuickTips.init();
        this.items = [{
			region	: 'north',
			/*html	: '<h1 class="x-panel-header">**SUP*AIR**</h1>',*/
			height	: 30,
			bodyStyle: "background-image:url(interface/images/NASA1.jpg); background-repeat:no-repeat; background-position:center center;-moz-background-size: cover; -webkit-background-size: cover;-o-background-size: cover;background-size: cover;",
			autoHeight: true,
			border	: false,
			margins	: '0 0 5 0',
			layout  : {
				type	: 'hbox',
				align	: 'center',
				pack	: 'end'
			},
			items:{
				xtype		: 'combo',
				id		: 'comboexercice',
				fieldLabel	: 'Exercice',
				hideLabel	: true,
				store		: exercicestore,
				displayField	: 'nom',
				valueField	: 'id',
				padding		: 4,
				margins		: '0 10 0 0',
				emptyText	: 'Exercice '+EXERCICE,
				//height		: 30,
				//labelWidth	: 100,
				width		: 150,
				listeners: {
					select: {
					    //element: 'el', //bind to the underlying body property on the panel
					    fn: function(){ 
						EXERCICE_ID=Ext.getCmp('comboexercice').valueModels[0].data.id;
					    	EXERCICE= Ext.getCmp('comboexercice').getRawValue();
					    }
					}
				}
			}
		}, {
			region	: 'west',
			id	: 'westregion',
			//collapsible: true,
			//title	: 'Navigation',
			width	: 150,
			layout	: 'fit',
			items	:[{
				xtype: 'menupanel'
			}]
			// could use a TreePanel or AccordionLayout for navigational items
		}, {
			region	: 'south',
			title	: 'South Panel',
			collapsible: true,
			collapsed : true,
			html	: '',
			split	: true,
			height	: 50,
			minHeight: 50
		}, {
			region	: 'east',
			title	: 'East Panel',
			collapsible: true,
			collapsed : true,
			split	: true,
			width	: 150
		}, {
			region	: 'center',
			id	: 'centerregion',
			//xtype	: 'container',
			layout	: 'fit',
			bodyStyle: "background-image:url(interface/images/NASA1.jpg); background-repeat:no-repeat; background-position:center center;-moz-background-size: cover; -webkit-background-size: cover;-o-background-size: cover;background-size: cover;"/*,
			//opacity : 0,
			items	: [{
				xtype: 'adherentmain',
				bodyStyle: "background-image:url(interface/images/NASA1.jpg); background-repeat:no-repeat; background-position:center center;-moz-background-size: cover; -webkit-background-size: cover;-o-background-size: cover;background-size: cover;",
			}]*/
    	}];

        this.callParent();
    }
});
