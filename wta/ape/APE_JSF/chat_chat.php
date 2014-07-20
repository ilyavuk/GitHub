<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" dir="ltr" lang="en">
<style>

.messages{margin-bottom:30px;}
.messages2{margin-bottom:30px;}
.left{width:350px;float:left;}
.right{width:500px;float:left;}
.clear{clear:both;}
</style>
    <head>  
        <!-- Load APE Client -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
        <script type="text/javaScript" src="Build/uncompressed/apeClientJS.js"></script>
        <script type="text/javascript" language="javascript" src="additional_testing_scripts/sendM.js"></script>
    </head>
    <body>
    <script>
	var debug = true;
	  
	  
	 /* var client = new APE.Client;
	  
	            client.load({
                'domain': APE.Config.domain,
                'server': APE.Config.server,
                'identifier': 'jquery',
                'channel': 'test',
                'complete': function(ape){

        
            
                    new sendM(ape, debug).initialize();


                },
                'scripts': APE.Config.scripts
            });*/
	  
     var boom = new APE.Client;
 	            boom.load({
                'domain': APE.Config.domain,
                'server': APE.Config.server,
                'identifier': 'jquery',
                'channel': 'booooooooooooooooo',
                'complete': function(ape){
                  
				  
					  ape.addEvent('multiPipeCreate', function(pipe, options) {
							 $('#test2').live('submit', function(e){
								   e.preventDefault();
								   var message = $('#inserted_message2').val();
								   var json = '{"ape":"'+message+'"  ,  "ape2":"John"}';
							       pipe.send(json);
								  }); 	
						    $('#test').live('submit', function(e){
								   e.preventDefault();
								   /*var message = $('#inserted_message').val();*/
								   
								   var message = '<img alt="" ';
								   var output = message.replace(new RegExp('"','gm'),'~');
								   var json = '{"ape2222":"'+output+'"  ,  "ape2":"<img alt= "}';
							       pipe.send(json);
								  }); 				
					  });
					
					
					/*ape.addEvent('userJoin',function(user, pipe){});
					ape.addEvent('userLeft',function(user, pipe){});*/
				  	
					/*ape.onCmd('send',function(pipe, sessid, pubid, message){});*/
					
                    ape.onRaw('data', function(raw, pipe) {
							var outputM = jQuery.parseJSON(decodeURIComponent(raw.data.msg));
							/*var outputM2 =jQuery.parseJSON(outputM);*/
							var outputM2 =outputM.ape2222;
							var outputM3 =outputM2.replace(/~/g,'"');
							console.log(outputM3);
							if(outputM.ape2222 === undefined){
								alert('ape2222 isn\t set');
							}
				    });
                  ape.start({'name': String((new Date()).getTime()).replace(/D/gi,'')});
            
                    /*new sendM(ape, debug).initialize();*/
					/*new sendM2(ape, debug).initialize();*/

                },
                'scripts': APE.Config.scripts //Scripts to load for APE JSF
        });   
    
    
    
    </script>

    <div class="left">
    <p class="messages">
    </p>
    <form id="test">
    <input name="" type="text" id="inserted_message"/>
    <input name="" type="submit" />
    </form>
    </div>
    <div class="right">
    <p class="messages2">
    </p>
    <form id="test2">
    <input name="" type="text" id="inserted_message2"/>
    <input name="" type="submit" />
    </form>
    </div><div class="clear"></div>
    <script>
	$(function() {
		 $('#test').live('submit', function(e){
		   e.preventDefault();
		   $('.messages').prepend($('#inserted_message').val()+'<br/>'); 
		   $('#inserted_message').html('');
		   
		  });  
		 $('#test2').live('submit', function(e){
		   e.preventDefault();
		   $('.messages2').prepend($('#inserted_message2').val()+'<br/>'); 
		   $('#inserted_message2').html('');
		  }); 
	});
	</script>
    </body>
</html>