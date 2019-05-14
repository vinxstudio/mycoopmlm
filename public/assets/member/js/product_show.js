$(document).ready(function(){
	let updateQuantity = function(operator = '+'){
		let productQuantity = $('#productQuantity');
		let currentValue = productQuantity.val();

		if (!currentValue || currentValue === "" || currentValue < 0) {
			currentValue = 0;
		}

		switch(operator) {
			case '+':
				productQuantity.val(++currentValue);
				break;
			case '-':
				currentValue > 0? productQuantity.val(--currentValue): productQuantity.val(0);
		};
	};

	$('#btnAddToCart').on('click', function(){
		let url = "addToCart/" + $('#btnAddToCart').val();
		addToCart(url, false);
	});

	$('#btnBuyNow').on('click', function(){
		let url = "addToCart/" + $('#btnAddToCart').val();
		addToCart(url, true);
	});

	function addToCart(url, redirectOnSuccess = false){
		$('#btnAddToCart').attr('disabled', true);
		$('#btnBuyNow').attr('disabled', true);
		
		$.ajax({
			type: "POST",
			url: url,
			data: { 
				quantity: $('#productQuantity').val()
			},
			success: function(data, redirectOnSuccess = false) {
				if (data.success === 'true') {
					$('.alert-success').css('display', 'block');	
				} else {
					$('.alert-danger').css('display', 'block');
				}
				
		  		$('#btnAddToCart').attr('disabled', false);
		  		$('#btnBuyNow').attr('disabled', false);	
		  		
		  		if (redirectOnSuccess) {
		  			window.location.href = '/member/cart';
		  		}
		  	},
		  	error: function(){
		  		$('#btnAddToCart').attr('disabled', false);
		  		$('#btnBuyNow').attr('disabled', false);
		  		$('.alert-danger').css('display', 'block');
		  	}
		});

	}

	$('#increaseQuantity').click(function(){
		updateQuantity('+');
	})

	$('#decreaseQuantity').click(function(){
		updateQuantity('-');
	});
});