<?php echo $map['js']; ?>
<div id="contentMap" class="container home" >
<?php echo $map['html']; ?>

<script type="text/javascript">
<?php foreach($windows as $key =>$window):?>

var popup<?=$key?> = '<?=$window?>';

<?php endforeach; ?>
		function eventOnClick(num,popupNum) {
			$("#map_canvas").children(".popup").remove();
			$("#map_canvas").append(popupNum);
//			$(".popup").fadeOut();
		    $("#popup" + num).show().animate({right:'0'}, 800);
			
		}
$(document).ready(function() {	 
		$('.close').live("click",function(e) {
			
			$(this).parent().parent().animate({right:'-400'}, 800, function(){ $(".popup").hide(); });
		    e.preventDefault();
			
		});
		
		$('.next').live("click",function(e) {
			
			e.preventDefault();
			alert('next');
			/*var num = $(this).parent().parent().attr('data-num');
			var next = parseInt(num) + 1;
			$("#popup" + num).fadeOut();
			$("#popup" + next).show().animate({right:'0'}, 800);*/
		});
		
		$('.prev').live("click",function(e) {
			
			e.preventDefault();
			alert('prev');
			/*var num = $(this).parent().parent().attr('data-num');
			var next = parseInt(num) - 1;			
			$("#popup" + num).fadeOut();
			$("#popup" + next).show().animate({right:'0'}, 800);*/
		});
});		
</script>		
</div>