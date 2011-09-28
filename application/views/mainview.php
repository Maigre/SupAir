<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Viewport test</title>

		<!-- Tools -->		
		<script type="text/javascript" src="interface/tools/print.js"></script>
		
		<!-- ExtJS 4 -->
        <link rel="stylesheet" type="text/css" href="interface/ext4/resources/css/ext-all.css" />
        <script type="text/javascript" src="interface/ext4/ext-all.js"></script>
        <script type="text/javascript" src="interface/ext4/locale/ext-lang-fr.js"></script>
        <script type="text/javascript">Ext.BLANK_IMAGE_URL = 'interface/ext4/resources/s.gif';</script>
        
     	<!-- APPLICATION -->
     	<script type="text/javascript">BASE_URL = '<?=base_url()?>index.php/';</script>
     	<link rel="stylesheet" type="text/css" href="interface/css/viewport.css" />
     	<link rel="stylesheet" type="text/css" href="interface/css/icons.css" />
     	<script type="text/javascript" src="interface/apps/viewport.js"></script>
     	<script type="text/javascript" src="interface/apps/login.js"></script>
     	
     	<script type="text/javascript">
     	Ext.ns('MainApp');
     	     	
     	Ext.onReady(function(){
			
			//load viewport
			MainApp.ViewPort.init();
			
			//check if already logged in and display welcome message or login window
			MainApp.Login.ask();
					  
				
		});
		</script>

    </head>
    <body>
    	<div id="working-area"></div>
    </body>
</html>
