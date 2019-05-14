$(document).ready(function(){

	let products = {};

	let updateQuantity = function(operator = '+', slug){
		return new Promise(function(resolve, reject) {
		    let productQuantity = $('#product_' + slug + '_quantity');
			let currentValue    = products[slug]['quantity'];

			if (!currentValue || currentValue === "" || currentValue < 0) {
				currentValue = 0;
			}
			switch(operator) {
				case '+':
					products[slug]['quantity'] = ++currentValue;
					productQuantity.val(products[slug]['quantity']);
					break;
				case '-':
					if (currentValue > 0) {
						products[slug]['quantity'] = --currentValue;
					} else {
						products[slug]['quantity'] = 0;
					}

					productQuantity.val(products[slug]['quantity']);
			};

			resolve();
	  	});
	};
	let updateTotalPrice = function(slug){
		return new Promise(function(resolve, reject) {
		    let divProductTotalPrice = $('#product_' + slug + '_total_price');
			let productTotalPrice = products[slug]['quantity'] * products[slug]['price'];

			divProductTotalPrice.text('P ' + productTotalPrice.toLocaleString()); //this.id
			resolve();
	  	});
	}
	let updateCartTotalPrice = function(){
		return new Promise(function(resolve, reject) {
			let cartTotalPrice    = 0.00;
			let divCartTotalCost  = $('#divCartTotalCost');

			for (key in products) {
				cartTotalPrice = cartTotalPrice + parseFloat(products[key]['price'] * products[key]['quantity']);
			}

			divCartTotalCost.text('₱ ' + cartTotalPrice.toLocaleString());

			resolve();
	  	}).then(updateSession());
	}
	let createProductObject = function(){
		let divProductSlugs      = $('.productSlugs');
		let divProductUnitPrices = $('.productUnitPrices');
		let divProductQuantities = $('.productQuantities');

		let productSlugs      = [];
		let productUnitPrices = [];
		let productQuantities = [];

		$.each(divProductSlugs, function(index, element) {
		    productSlugs.push(element.value);
		});

		$.each(divProductUnitPrices, function(index, element) {
		    productUnitPrices.push(element.innerHTML.replace(/\D/g,''));
		});

		$.each(divProductQuantities, function(index, element) {
		    productQuantities.push(element.value.replace(/\D/g,''));
		});

		for (let index = 0; index < productSlugs.length; index++) {
			products[productSlugs[index]] = {
					price: productUnitPrices[index],
					quantity: productQuantities[index]
			};
		}
		console.log(products);
	}
	let updateSession = function(){
		return new Promise(function(resolve, reject) {   
			let url = "cart/update";
			
			$.ajax({
				type: "POST",
				url: url,
				data: { 
					products: products
				},
				success: function(data) {
					if (data.success === 'true') {
						$('.alert-success').css('display', 'block');
						$('.alert-success').fadeOut(6000);	
					} else {
						$('.alert-danger').css('display', 'block');
						$('.alert-danger').fadeOut(6000);
					}
			  	},
			  	error: function(){
			  		$('.alert-danger').css('display', 'block');
			  		$('.alert-danger').fadeOut(6000);
			  	}
			});
	  	});
	}

	createProductObject();

	$('.productQuantities').on('change', function(){
		let slug = this.id.split('_');
		updateTotalPrice(slug[1]).then(updateCartTotalPrice());
	});

	$('.btnIncreaseQuantity').click(function(){
		let slug = $(this).val();

		updateQuantity('+', slug).then(updateTotalPrice(slug)).then(updateCartTotalPrice());
	})

	$('.btnDecreaseQuantity').click(function(){
		let slug = $(this).val();

		updateQuantity('-', slug).then(updateTotalPrice(slug)).then(updateCartTotalPrice());
	});

	$('.btnRemoveFromCart').on('click',  function(){
		let slug = $(this).val();
		let url  = "products/removeFromCart/" + slug;
		
		$.ajax({
			type: "POST",
			url: url,
			success: function(data) {	
		  		if (data.success === 'true') {
		  			$('#product_' + slug).remove();
					$('.alert-success').css('display', 'block');	
				} else {
					$('.alert-danger').css('display', 'block');
				}
		  	},
		  	error: function(){
		  		$('.alert-danger').css('display', 'block');
		  	}
		});
	});

	updateCartTotalPrice();
});