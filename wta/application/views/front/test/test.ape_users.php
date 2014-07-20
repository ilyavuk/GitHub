

<div class="container">
		<div class="sixteen columns venue">
			<div class="sixteen columns alpha omega">
				<div class="sixteen columns alpha omega content">
<script>
<?php
  $init_user = isset($_GET['user'])?$_GET['user']:0;
?>
var userx = <?=$init_user?> + 1;
function release_ape(){ 		
        
		var client = new APE.Client();
		
		client.load();
		
		client.addEvent('load', function() {
			client.core.start({'name': String((new Date()).getTime()).replace(/D/gi,'')});
		});
		
         client.addEvent('ready', function() {

				client.core.join('wall2all185');
 

                client.addEvent('multiPipeCreate', function(pipe, options) {
					
				 
										  
									
/*									var spec_data =  '&events_id=' + 185;
									spec_data +=  '&user_id=' + 115;	

							               spec_data +=  '&comment=' + userx;  
										   $.ajax({
											type: "POST",
											dataType: "json",
											url: '<?=base_url('ajax/insert_comments')?>',
											data: spec_data,
											success: function(obj){
												
												if(obj){
													
													var scope_comments_id_ape = obj['inserted_id'];
                                                    var last_div_id = parseInt($("#push_comments li:first").attr("data-id"));
                                                    var last_div_id_incrementedByOne = last_div_id + 1;	
	                                                
													var comment_send = JSON.stringify({"userImg": "<img src=\"a0.twimg.com/profile_images/2406773307/tt4q4nur1k4unlkz9uyn_normal.jpeg \" />" , "comment": userx , "userName": " " , "admin": "", "comments_id": scope_comments_id_ape });	
													pipe.send(comment_send);
													
													window.location = "<?= $_SERVER['PHP_SELF']?>?user="+userx;
																								
												}else{
												   return false;
												}
										   }
								      });									
*/		
							
				
				
				
				
				
				
				});
				
				
				/**
				     The data received from the server and handled throughout functions				
				*/
				
                client.onRaw('data', function(raw, pipe) {
                	

				
				
				});
				
				
				
        });
       

}
setInterval(function(){
   release_ape();
   console.log(String((new Date()).getTime()).replace(/D/gi,''));
   					
},2000);
 
  
</script>






            </div>
        </div>
    </div>
</div>