<div class="container">
		<div class="sixteen columns venue">
			<div class="sixteen columns alpha omega">
				<div class="sixteen columns alpha omega content">
<script>
function release_ape(){ 		
        
		var client = new APE.Client();
		
		client.load();
		
		client.addEvent('load', function() {
			client.core.start({'name': String((new Date()).getTime()).replace(/D/gi,'')});
		});
		
         client.addEvent('ready', function() {

				client.core.join('wall2all185');
 

                client.addEvent('multiPipeCreate', function(pipe, options) {
					
				 
										  
									
									var spec_data =  '&events_id=' + 185;
									spec_data +=  '&user_id=' + 115;	
									var i = 0;									  
							setInterval(function(){	
							               i++;
										   <?php if($another):?>
										   spec_data +=  '&comment=another_' + i; 
										   <?php else:?>
							               spec_data +=  '&comment=' + i; 
										   <?php endif;?> 
										   $.ajax({
											type: "POST",
											async: false,
											dataType: "json",
											url: '<?=base_url('ajax/insert_comments')?>',
											data: spec_data,
											success: function(obj){
												
												if(obj){
													
													var scope_comments_id_ape = obj['inserted_id'];
                                                    var last_div_id = parseInt($("#push_comments li:first").attr("data-id"));
                                                    var last_div_id_incrementedByOne = last_div_id + 1;	
	                                                
													var comment_send = JSON.stringify({"userImg": "<img src=\"http://a0.twimg.com/profile_images/2406773307/tt4q4nur1k4unlkz9uyn_normal.jpeg \" />" , "comment": i , "userName": "Test Name" , "admin": "", "comments_id": scope_comments_id_ape });	
													pipe.send(comment_send);
																								
													/*if(last_div_id_incrementedByOne === scope_comments_id_ape){	
																							
														var comment_add = '<li class="ten columns alpha omega post'+admin+' delete" data-id="'+scope_comments_id_ape+'" ><div class="bouble"><h3>'+userName+'</h3>'+comment;
														comment_add += '<span class="meta">'+currentTime()+ '| <a href="" class="user_like" rel="'+scope_comments_id_ape+'"> Like </a> | <a href="" class="user_report" rel="'+scope_comments_id_ape+'"> Report </a>';
														comment_add +='<a href="" class="user_comm_delete" rel="'+scope_comments_id_ape+'"> | Delete</a>'
														comment_add += soc_post +'</span></div>'
														comment_add += userImg +'</li>';
														$('#push_comments').prepend(comment_add);
														
												    }else{*/
													
													   /* ajax_comments(last_div_id, true);*/
											   
												    /*}*/											
													
												}else{
												   return false;
												}
										   }
								      });									
		
							},100);
				
				
				
				
				
				
				});
				
				
				/**
				     The data received from the server and handled throughout functions				
				*/
				
                client.onRaw('data', function(raw, pipe) {
                	

				
				
				});
				
				
				
        });


}
 $(document).ready(function() {
   release_ape();
});
 
  
</script>






            </div>
        </div>
    </div>
</div>