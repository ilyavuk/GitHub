<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" dir="ltr" lang="en">
    <head>  
        <!-- Load APE Client -->
        <script type="text/javaScript" src="Build/uncompressed/apeClientJS.js"></script>
    </head>
 
    <body>
        <script type="text/javaScript">
            //Instantiate APE Client
            var client = new APE.Client();
 
            //Load APE Core
            client.load();
 
            //Intercept 'load' event. This event is fired when the Core is loaded and ready to connect to APE Server
            client.addEvent('load', function() {
                //Call the core start function to connect to APE Server
                client.core.start({"name":prompt('Your name?')});
            });
 
            //4) Listen for the ready event to know when your client is connected
            client.addEvent('ready', function() {
                console.log('Your client is now connected');
                //1) join 'testChannel'
                client.core.join('testChannel');
 
                //2) Intercept multiPipeCreate event
                client.addEvent('multiPipeCreate', function(pipe, options) {
                //3) Send the message on the pipe
                pipe.send('Hello world!');
                    console.log('Sending Hello world');
                });
 
                //4) Intercept receipt of the new message.
                client.onRaw('data', function(raw, pipe) {
                    console.log('Receiving : ' + unescape(raw.data.msg));
                });
            });
        </script>
    </body>
</html>