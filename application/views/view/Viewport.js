Ext.define('MainApp.view.Viewport', {
    extend: 'Ext.container.Viewport',
	id: 'viewport',
    layout: 'border',
 	
    initComponent: function() {
        //Ext.QuickTips.init();
        this.items = [{
			region	: 'north',
			html	: '<h1 class="x-panel-header">**SUP*AIR**</h1>',
			height	: 30,
			bodyStyle: "background-image:url(interface/images/banner_sky.jpg); background-repeat:no-repeat; background-position:center center;-moz-background-size: cover; -webkit-background-size: cover;-o-background-size: cover;background-size: cover;",
			autoHeight: true,
			border	: false,
			margins	: '0 0 5 0'
		}, {
			region	: 'west',
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
			html	: '',
			split	: true,
			height	: 50,
			minHeight: 50
		}, {
			region	: 'east',
			title	: 'East Panel',
			collapsible: true,
			split	: true,
			width	: 150
		}, {
			region	: 'center',
			xtype	: 'container',
			layout	: 'fit',
			items	: [{
				xtype: 'adherentmain'
			}]
    	}];

        this.callParent();
    }
});
