<?php echo $tagmanager_body; ?>

<?php include(__DIR__ . '/compare-bar.php'); ?>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.js"></script>
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
	

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
				arrows: true,
                prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-chevron-left"></i></button>',
                nextArrow: '<button type="button" class="slick-next"><i class="fa fa-chevron-right"></i></button>',
				dots: false,
				pauseOnHover: false,
				responsive: [{
					breakpoint: 992,
					settings: {
						slidesToShow: 2
					}
				}, {
					breakpoint: 520,
					settings: {
						slidesToShow: 2
					}
				}, {
					breakpoint: 370,
					settings: {
						slidesToShow: 2
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

            			if ($(this).scrollTop() > 400) {

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

<script>
// -- Flash Sales Countdown Script --
document.addEventListener('DOMContentLoaded', function() {
    function formatTime(totalSeconds) {
        if (totalSeconds <= 0) return "Expiré";
        
        const days = Math.floor(totalSeconds / (3600 * 24));
        const hours = Math.floor((totalSeconds % (3600 * 24)) / 3600);
        const mins = Math.floor((totalSeconds % 3600) / 60);
        const secs = Math.floor(totalSeconds % 60);
        
        let out = "";
        if (days > 0) out += days + "j ";
        out += String(hours).padStart(2, '0') + "h ";
        out += String(mins).padStart(2, '0') + "m ";
        out += String(secs).padStart(2, '0') + "s";
        return out;
    }

    function updateCountdowns() {
        // Query inside the function so AJAX-injected elements are correctly selected
        const flashElements = document.querySelectorAll('.flash-countdown');
        if (flashElements.length === 0) return;

        const now = Math.floor(Date.now() / 1000); // current timestamp in seconds
        
        flashElements.forEach(el => {
            const endAttr = el.getAttribute('data-end');
            if(!endAttr) return; // safety check
            
            const endTimestamp = parseInt(endAttr);
            const remaining = endTimestamp - now;
            
            if (remaining <= 0) {
                el.innerHTML = "Terminé";
            } else {
                el.innerHTML = formatTime(remaining);
            }
        });
    }

    updateCountdowns();
    setInterval(updateCountdowns, 1000);
});
</script>
 	 
 	 
 	 
 	 
