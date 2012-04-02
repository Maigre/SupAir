<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

        <title>SupAIR Gestion - MJC, Centres Sociaux, Clubs et Associations</title>


		<!-- Tools -->		
	<script type="text/javascript" src="interface/tools/print.js"></script>
		
		<!-- ExtJS Styles -->
        <link rel="stylesheet" type="text/css" href="interface/ext4/resources/css/ext-all.css" />
        <link rel="stylesheet" type="text/css" href="interface/ext4/plugins/calendar/resources/css/extensible-all.css" /> 
        
        	<!--additional styles -->
        <?php 
	     	foreach ($styles as $style_view){
	     		echo $style_view;
	     	}
	?>
        
        	<!-- ExtJS Framework -->
        <script type="text/javascript" src="interface/ext4/ext-all.js"></script>
        <script type="text/javascript" src="interface/ext4/datepickerOverride.js"></script>
        <script type="text/javascript" src="interface/ext4/locale/ext-lang-fr.js"></script>
        <script type="text/javascript">Ext.BLANK_IMAGE_URL = 'interface/ext4/resources/s.gif';</script>
     	<script type="text/javascript">BASE_URL = '<?=base_url()?>index.php/';</script>
     	<script type="text/javascript" src="application/views/view/Viewport.js"></script>
     	<link rel="stylesheet" type="text/css" href="interface/css/viewport.css" />
     	<link rel="stylesheet" type="text/css" href="interface/css/icons.css" />
     		
     		<!-- Calendar plugin -->	
     	<script type="text/javascript" src="interface/ext4/plugins/calendar/extensible-all-debug.js"></script>
     	<script type="text/javascript" src="interface/ext4/plugins/calendar/examples/examples.js"></script>
		
		
	
		<!-- Global variables -->
     	<script type="text/javascript">ID_FAMILLE = 1;</script>
     	<script type="text/javascript">SECTEUR = 1;</script>
     	<script type="text/javascript">EXERCICE = '2011-2012';</script>
     	<script type="text/javascript">EXERCICE_ID = 1;</script>
     	
     	<script type="text/javascript">
     		
	     	//Charge les classes de extjs
	     	Ext.Loader.setConfig({
			    enabled: true,
			    paths: {
				'Extensible': 'interface/ext4/plugins/calendar/src',
				'Extensible.example': 'interface/ext4/plugins/calendar/examples'
			    }
		});
	
	
	
	
	     	<?php 
	     	foreach ($extjs as $ex_view){
	     		echo $ex_view;
	     	}
	     	?>
	     	
	     	Ext.ns('MainApp');     	
	     	    	
	     
	     	     	
	     	Ext.onReady(function(){
			
			//load viewport
			Main.Launch.init();
			
			setTimeout(function(){
				Ext.get('loading').remove();
				Ext.get('loading-mask').fadeOut({remove:true});
			}, 1000);
			//check if already logged in and display welcome message or login window
			//MainApp.Login.ask();				  			
		});
	</script>

    </head>
    <body>
    	<div id="loading-mask"></div>
	<div id="loading">
		<div class="loading-indicator">
			
		</div>
	</div>

    	<?php
    		
    	?>
    	<div id="working-area"></div>
    </body>
</html>
