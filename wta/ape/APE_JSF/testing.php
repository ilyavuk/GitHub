<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" dir="ltr" lang="en">
    <head>  
        <!-- Load APE Client -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
        <script type="text/javaScript" src="Build/uncompressed/apeClientJS.js"></script>
    </head>
    <body>
    <script>
	    var ran_name =  Math.ceil(Math.random()*200); 
		var test = 'something'+ ran_name;
		var messa = 'Message numer '+ ran_name;
		
//		alert (ran_name);
		var client = new APE.Client();
		client.load();
		 
		// Intercept 'load' event. This event is fired when the Core is loaded and ready to connect to APE Server
		client.addEvent('load', function() {
			// Call core start function to connect to APE Server
			client.core.start({"name":test});
		});
		 
		//Listen to the ready event to know when your client is connected
		client.addEvent('ready', function() {
			console.log('Your client is now connected');
		});	
		/*client.onRaw('login', function(data) {
			//output data received from APE Server
			console.log(data);
		});*/
		client.onCmd('connect', function(data) {
			//the data sent to APE Server
			console.log(data);
		});
		
	</script>
    </body>
</html>