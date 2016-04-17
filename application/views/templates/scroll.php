	<div class="nav pull-right scroll-top">
  		<a id="scrolltop" href="#" title="Scroll to top" style="display: none; padding: 15px;"><i class="glyphicon glyphicon-chevron-up"></i></a>
	</div>
	<script>
		/* smooth scrolling for scroll to top */
		$(document).ready(function(){
			$(window).scroll(function(){
				if ($(this).scrollTop() > 200) {
                    $('#scrolltop').fadeIn(500);
                } else {
                    $('#scrolltop').fadeOut(300);
                }
			});
			
			$('.scroll-top').click(function(){
			  $('body,html').animate({scrollTop:0},1000);
			});
		});
	</script>