Ext.ns('Main');



Main.Launch = {
	
	init : function() {
		
				
		
		Ext.create ('Ext.app.Application',{
			name: 'MainApp',    
			controllers: [],
			appFolder: 'application/views', 
			//autoCreateViewport: true,
			launch: function() {

				
				Ext.QuickTips.init();
				//lancer login.js ici
			}
		});
	}
};

	


