<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

        <title>SupAIR Gestion - MJC, Centres Sociaux, Clubs et Associations</title>


		<!-- Tools -->		
		<script type="text/javascript" src="interface/tools/print.js"></script>
		
		<!-- ExtJS 4 -->
        <link rel="stylesheet" type="text/css" href="interface/ext4/resources/css/ext-all.css" />
        <link rel="stylesheet" type="text/css" href="interface/ext4/plugins/calendar/resources/css/extensible-all.css" />
        
        <script type="text/javascript" src="interface/ext4/ext-all.js"></script>
        <script type="text/javascript" src="interface/ext4/locale/ext-lang-fr.js"></script>
        <script type="text/javascript">Ext.BLANK_IMAGE_URL = 'interface/ext4/resources/s.gif';</script>
     	<script type="text/javascript">BASE_URL = '<?=base_url()?>index.php/';</script>
     	<script type="text/javascript" src="application/views/view/Viewport.js"></script>
     	<link rel="stylesheet" type="text/css" href="interface/css/viewport.css" />
     	<link rel="stylesheet" type="text/css" href="interface/css/icons.css" />
     		
     		<!-- Calendar plugin -->
     	
     	<script type="text/javascript" src="interface/ext4/plugins/calendar/src/Extensible.js"></script>
     	<script type="text/javascript" src="interface/ext4/plugins/calendar/examples/examples.js"></script>	
	
	
     	
     	<script type="text/javascript">
     	
     	
	
     	//Charge les classes de extjs
     	Ext.Loader.setConfig({
		    enabled: true,
		    paths: {
		        'Extensible': 'interface/ext4/plugins/calendar/src',
		        'Extensible.example': 'interface/ext4/plugins/calendar/examples/'
		    }
	});
	
	
	
     	<?php 
     	foreach ($views as $view){
     		echo $view;
     	}
     	?>
     	
     	Ext.ns('MainApp');     	
     	    	
     	
     	     	
     	Ext.onReady(function(){
			
		//load viewport
		Main.Launch.init();

		//check if already logged in and display welcome message or login window
		//MainApp.Login.ask();				  			
	});
	</script>

    </head>
    <body>
    	<div id="working-area"></div>
    </body>
</html>
