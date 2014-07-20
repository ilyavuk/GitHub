$(document).ready(function(){
	$('.advanced-search-callout').click(function(e) {
		$(".advanced-search").show().animate({top:'0'}, 800);
	    e.preventDefault();
	});
	
	$('.advanced-search .close').click(function(e) {
		$(".advanced-search").animate({top:'-800'}, 800, function(){ $(".advanced-search").hide(); });
	    e.preventDefault();
	});
});

function eventOnMap(i, events, map){
	var title = 'The Title Goes Here ' + i;
	
	$("#map_canvas").append('<div id="popup' + i + '" class="popup" data-num="' + i + '"><article> <header> <h2>' + title + '</h2> </header><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis <a href="#">nostrud exercitation</a> ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p> <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod <a href="#">tempor incididunt</a> ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit.</p> <footer> Posted August 22, 2011 </footer> <a href="#" class="next">next</a> | <a href="#" class="prev">previous</a> | <a href="#" class="close">close</a> </article></div>');
	
		events.push( new google.maps.Marker({
			position: new google.maps.LatLng(Math.floor(Math.random()*100), Math.floor(Math.random()*50)), 
			
			map: map,
			draggable: false,
			title: title,
			icon: 'assets/images/apple-touch-icon.png'
		}));
		
		google.maps.event.addListener(events[i], 'click', new Function("event", "eventOnClick("+i+");"));
}