function htmlEncode(value){
    if (value) {
        return jQuery('<div />').text(value).html();
    } else {
        return '';
    }
}
function currentTime() {
	var currentTime = new Date();
	var minutes = currentTime.getMinutes();
	if(minutes<10){
		minutes = '0'+minutes;
	}
	var hours = currentTime.getHours();
	if(hours==0){
		hours = '0'+hours;
	}	
	return hours+':'+minutes;
}
function str_replace (search, replace, subject, count) {
    var i = 0,
        j = 0,
        temp = '',
        repl = '',
        sl = 0,
        fl = 0,
        f = [].concat(search),
        r = [].concat(replace),
        s = subject,
        ra = Object.prototype.toString.call(r) === '[object Array]',
        sa = Object.prototype.toString.call(s) === '[object Array]';
    s = [].concat(s);
    if (count) {
        this.window[count] = 0;
    }
 
    for (i = 0, sl = s.length; i < sl; i++) {
        if (s[i] === '') {
            continue;
        }
        for (j = 0, fl = f.length; j < fl; j++) {
            temp = s[i] + '';
            repl = ra ? (r[j] !== undefined ? r[j] : '') : r[0];
            s[i] = (temp).split(f[j]).join(repl);
            if (count && s[i] !== temp) {
                this.window[count] += (temp.length - s[i].length) / f[j].length;
            }
        }
    }
    return sa ? s : s[0];
}
function user_privilege(privilege){
       switch (privilege)
		{
		case '1':
		  return 'R';
		  break;
		case '2':
		  return 'E';
		  break;
		case '3':
		  return 'M';
		  break;
		}
  } 
function ajax_log_in(username,password) {
	        data =  '&username=' + username;
			data +=  '&password=' + password;
			$.ajax({
			type: "POST",
			dataType: "json",
			url: wall2all_log_in_url,
			data: data,
			success: function(obj){
             if(obj['result'] == 1){
				 
                  window.location.href = wall2all_current_url;
				  
			 }else if(obj['result'] == 2){
				 
				   $('.form_login_toggle').css('display','block');
	               $('.login_loader').css('display','none');
                   alert('This user is blocked by administrator!');
				  return false;	
				  		  
			}else{
				   $('.form_login_toggle').css('display','block');
	               $('.login_loader').css('display','none');
                   alert('Incorrect combination password/username!');
				  return false;
			  }
			
			}
			})
}
function eventOnClick(num,popupNum) {
	$("#map_canvas").children(".popup").remove();
	$("#map_canvas").append(popupNum);
//			$(".popup").fadeOut();
	$("#popup" + num).show().animate({right:'0'}, 800);
	
}
var isMobile = {
    Android: function() {
        return navigator.userAgent.match(/Android/i) ? true : false;
    },
    BlackBerry: function() {
        return navigator.userAgent.match(/BlackBerry/i) ? true : false;
    },
    iOS: function() {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i) ? true : false;
    },
    iPhone: function() {
        return navigator.userAgent.match(/iPhone/i) ? true : false;
    },
    iPad: function() {
        return navigator.userAgent.match(/iPad/i) ? true : false;
    },
    Windows: function() {
        return navigator.userAgent.match(/IEMobile/i) ? true : false;
    },
    any: function() {
        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Windows());
    }
};
$(function() {
	
		$( "#datepicker" ).datepicker({
	
			changeMonth: true,
	
			changeYear: true,
	
			yearRange: "1900:2012" 
	
		});
		
		$('.timepicker-add-time').timepicker();
		
		var adv_modal = $(".advanced-search");
		$('.advanced-search-callout').toggle(
			function(e){
				adv_modal.toggle().stop().animate({top:'70'}, 800);
				e.preventDefault();
			},
			function(e){
				adv_modal.stop().animate({top:'-870'}, 800, function(){ adv_modal.hide(); });
				e.preventDefault();
			}
		);
		
		$('.advanced-search .close').click(function(e) {
			adv_modal.stop().animate({top:'-870'}, 800, function(){ adv_modal.hide(); });
			e.preventDefault();
		});
		
		if ($('.home-featured').length>0) {			
			var biggestHeight = 0;
			if(isMobile.any() == false){
				$('.home-featured .vignettes-wrapper').each(function(){
					if($(this).height() > biggestHeight){
						biggestHeight = $(this).height();
					}
				});
				$('.home-featured .vignettes-wrapper').height(biggestHeight);
			}
		}	
		
		if ($('.sidebar .attending').length>0) {
			if(isMobile.any()){
				$('.sidebar .attending').show();
			}
		}
			
		$("#event-bg").fullscreenBackground();

	
	
	
		$('.close').live("click",function(e) {
			
			$(this).parent().parent().animate({right:'-400'}, 800, function(){ $(".popup").hide(); });
		    e.preventDefault();
			
		});
		
		$('.next').live("click",function(e) {
			
			e.preventDefault();
		    /*$(this).parent().parent().animate({right:'-400'}, 800, function(){ $(".popup").hide(); });*/
			var incrementVal = parseInt($(this).parents('.popup').attr('data-num')) + 1;
	        eventOnClick(incrementVal,window["popup"+incrementVal]);
			/*var num = $(this).parent().parent().attr('data-num');
			var next = parseInt(num) + 1;
			$("#popup" + num).fadeOut();
			$("#popup" + next).show().animate({right:'0'}, 800);*/
		});
		
		$('.prev').live("click",function(e) {
			
			e.preventDefault();
			var decrementVal = parseInt($(this).parents('.popup').attr('data-num')) - 1;
	        eventOnClick(decrementVal,window["popup"+decrementVal]);		
			/*var num = $(this).parent().parent().attr('data-num');
			var next = parseInt(num) - 1;			
			$("#popup" + num).fadeOut();
			$("#popup" + next).show().animate({right:'0'}, 800);*/
		});
		
 $('#log_in_form').submit(function(e){
	 e.preventDefault();
	var show = '';
	 var errors = new Array();
	 var username = $('#log_username').val();
	 var password = $('#log_password').val();
	 if(username == '' ){
		  errors.push( 'Username field cannot be empty!\n');
	 }
	 if(password == ''){
		 errors.push( 'Password field cannot be empty!');
	 }
	 if(errors.length != 0){
		 $.each(errors, function(i, value) { 
		  show += value; 
		});
		 alert(show);
	 }else{
	   $('.form_login_toggle').css('display','none');
	   $('.login_loader').css('display','block');
	   ajax_log_in(username,password);
	 }
 });
});