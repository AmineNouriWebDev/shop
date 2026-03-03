<?php echo $tagmanager_body; ?>   

	<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.js"></script>
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
	
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <!-- All js plugins included in this file. -->
    <script src="dist/js/plugins.js"></script>
    <!-- Main js file that contents all jQuery plugins activation. -->
    <script src="dist/js/main.js"></script>
    <!-- Modern Sidebar JavaScript -->
    <script src="assets/js/sidebar.js"></script>
    <script src="assets/js/device-icons.js"></script>
 
    

	<script type="text/javascript">
		$(document).ready(function(){
			$('.prod-similaire').slick({
				slidesToShow: 4,
				slidesToScroll: 1,
				autoplay: true,
				autoplaySpeed: 3000,
				arrows: false,
				dots: false,
				pauseOnHover: false,
				responsive: [{
					breakpoint: 992,
					settings: {
						slidesToShow: 2
					}
				}, {
					breakpoint: 768,
					settings: {
						slidesToShow: 2
					}
				}, {
					breakpoint: 520,
					settings: {
						slidesToShow: 1
					}
				}, {
					breakpoint: 370,
					settings: {
						slidesToShow: 1
					}
				}]
			});
			$('.customer-megaMenu').slick({
				slidesToShow: 3,
				slidesToScroll: 1,
				autoplay: false,
				arrows: true,
				dots: false,
				pauseOnHover: false,
				responsive: [{
					breakpoint: 992,
					settings: {
						slidesToShow: 1
					}
				}, {
					breakpoint: 768,
					settings: {
						slidesToShow: 1
					}
				}, {
					breakpoint: 520,
					settings: {
						slidesToShow: 1
					}
				}, {
					breakpoint: 370,
					settings: {
						slidesToShow: 1
					}
				}]
			});
			
		});

	</script>
	
	<script type="text/javascript">
			$(document).ready(function(){

            	$(window).scroll(function () {

            			if ($(this).scrollTop() > 50) {

            				$('#scrollUP').fadeIn();

            			} else {

            				$('#scrollUP').fadeOut();

            			}

            		});

            		// scroll body to 0px on click

            		$('#scrollUP').click(function () {

            			$('body,html').animate({

            				scrollTop: 0

            			}, 400);

            			return false;

            		});

            });

			

	</script>

	<script src="dist/js/zoomsl.js"></script>
    <script type="text/javascript">
		$(document).ready(function () {
			$('.myImage').imagezoomsl({ 
			zoomrange: [3, 3],
			magnifiersize: [640, 480],
			magnifierpos: "right"		
			
			/*,magnifierborder:'none'*/ 
			
			});
		});
	</script>


	
 	 
 	 
 	 
 	 
