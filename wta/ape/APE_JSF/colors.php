<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>APE jQuery Test - Color Changer</title>
        <link rel="stylesheet" href="additional_testing_scripts/stylesheet.css" type="text/css" media="screen" charset="utf-8" /> 
        <script type="text/javaScript" src="Build/uncompressed/apeClientJS.js"></script>
     
		 <script type="text/javascript" language="javascript" src="additional_testing_scripts/jquery-core.js"></script>
        <script type="text/javascript" language="javascript" src="additional_testing_scripts/colorChanger.js"></script>
      
    </head>
	<body>
		<script type="text/javaScript">
            // create our new shiney APE client
            var client = new APE.Client;
        
            // set to false to disable debugging
            var debug = true;
        
            // load the APE client
            client.load({
                'domain': APE.Config.domain,
                'server': APE.Config.server,
                'identifier': 'jquery',
                'channel': 'test',
                'complete': function(ape){
                    // APE has finished loading so now we can load our scripts
        
                    // colorChanger(ape [obj], debug [bool]);
                    new colorChanger(ape, debug).initialize();
        
                    if(debug)
                        $("#debug").append("<span><strong>APE has finished loading</strong></span><br />");
                },
                'scripts': APE.Config.scripts //Scripts to load for APE JSF
            });
        </script>	
    
		<div id="wrapper"></div>
        Change Background Color:
        <select name="selectColor">
            <option value="white" selected="selected">White</option>
            <option value="yellow">Yellow</option>
            <option value="blue">Blue</option>
            <option value="green">Green</option>
            <option value="pink">Pink</option>
            <option value="purple">Purple</option>
            <option value="black">Black</option>
        </select>
        <p>Simple APE test of where users can change the background color of the page. We also use jQuery</p>
		<div id="debug">
			<h2>Debug</h2>
		</div>
	</body>
</html>