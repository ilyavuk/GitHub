function update_social_user_privileges(value, id){
	
			data =  '&value=' + value;
		    data +=  '&id=' + id;
			$.ajax({
			type: "POST",
			dataType: "json",
			url: wall2all_base_url+'ajax/update_social_user_privileges',
			data: data,
			success: function(obj){

               if(obj['result'] == 1){
				   
				 alert('You successfully updated!');
				  
			   }else{
				   
				   return false;
			   
			   }
			}
			});	

}
function manageBackground(outside_id, Etype){
	
  (function backgroundImg(){
	
		var uploader = new qq.FileUploader({
			element: $('#file-uploaderBImg')[0],
			template: '<div class="qq-uploader">' + 
								'<div class="qq-upload-drop-area"><span>Drop files here to upload</span></div>' +
								'<div class="qq-upload-button">Upload background image </div>' +
								'<ul class="qq-upload-list"></ul>' + 
								'</div>',
			action: wall2all_base_url+'ajax/upload_background_image',
			debug: false,
			allowedExtensions: ['jpg','png','gif'],
			onSubmit: function() {
				uploader.setParams({
					property_id: outside_id,
					descType : Etype
				});
			},
			onComplete: function(id, fileName, responseJSON){
				
				$('#insertBack').empty();
				
				var varHtml  = '<img src="'+wall2all_base_url+'phpThumb/phpThumb.php?src=/assets/background/'+ responseJSON.img + '&amp;w=280&amp;h=280&amp;zc=1&amp;aoe=1?x='+new Date().getTime()+ '" />';
					varHtml += '<a href="#" class="delBackground" >Delete X</a>';
				
				$('#insertBack').html(varHtml);
	
			}
		}); 
  
  })();

}
function deleteBackground(id,type){
	        data =  '&id=' + id;
			data +=  '&type=' + type;
			$.ajax({
			type: "POST",
			dataType: "json",
			url: wall2all_base_url+'ajax/delete_background',
			data: data ,
			success: function(obj){
              if(obj == 1){
                $('#insertBack').empty();
				$('#insertBack').html('Background image has been removed');
			  }else{
				  return false;
			  }
			}
			});
}
function ajax_blocking(status,user_id,user_name,this_obj){
			data =  '&status=' + status;
		    data +=  '&user_id=' + user_id;
			$.ajax({
			type: "POST",
			dataType: "json",
			url: wall2all_base_url+'ajax/ajax_blocking',
			data: data,
			success: function(obj){
				if(obj['result'] == 1){
                    if(status == 1){
						this_obj.attr('value', 0);
						alert('You successfully blocked user '+ user_name);
					}else{
					    this_obj.attr('value', 1);
						alert('You successfully unblocked user '+ user_name);
					}
					
				}else{
					
				}
			}
			});
}
function htmlEncode(value){
  return $('<div/>').text(value).html();
}

function htmlDecode(value){
  return $('<div/>').html(value).text();
}
$(function() {
	
	  $('.social-user-privilege').change(function(e){
	     e.preventDefault();
		 update_social_user_privileges($(this).val(), $(this).attr('data-val'));
	  });

/*      $(".show-hide-container").mouseenter(function(){
		 $(this).children(".show-hide").css("display","block");
	 });
      $(".show-hide-container").mouseover(function(){
		 $(this).children(".show-hide").css("display","block");
	 });
     $(".show-hide-container").mouseleave(function(){

		 $(this).children(".show-hide").css("display","none");

	 });*/

});