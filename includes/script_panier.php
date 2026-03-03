    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script language="Javascript" type="text/javascript">

	// Global tracking to prevent double clicks
	var cartProcessing = {};

	function addToCart(product_id, quantity) {
		// Handle case where browser passes event as first parameter
		// Extract only numeric values from arguments
		var args = Array.prototype.slice.call(arguments);
		var numericValues = [];
		
		for(var i = 0; i < args.length; i++) {
			var val = parseInt(args[i]);
			if(!isNaN(val)) {
				numericValues.push(val);
			}
		}
		
		// We need at least product_id and quantity (2 numeric values)
		if(numericValues.length < 2) {
			console.error('Invalid parameters - need product_id and quantity:', arguments);
			alert('Erreur: Paramètres invalides');
			return false;
		}
		
		// First numeric value is product_id, second is quantity
		product_id = numericValues[0];
		quantity = numericValues[1];
		
		// Check if this product is already being added
		if(cartProcessing[product_id]) {
			return false;
		}
		
		// Mark this product as being processed
		cartProcessing[product_id] = true;
		
		// Find all buttons that add this product and disable them
		var buttons = document.querySelectorAll('[onclick*="addToCart(' + product_id + ',"]');
		var originalStates = [];
		for(var i = 0; i < buttons.length; i++) {
			originalStates.push({
				button: buttons[i],
				disabled: buttons[i].disabled,
				html: buttons[i].innerHTML
			});
			buttons[i].disabled = true;
			if(buttons[i].innerHTML.indexOf('fa-spinner') === -1) {
				buttons[i].innerHTML = '<i class="fa fa-spinner fa-spin"></i> Ajout...';
			}
		}
		
		var url = '<?php echo lienPanier() ?>';
				
		$.ajax({
			url: 'includes/cart.php',
			type: 'GET',
			data: 'id_produit=' + product_id + '&quantity=' + quantity + '&action=add',
		    dataType: "json",
			success: function(data) {
				// Use Toastify for success
				Toastify({
				  text: "✅ Produit ajouté au panier. Voir mon panier",
				  duration: 4000,
                  destination: url,
				  newWindow: false,
				  close: true,
				  gravity: "bottom",
				  position: "right",
                  className: "toast-tw",
				  style: {
					background: "var(--shop-primary, #5A31F4)",
					color: "#fff",
					borderRadius: "0.75rem",
					boxShadow: "0 10px 30px rgba(90,49,244,0.3)",
					fontFamily: "Inter, sans-serif",
					fontSize: "0.875rem",
                    fontWeight: "500",
                    padding: "1rem 1.25rem",
					cursor: "pointer"
				  },
				  onClick: function(){}
				}).showToast();
				
				// Update all cart counters
			    if(document.getElementById("blocDepartementsPanier")) document.getElementById("blocDepartementsPanier").innerHTML = data[0];
			    if(document.getElementById("lblCartCount")) document.getElementById("lblCartCount").innerHTML = '('+data[0]+')';
        		if(document.getElementById("floatingCartCount")) document.getElementById("floatingCartCount").innerHTML = data[0];
				
				// Re-enable buttons after a short delay
				setTimeout(function() {
					for(var i = 0; i < originalStates.length; i++) {
						originalStates[i].button.disabled = originalStates[i].disabled;
						originalStates[i].button.innerHTML = originalStates[i].html;
					}
					delete cartProcessing[product_id];
				}, 1000);
			},
			error: function (data) {
				console.log('Error:', data);
				// Re-enable buttons immediately on error
				for(var i = 0; i < originalStates.length; i++) {
					originalStates[i].button.disabled = originalStates[i].disabled;
					originalStates[i].button.innerHTML = originalStates[i].html;
				}
				delete cartProcessing[product_id];
				alert('Erreur lors de l\'ajout au panier. Veuillez réessayer.');
			}
		}); 
		
		return false;
	}

	function addToCart1(product_id, quantity) {
		
				
		$.ajax({
			url: 'includes/cart.php',
			type: 'GET',
			data: 'id_produit=' + product_id + '&quantity=' + quantity + '&action=add',
		    dataType: "json",
			success: function(data) {
			  document.location.href="cart.php"
			},
			error: function (data) {
				console.log('Error:', data);
			}
		}); 
	}
	function UpdatePlusProductCart(product_id, quantity) {
		 var quantity = parseInt(quantity) + 1;

		$.ajax({
			url: 'includes/cart.php',
			type: 'GET',
			data: 'id_produit=' + product_id + '&quantity=' + quantity + '&action=mod',
		    dataType: "json",
			success: function(data) { 	
			  document.location.href="cart.php"
			},
			error: function (xhr, status, error) {
				console.error('AJAX Error:', error);
				console.error('Status:', status);
				console.error('Response:', xhr.responseText);
			}
		});
	}
	function UpdateMoinProductCart(product_id, quantity) {
		var quantity = parseInt(quantity) - 1;
		
		$.ajax({
			url: 'includes/cart.php',
			type: 'GET',
			data: 'id_produit=' + product_id + '&quantity=' + quantity + '&action=mod',
		    dataType: "json",
			success: function(data) {	
			  document.location.href="cart.php"
			}
		});
	}
	function RemoveProductCart(product_id) {
		$.ajax({
			url: 'includes/cart.php',
			type: 'GET',
			data: 'id_produit=' + product_id + '&action=remove',
		    dataType: "json",
			success: function(data) { 	
			  document.getElementById("blocDepartementsPanier").innerHTML = data[0];
			  if(document.getElementById("floatingCartCount")) document.getElementById("floatingCartCount").innerHTML = data[0];
			  
			  document.getElementById("shopping__cart").innerHTML = data[1];

			  // Use Toastify for removal
              Toastify({
				  text: "🗑️ Produit supprimé du panier.",
				  duration: 3000,
				  newWindow: false,
				  close: true,
				  gravity: "bottom",
				  position: "right",
				  style: {
					background: "#1e293b",
					color: "#fff",
					borderRadius: "0.75rem",
					boxShadow: "0 10px 30px rgba(0,0,0,0.2)",
					fontFamily: "Inter, sans-serif",
					fontSize: "0.875rem",
					padding: "1rem 1.25rem"
				  }
			  }).showToast();

			  $('html, body').animate({ scrollTop: 0 }, 'slow');
			}
		});
	}
	function RemoveProductPanier(product_id) {
		$.ajax({
			url: 'includes/cart.php',
			type: 'GET',
		    dataType: "json",
			data: 'id_produit=' + product_id + '&action=remove',
			success: function(data) { 	
			  document.location.href="cart.php"
			}
		});
	}
	function RemoveBonReduction() {
		$.ajax({
			url: 'includes/cart.php',
			type: 'GET',
			data: 'action=supp_coupon',
		    dataType: "json",
			success: function() { 	
			  document.location.href="cart.php"
			}
		});
	}
	</script>
	<!-- Toastify CSS overrides -->
	<style>
		.toastify.toast-tw:hover { box-shadow: 0 12px 40px rgba(90,49,244,0.4) !important; transform: translateY(-3px); }
        .toast-close { opacity: 0.8; transition: opacity 200ms ease; }
        .toast-close:hover { opacity: 1; }
	</style>