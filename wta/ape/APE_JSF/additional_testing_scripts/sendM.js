function sendM2(ape, debug){
	// we call this function once APE has finished loading
	this.initialize = function(){
		// once a new user joins (pipe created), call setup()
		ape.addEvent('multiPipeCreate', this.setup2);

		// when a user joins, update the user list
		ape.addEvent('userJoin', this.createUser2);

		// when a user leaves, destroy them with mighty thunder!
		ape.addEvent('userLeft', this.deleteUser2);

		// when we want to send data
		ape.onCmd('send', this.cmdSend2);

		// and when we recieve data
		ape.onRaw('data', this.rawData2);


		ape.start({'name': String((new Date()).getTime()).replace(/D/gi,'')});
	}
	this.setup2 = function(pipe, options){

		 $('#test2').live('submit', function(e){
		   e.preventDefault();
//		   var message = $('#inserted_message2').val(); 
		   
		   var message = $('#inserted_message2').val();
				
				
		   pipe.send(message);
		  }); 
	}

	this.cmdSend2 = function(pipe, sessid, pubid, message){
	
	   }

	this.rawData2 = function(raw, pipe){

		if(debug)
		
		   $('.messages2').prepend(decodeURIComponent(raw.data.msg) +'<br/>'); 
		

	}
	this.createUser2 = function(user, pipe){
	}

	this.deleteUser2 = function(user, pipe){
	}





}









function sendM(ape, debug){
	// we call this function once APE has finished loading
	this.initialize = function(){
		// once a new user joins (pipe created), call setup()
		ape.addEvent('multiPipeCreate', this.setup);

		// when a user joins, update the user list
		ape.addEvent('userJoin', this.createUser);

		// when a user leaves, destroy them with mighty thunder!
		ape.addEvent('userLeft', this.deleteUser);

		// when we want to send data
		ape.onCmd('send', this.cmdSend);

		// and when we recieve data
		ape.onRaw('data', this.rawData);

		// start the session with a random name!
		// note: you'll need the chat plugin loaded
		ape.start({'name': String((new Date()).getTime()).replace(/D/gi,'')});
	}

	this.setup = function(pipe, options){
		// add an event listener on our selectbox
		 $('#test').live('submit', function(e){
		   e.preventDefault();
		   var message = $('#inserted_message').val(); 
		   pipe.send(message);
		  }); 
	}

	this.cmdSend = function(pipe, sessid, pubid, message){
		/*if(debug)
			$("<span>    " + ape.user.properties.name + " changed the bg color to " + message + "</span><br />").prependTo("#debug");*/
	   }

	this.rawData = function(raw, pipe){
		// data has been received by the APE server so do the following...
		if(debug)
		$('.messages').prepend(decodeURIComponent(raw.data.msg) +'<br/>'); 
	

	}
	this.createUser = function(user, pipe){
		// a user has joined so prepend them to the debug window
/*		user.element = $("<span>" + user.properties.name + " has joined bgColor</span><br />").prepend("<img src='bullet_green.png' />").prependTo("#debug");
*/	}

	this.deleteUser = function(user, pipe){
		// a user has left so update the debug window
/*		$(user.element).text(user.properties.name + " has left bgColor").css("color", "#666666").prepend("<img src='bullet_red.png' />");
*/	}
}