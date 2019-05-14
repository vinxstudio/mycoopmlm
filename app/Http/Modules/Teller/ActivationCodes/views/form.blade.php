<style>
	.center{
		text-align: center;
	}
	.gray{
		background-color: #c8c8c8
	}
	.padding{
		padding: 30px;
	}
	.padding2{
		padding:5px;
	}
	.broken-border{
		border-style: dashed;
	}
	.preview{
		padding: 45px 0;
	}
	.text_left{
		text-align: left;
	}
	.text_right{
		text-align: right;
	}
	.off{
		display: none;
	}
	.submit{
		text-align: right;
	}
	.preview_img{
	    max-width: 100%;
	    display:block;
	}
	.product, .price, .card-title{
		color: #000;
		font-size: 1.25rem;
	}
	.product .card{
	    background-color: #fff;
	    -webkit-box-shadow: 0 5px 30px #ebebeb;
	    box-shadow: 0 5px 30px #ebebeb;
	}
	.card-title{
		margin-bottom: 	0.75rem;

	}
	.card-img-top{
		width: 100%;
		height: 260px
	}
	.right{
		text-align: right;
	}
	#total{
		color: #000;
		font-size: 18px;
	}
	#total label{
		padding-right: 10px;
	}
	.total{
		font-size: 20px;
		font-weight: bold
	}
	#thisusername{
		width: 30%;
		display: inline-block;
	}
	.change_img{
		display: none;
	}	

	.add-mb{
		display: block;
		margin-bottom: 2px;
	}

	/* margins */
	.mt-3{
		margin-top: 3px;
	}

	.mb-3{
		margin-bottom: 3px;
	}


	/* h1 */
	.payment-method{
		margin-top: 10px;
		margin-bottom: 10px;
		display: inline-block;
		position: relative;
	}


	/* Checkbox Style */
	.method-container{
		position: relative;
		width: auto !important;
		height: 30px;
		margin-top: 10px;
		margin-bottom: 10px;
	}

	.checkbox {
		opacity: 0;
		float:left;
	}

	.label{
		margin-left: 15px !important;
		font-weight: normal;
	}

	.checkbox + .label {
		margin: 0 0 0 10px;
		position: relative;
		cursor: pointer;
		font-size: 12px;
		float: left;
		color: #636E7B;
	}

	.checkbox + .label ~ .label {
		margin: 0 0 0 0px;
	}

	.checkbox + .label::before {
		content: ' ';
		position: absolute;
		left: -25px;
		top: -3px;
		width: 25px;
		height: 25px;
		display: block;
		background: white;
		border: 1px solid #A9A9A9;
	}

	.checkbox + .label::after {
		content: ' ';
		position: absolute;
		left: -25px;
		top: -3px;
		width: 23px;
		height: 23px;
		display: block;
		z-index: 1;
		background: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjE4MS4yIDI3MyAxNyAxNiIgZW5hYmxlLWJhY2tncm91bmQ9Im5ldyAxODEuMiAyNzMgMTcgMTYiPjxwYXRoIGQ9Ik0tMzA2LjMgNTEuMmwtMTEzLTExM2MtOC42LTguNi0yNC04LjYtMzQuMyAwbC01MDYuOSA1MDYuOS0yMTIuNC0yMTIuNGMtOC42LTguNi0yNC04LjYtMzQuMyAwbC0xMTMgMTEzYy04LjYgOC42LTguNiAyNCAwIDM0LjNsMjMxLjIgMjMxLjIgMTEzIDExM2M4LjYgOC42IDI0IDguNiAzNC4zIDBsMTEzLTExMyA1MjQtNTI0YzctMTAuMyA3LTI1LjctMS42LTM2eiIvPjxwYXRoIGZpbGw9IiMzNzM3MzciIGQ9Ik0xOTcuNiAyNzcuMmwtMS42LTEuNmMtLjEtLjEtLjMtLjEtLjUgMGwtNy40IDcuNC0zLjEtMy4xYy0uMS0uMS0uMy0uMS0uNSAwbC0xLjYgMS42Yy0uMS4xLS4xLjMgMCAuNWwzLjMgMy4zIDEuNiAxLjZjLjEuMS4zLjEuNSAwbDEuNi0xLjYgNy42LTcuNmMuMy0uMS4zLS4zLjEtLjV6Ii8+PHBhdGggZD0iTTExODcuMSAxNDMuN2wtNTYuNS01Ni41Yy01LjEtNS4xLTEyLTUuMS0xNy4xIDBsLTI1My41IDI1My41LTEwNi4yLTEwNi4yYy01LjEtNS4xLTEyLTUuMS0xNy4xIDBsLTU2LjUgNTYuNWMtNS4xIDUuMS01LjEgMTIgMCAxNy4xbDExNC43IDExNC43IDU2LjUgNTYuNWM1LjEgNS4xIDEyIDUuMSAxNy4xIDBsNTYuNS01Ni41IDI2Mi0yNjJjNS4yLTMuNCA1LjItMTIgLjEtMTcuMXpNMTYzNC4xIDE2OS40bC0zNy43LTM3LjdjLTMuNC0zLjQtOC42LTMuNC0xMiAwbC0xNjkuNSAxNjkuNS03MC4yLTcxLjljLTMuNC0zLjQtOC42LTMuNC0xMiAwbC0zNy43IDM3LjdjLTMuNCAzLjQtMy40IDguNiAwIDEybDc3LjEgNzcuMSAzNy43IDM3LjdjMy40IDMuNCA4LjYgMy40IDEyIDBsMzcuNy0zNy43IDE3NC43LTE3Ni40YzEuNi0xLjcgMS42LTYuOS0uMS0xMC4zeiIvPjwvc3ZnPg==') no-repeat center center;
		-ms-transition: all .2s ease;
		-webkit-transition: all .2s ease;
		transition: all .3s ease;
		-ms-transform: scale(0);
		-webkit-transform: scale(0);
		transform: scale(0);
		opacity: 0;
	}

	.checkbox:checked + .label::after {
		-ms-transform: scale(1);
		-webkit-transform: scale(1);
		transform: scale(1);
		opacity: 1;
	} 


</style>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-theme rounded shadow">
            <div class="panel-heading">
                <div class="pull-left">
                    <h3 class="panel-title">Add New Codes<code></code></h3>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body col-md-12">
            	<div class="form-group col-md-9 center">
                  	<div class="col-md-3 col-sm-12">
                    	<input type="radio" name="submit_type" value="generate_activation_codes" checked="true"> Generate Activation Codes<br>
                  	</div>
                  	<div class="col-md-3 col-sm-12">
                   		<input type="radio" name="submit_type" value="for_maintenance"> For Maintenance<br>
                  	</div>
                  	<div class="col-md-3 col-sm-12">
                    	<input type="radio" name="submit_type" value="product_purchase"> Product Purchase<br>
                  	</div>
                </div><!-- 
            	<div class="col-md-12">
	            	
	            </div> -->
	            <div class="col-md-4 padding">
	            	<div class="gray padding broken-border">
						<input type="file" id="receipt_image" name="receipt_image" class="hidden">
						<img class="preview_img">
						<div class="center padding2">
							<button class="btn btn-theme change_img">Change Image</button>
						</div>
	                  	<div class="preview center">
	                        <h1>UPLOAD RECEIPT HERE</h1>
	                        <button class="btn btn-theme browse">Browse Files</button>
	                  	</div>
                  	</div>
				</div>
				<div class="col-md-8 padding">
					<div class="gray padding">
						<label><h4>Search user using username.</h4></label>
						<table class="col-md-12">
							<tr>
								<td class="col-md-2"><label class="control-label">Username:</label></td>
								<td class="col-md-10">
									<input id="thisusername" type="name" class="form-control" name="forusername">
									<button type="button" id="locate-username" name="locate-Username" class="btn btn-theme" style="margin-bottom: 3px;" data-toggle="modal" data-target="#myModal">
										Locate
									</button>
								</td>
							</tr>
							<tr class="form-group">
								<td class="col-md-2">
									<label class="control-label">
										Reference No.:
									</label>
								</td>
								<td class="col-md-10">
									<input type="text" class="reference_no form-control mb-3"/>
								</td>
							</tr>
							<tr class="form-group">
								<td class="col-md-2">
									<label class="control-label">
										Payors Name:
									</label>
								</td>
								<td class="col-md-10">
									<input type="text" class="payors_name form-control"/>
								</td>
							</tr>
						</table>
						<div class="padding2">
							<h2 class="payment-method">Payment Method</h2>
							{{-- <input type="checkbox" class="payment_method" value="palawan remittance">
							<label class="control-label">Palawan remittance</label>
							<input type="checkbox" class="payment_method" value="BDO">
							<label class="control-label">BDO</label>
							<input type="checkbox" class="payment_method" value="BPI">
							<label class="control-label">BPI</label>
							<input type="checkbox" class="payment_method" value="Metrobank">
							<label class="control-label">Metrobank</label>
							<input type="checkbox" class="payment_method" value="thru branch">
							<label class="control-label">Thru Branch</label> --}}
					
							<div class="method-container">
								<input type="checkbox" class="checkbox payment_method" id="palr" value="palawan remittance" />
								<label class="label" for="palr">
									Palawan Remittance
								</label>
								<input type="checkbox" class="checkbox payment_method" id="bdo" value="BDO" />
								<label class="label" for="bdo">
									BDO
								</label>
								<input type="checkbox" class="checkbox payment_method" id="bpi" value="BPI" />
								<label class="label" for="bpi">
									BPI
								</label>
								<input type="checkbox" class="checkbox payment_method" id="metrob" value="Metrobank" />
								<label class="label" for="metrob">
									Metrobank
								</label>
								<input type="checkbox" class="checkbox payment_method" id="thru" value="thru branch" />
								<label class="label" for="thru">
									Thru Branch
								</label>
							</div>
							<div class="product_code">
								<h2>Product Code</h2>
								<div class="form-group">
									<div class="col-md-2">
										<label class="control-label">Code</label>
									</div>
									<div class="col-md-10">
										<input name="product_code" type="text" class="form-control mb-3" disabled/>
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-2">
										<label class="control-label">Password</label>
									</div>
									<div class="col-md-10 mb-20">
										<input name="product_password" type="text" class="form-control" disabled/>
									</div>
								</div>
							</div>
							<div class="generate_activation_codes">
								<table class="col-md-12" id="packages">
									<tr>
										<th class="center col-md-5">Name</th>
										<th class="center col-md-2">Package</th>
										<th class="center col-md-1">No. of Codes</th>
										<th class="center col-md-2">Coop ID</th>
										<th class="center col-md-1"></th>
									</tr>
									<tr>
										<td class="padding2"><input type="text" class="col-md-12 name"></td>
										<td class="padding2 package"><select class="col-md-12 padding2 packages"></select></td>
										<td class="padding2"><input type="number" min="1" value="1" class="col-md-12 no_of_codes"></td>
										<td class="padding2"><input type="text" class="col-md-12 coop_id"></td>
										<td><button class="delete btn btn-danger btn-xs">DELETE</button></td>
									</tr>
								</table>
								<div class="padding2">
									<button class="add_td btn btn-theme"><i class="fa fa-plus"></i>Add Name</button>
									<div class='right' id='total'><label>Total Amount: </label><span class="total"></span></div>
								</div>
							</div>
							<div class="for_maintenance off">
								<div class="form-group col-md-12">
		                            <div class="col-md-1 col-sm-12"><label>CBU</label></div>
		                            <div class="col-md-9 col-sm-12">
		                              : <input id="cbu" type="number" value="500" name="cbu" style="padding:5px;">
		                            </div>
		                          </div>
		                          <div class="form-group col-md-12 mt-10">
		                            <div class="col-md-1 col-sm-12"><label>MY-C</label></div>
		                            <div class="col-md-9 col-sm-12">
		                              : <input id="myc" type="number" value="0" name="myc" style="padding:5px;">
		                            </div>
		                        </div>
							</div>
							<div class="product_purchase off">
								<div class="col-12 product">
						            <div class="row loop"></div>
						        </div>
							</div>
						</div>
						<div class="right">
							<button class="submit btn btn-primary btn-lg" disabled>SUBMIT</button>
						</div>
					</div>
				</div>
            </div>
        </div>
    </div>
</div>
<script>

	// global variable for storing product limit
	var productLimit = [];

	// modal type 
	// for condition 
	// for button function
	var modalType = '';

	// checking if have product code in this branch
	function CheckIfHaveCodes(products){

		// loop each products
		products.forEach(product => {

			var productId = product.id;
			var productName = product.name;
			var slugName = product.slug;
			var product_type = product.product_type;

			var url = '/teller/activation-codes/if-have-product-codes-in-branch/';

			var data = {
				product_id: productId,
				product_type: product_type
			};

			$.ajax({
				method : 'GET',
				dataType: 'json',
				url: url,
				data: data
			}).done(function(msg){
				// store the limit
				// 
				console.log(msg);

				var limit = {
					name: productName,
					limit: msg.count,
					id: productId,
					product_type: product_type
				};

				productLimit.push(limit);

				if(msg.count <= 0){
					$('.'+slugName).attr('disabled', true);
				}

			}).fail(function(msg){
				// disable the input of product

				console.log(msg);
			});

			$.ajax({
				method : 'GET',
				dataType: 'json',
				url: url,
				data: {
				product_id: productId,
				product_type: 'Members Price'
				}
			}).done(function(msg){
				// store the limit
				// 
				console.log(msg);

				var limit = {
					name: productName,
					limit: msg.count,
					id: productId,
					product_type: 'Members Price'
				};

				productLimit.push(limit);

			}).fail(function(msg){
				// disable the input of product
				console.log(msg);
			});

		});

	}



	$(document).ready(function(){

		$('#messages').appendTo('body');

		var modal = $('#modal');
		modal.appendTo('body');

		var package_list = [];

		$.ajax({
            type: "GET",
            dataType: "JSON",
            url: "/teller/activation-codes/package",
            success: function(res){
            	$(".package select").append(select_option(res));
            	package_list = res;
            	console.log(package_list)
            	$(".total").append(package_list[0]['entry_fee']);
            }
        });

        $.ajax({
            type: "GET",
            dataType: "JSON",
            url: "/teller/activation-codes/products",
            success: function(res){
            	var products = ''; //res[i].image
				// '<!--<a href="/member/products/'+ res[i].slug +'"></a>-->'
            	for(var i = 0; i < res.length; i++){
            		products += '<div class="col-md-4 product_loop padding2">' +
                    				'<div class="card border-light p-3 padding2">' +
				                        '<img class="card-img-top" src="/public/products/'+ res[i].image +'" alt="">' +
				                        '<h5 class="card-title mt-3">' + res[i].name + '</h5>' +
				                        // SRP, Suggested Retail Price
										'<div class="price_type">' +
											'<input type="radio" id="price_srp' + res[i].name + '" name="' + res[i].name + 'price_type" data-product_id="'+ res[i].id +'" data-product_type="srp" onchange="ChangePriceType(this);" checked/>' +
											'<label for="price_srp' + res[i].name + '"><span></span></span>SRP: PHP ' + res[i].price + '</label>' +
										'</div>' +
										// MP, Members Price
										'<div class="price_type">' +
											'<input type="radio" id="price_mp' + res[i].name + '" name="' + res[i].name + 'price_type" data-product_id="'+ res[i].id +'" data-product_type="mp" onchange="ChangePriceType(this);"/>' +
											'<label for="price_mp' + res[i].name + '"><span></span>MP: PHP ' + res[i].rebates + '</label>' + 
										'</div>' +
										'<span class="small add-mb product_left">Product Left. ' + res[i].products_left + '</span>'+
										'<input type="number" min="0" value="0" data-value="'+ res[i].name +'" class="form-control ' + res[i].slug + '">' +
				                    '</div>' +
			                	'</div>';
            	}
						$('.loop').append(products);
							CheckIfHaveCodes(res);
            }
        });


        function select_option(data){
        	var option = "";
        	var value = "";
        	for(var i = 0; i < data.length; i++){
        		switch(data[i].membership_type_name){
        			case "Package A":
	    				value = "quantity-1";
	    				break;
					case "Package B":
						value = "quantity-2";
	    				break;
	    			case "Package C":
	    				value = "quantity-3";
	    				break;
        		}

        		if(data[i].membership_type_name == 'Package A' || data[i].membership_type_name == 'Package B' || data[i].membership_type_name == 'Package C'){
        			option += "<option value='" + value +"'>" + data[i].membership_type_name + "</option>"
        		}
        	}

        	return option;
        }

		$(".add_td").click(function(){
			var add = "<tr>" +
							"<td class='padding2'><input type='text' class='col-md-12 name'></td>" +
							"<td class='padding2 package'>" + 
								"<select class='col-md-12 padding2 packages'>" + select_option(package_list) + "</select>" +
							"</td>" +
							"<td class='padding2'><input type='number' min='1' value='1' class='col-md-12 no_of_codes'></td>" +
							"<td class='padding2'><input type='text' class='col-md-12 coop_id'></td>" +
							"<td><button class='delete btn btn-danger btn-xs'>DELETE</button></td>" +
						"</tr>";
			
			$("table#packages").append(add);
			total();
		});

		function total(){

			var total = 0;
			var payment = $("#packages").find("tr");

			for(var i = 0; i < payment.length - 1; i++){
				var package = $($(".packages")[i]).val();
				var codes = $($(".no_of_codes")[i]).val();
				switch(package){
					case 'quantity-1':
						total += parseInt(package_list[0]['entry_fee']) * parseInt(codes)
						break;
					case 'quantity-2':
						total += parseInt(package_list[1]['entry_fee']) * parseInt(codes)
						break;
					case 'quantity-3':
						total += parseInt(package_list[2]['entry_fee']) * parseInt(codes)
						break;
				}
			}

			$(".total").text(total);
		}

		$(document).on('change','.packages',function(){
			total();
		})

		$(document).on('change','.no_of_codes',function(){
			total();
		})

		$(document).on("click",".delete",function(){
			var del = $(".delete").length

			if(del != 1){
				$(this).closest("tr").remove();
				total();
			}
		});

		$(".browse").click(function(){
			$("#receipt_image").click();
		});

		$(".change_img").click(function(){
			$("#receipt_image").click();
		});

		$("#receipt_image").on("change",function(){
			$(".preview").hide();
			$(".change_img").show();
			// $(".preview").addClass("image_selected");
			if (this.files && this.files[0]) {
					var reader = new FileReader();

					reader.onload = function (e) {
							$('.preview_img')
									.attr('src', e.target.result)
					};
					
					reader.readAsDataURL(this.files[0]);
			}
		});

		$('#proceed').on('click', function(){
			// $('#thisusername').attr('disabled', true);
			$('#usersModal').modal('hide');

			/**
				* Search for Product Code
				* then put in the Product Code input and Product Password input
				*/


			let type = $('input[name="submit_type"]:checked').val();
			
			if(type == 'generate_activation_codes'){

				let prod_code_input = $('input[name="product_code"]');
				let prod_password_input = $('input[name="product_password"]');

				let product_code = prod_code_input.val();
				let product_password = prod_password_input.val();

				var username = $("#thisusername").val();
				$.ajax({
					url: '/teller/activation-codes/product-code/',
					method: 'GET',
					dataType: 'JSON',
					data: {
						username : username 
					}
				}).done(function(data){
					
					console.log(data);

					prod_code_input.val(data.message.code);
					prod_password_input.val(data.message.password);

				}).fail(function(data){

					console.log(data);

					let modal_title = modal.find('#modal-label');
					let modal_body = modal.find('#modal-body');

					let modal_procceed = modal.find('#button-confirm');

					modal_title.text(data.responseJSON.status);
					modal_body.text(data.responseJSON.message);

					modal.modal('show');

					modal_procceed.click(function(){
						modal.modal('hide');
					});

				});
			}


		});

		$(document).on("click",".submit",function(){

			var checkedVals = $('.payment_method:checkbox:checked').map(function() {
							    return this.value;
							}).get();

			var payment_method = checkedVals.join(",");

			var payment = $("#packages").find("tr");

			var thisusername = $("#thisusername").val();
			var payors_name = $(".payors_name").val();
			var reference_no = $(".reference_no").val();

			var type = $('input[name="submit_type"]:checked').val();

			var file_data = $("#receipt_image").prop("files")[0];

			var form_data = new FormData();

			var messages = '';

			if(reference_no == ''){messages += '*Please fill up Reference No <br/>'}
			if(payors_name == ''){messages += '*Please fill up Payors Name <br/>'}
			if(payment_method == ''){messages += '*Please choose Payment Method <br/>'}

			form_data.append("method",payment_method);
			form_data.append("receipt_image", file_data);
			form_data.append("payorname",payors_name);
			form_data.append("ornumber",reference_no);
			form_data.append("username",thisusername);
			form_data.append("type", type);
			
			if(type == 'generate_activation_codes'){

					var name = [];
					var packages = [];
					var coop_id = [];
					var no_of_codes = [];
					for(var i = 0; i < payment.length - 1; i++){
						var a = $($(".name")[i]).val();
						var b = $($(".packages")[i]).val();
						var c = $($(".no_of_codes")[i]).val();
						var d = $($(".coop_id")[i]).val();

						if(a){name.push(a)}
						if(b){packages.push(b)}
						if(c){no_of_codes.push(c)}
						if(d){coop_id.push(d)}
					}
					
					if(a.length == 0){messages += '*Please fill up all name <br/>'}
					if(b.length == 0){messages += '*Please fill up all packages <br/>'}
					if(c.length == 0){messages += '*Please fill up all number of codes <br/>'}
					if(d.length == 0){messages += '*Please fill up all coop id <br/>'}

					form_data.append("name", name);
					form_data.append("packages", packages);
					form_data.append("no_of_codes", no_of_codes);
					form_data.append("coop_id", coop_id);


			}else if(type == 'for_maintenance'){
				var myc = $("#myc").val();
				var cbu = $("#cbu").val();
				if(myc == 0 && cbu == 0){
					messages += 'CBU and MY-C both cannot be zero'
				}
				form_data.append("myc", myc);
				form_data.append("cbu", cbu);
			}else{

				var quantity = '';
				var value = '';
				var product_name = '';
				var product_id = '';
				var product_type = '';

				$('.product_loop').each(function(){
					
					value = $(this).find('input[type="number"]').val();
					var name = $(this).find('input[type="number"]').attr('data-value');
					var prod_type = $(this).find('input[type="radio"]:checked').attr('data-product_type');

					let prod_abr = 'SRP';

					if(prod_type == 'srp'){
						prod_abr = 'SRP';
					}
					else if(prod_type == 'mp'){
						prod_abr = 'Members Price';
					}

					// loop through product
					productLimit.forEach(product => {
						// check if value is greater than limit
						// and if name is equal to product name
						if(value > product.limit && name == product.name && prod_abr == product.product_type){
							// add message
							messages += '*' + name + ' value must be less than or equal to the number of product codes <br>';
							return;
						}
						// if value is not 0 and not greater than limit
						else if(value > 0 && name == product.name && prod_abr == product.product_type){

							product_name += name + ',';
							quantity += value + ',';
							product_id += product.id + ',';
							product_type += prod_type + ',';

							return;
						}

					});

				});

				quantity = quantity.slice(0, -1);
				product_name = product_name.slice(0, -1);
				product_id = product_id.slice(0, -1);
				product_type = product_type.slice(0, -1);

				if(quantity == ''){
					messages += '*Quantity of products can not be zero <br>';
				}

				form_data.append('product_id', product_id);
				form_data.append('product_type', product_type);
				form_data.append('quantity',quantity);
				form_data.append('products',product_name);
			}

			if(messages != ''){
				$('#messages').on('shown.bs.modal', function () {  //open warning
                    $('.modal-body').empty().append(messages);
                }).modal('show');
			}else{

				if(type == 'product_purchase'){

					// title and message
					let title = 'Confirmation';
					let message = '<kbd class="p-5">---Information---</kbd>\n';

					// add payors name, reference no, and payment method
					message += '<b>Payors Name</b> - ' + form_data.get('payorname') + '\n'; 
					message += '<b>Reference No</b> - ' + form_data.get('ornumber') + '\n';
					message += '<b>Payment Method</b> - ' + form_data.get('method') + '\n';

					// get products and quantity
					// and turn them array
					let products = form_data.get('products').split(',');
					let quantity = form_data.get('quantity').split(',');
					let prod_type = form_data.get('product_type').split(',');

					message += '<kbd class="p-5">---Products---</kbd>\n';

					// loop product and add product and quantity to message
					for(var i = 0; i < products.length; i++){

						if(prod_type[i] == 'srp')
							prod_type[i] = '(SRP)';
						else if(prod_type[i] == 'mp')
							prod_type[i] = '(MP)';

						message += '<b>Product Name</b> - ' + products[i] + ' ' + prod_type[i] + '\n';
						message += '<b>Quantity</b> - ' + quantity[i] + '\n';
					}
					
					// create a function for button on click
					let confirmBtn = function(){
						
						// send ajax post request
						$.ajax({
							url: "/teller/activation-codes",
							type: "POST",
							dataType: "JSON",
							cache: false,
							processData: false,
							contentType: false,
							data: form_data,
							success: function(res){

								console.log(res);

								if(res.success == "generate_activation_codes"){
									window.location.href = res.redirect;
								}else{
									location.reload();
								}
							},
							error: function(res){
								console.log(res);
							}
						});	
					}
						
					// show confirmation modal
					ShowModal(modal, title, message, true, confirmBtn, 'text-success');

				}
				else{

					let product_code = $('input[name="product_code"]').val();
					let product_password = $('input[name="product_password"]').val();

					/**
					 * Before Proceeding Validate Product Code and Password first
					 * 
					 */

					/**
						* Check if type if generate activation codes
						*
						*/
					let type = $('input[name="submit_type"]:checked').val();
					let gen_act_code = 'generate_activation_codes';

					$.ajax({
						url: '/teller/activation-codes/validate-product-code/',
						method: 'GET',
						dataType: 'JSON',
						data: {
							username: thisusername,
							product_code: product_code,
							product_password: product_password,
							generate_activation_codes: type == gen_act_code
						}

					}).done(function (data){

							console.log(data);

							form_data.append('product_code', product_code);
							form_data.append('product_password', product_password);

							$.ajax({
								url: "/teller/activation-codes",
								type: "POST",
								dataType: "JSON",
								cache: false,
								processData: false,
								contentType: false,
								data: form_data,
								success: function(res){
									console.log(res);
									if(res.success == "generate_activation_codes"){
										if(res.result.error != true){
											window.location.href = res.redirect;
										}
										else{
											location.reload();
										}
									}else{
										location.reload();
									}
								},
								error: function(res){
									//location.reload();
									console.log(res);
								}
							});

					}).fail(function (data){

							console.log(data);

							let code_message = data.responseJSON.data.product_code;
							let password_message = data.responseJSON.data.product_password;
							let owner_message = data.responseJSON.data.owner_id;

							if(code_message !== undefined)
								messages += '*' + code_message + '<br/>';
							if(password_message !== undefined)
								messages += '*' + password_message + '<br/>';
							if(owner_message !== undefined)
								messages += '*' + owner_message + '<br/>';

							$('#messages').on('shown.bs.modal', function () {  //open warning
								$('.modal-body').empty().append(messages);
							}).modal('show');

					});

				}

			}
		});

		$('#modal').on('hidden.bs.modal', function(){
			let modalLabel = modal.find('#modal-label');
			let modalBody = modal.find('#modal-body');
		
			let confirmBtn = modal.find('#button-confirm');

			modalLabel.removeClass('text-success');
			modalLabel.removeClass('text-danger');
			modalLabel.removeClass('text-primary');

			modalBody.removeClass('text-success');
			modalBody.removeClass('text-danger');
			modalBody.removeClass('text-primary');

			confirmBtn.removeClass('hide');
		})

		// window.location.href = "http://mycoop.local:8000/teller/activation-codes/view-batch/vivian";

		$('input[name="submit_type"]').on('click', function(){
	        var type = $(this).val();

	        $('.generate_activation_codes').hide();
	        $('.for_maintenance').hide();
	        $('.product_purchase').hide();

					$('.'+ type).show();

					let gen_act_code = 'generate_activation_codes';

					/**
					 * 
					 *  when it is not in generate activation codes
					 *  hide for product codes
					 * 
					 */

					if(type != gen_act_code)
						$('.product_code').addClass('hide');
					else
						$('.product_code').removeClass('hide');

					/**
					 * end
					 */

	    });

		$("#locate-username").click(function(){
	         //alert("test");
	         var thisusername = $("#thisusername").val();

					/**
						* remove any product_code and product_password
						* from the input
						*/
					$('input[name="product_code"]').val('');
					$('input[name="product_password"]').val('');
	        
	         //alert(thisusername);
	        if(thisusername === '') {
	            $("#myModalHelper").on("shown.bs.modal", function () {  //Tell what to do on modal open
	                   $(this).appendTo("body");
	              }).modal('show'); //open the modal once done
	        } else {

	         	$.ajax({url: "<?php echo url('/') ?>/validateusername/"+thisusername, success:function(result){
		            if (result != "Does not exist") {
		                $(".submit").removeAttr('disabled');
		                $("#myusername").val(thisusername);

		                $("#usersModal").on("shown.bs.modal", function () {  //Tell what to do on `
		                    // $('#m_account_id').text('1234567');
	                        $('#m_name').text(result);
	                        $('#m_username').text(thisusername);

	                        $('#users_name').val(result);
	                        name = result;
	                        username = thisusername;

	                        $(this).appendTo("body");
		                }).modal('show'); //open the modal once done
		            }else{
		              	$("#userDontExist").on("shown.bs.modal", function () {  //Tell what to do on modal open
		                    $(this).appendTo("body");
		                }).modal('show'); //open the modal once done
		            }
	          	}});
	        }
	    });

	});

	// function for showing modal
	function ShowModal(modal, modalTitle,  modalMessage, useConfirmBtn = '', buttonFunction = '', modalLabelClass = '', modalBodyClass = '' ){
		// get modal title and modal body by id
		let modalLabel = modal.find('#modal-label');
		let modalBody = modal.find('#modal-body');
		// close btn and confir btn
		let closeBtn = modal.find('#button-close');
		let confirmBtn = modal.find('#button-confirm');
		// add class
		modalLabel.addClass(modalLabelClass);
		modalBody.addClass(modalBodyClass);
		// empty both label and body
		modalLabel.empty();
		modalBody.empty();

		if(useConfirmBtn == true){
			confirmBtn.off('click');
			confirmBtn.click(buttonFunction);
		}

		modalLabel.text(modalTitle);
		
		modalBody.append(modalMessage);

		modal.modal('show');

	}


	function ChangePriceType(e)
	{
		/*
		*
		* product type
		* {srp} or {mp}
		*
		*/ 
		let product_id = $(e).attr('data-product_id');
		let product_type = $(e).attr('data-product_type');

		let parent = $(e).parents('.product_loop');

		let product_left_label = parent.find('.product_left');
		let product_input = parent.find('input[type="number"]');

		$.ajax({
			url: '/teller/activation-codes/products',
			method: 'GET',
			dataType: 'JSON',
			data: {
				product_id: product_id,
				product_type: product_type
			}
		}).done(function(data){

			console.log(data);
			
			product_left_label.empty().text('Product Left. ' + data.products_left);

			product_input.val(0);

			if(data.products_left < 1){
				product_input.attr('disabled', 'true');
			}
			else{
				product_input.removeAttr('disabled');
			}


		}).fail(function(data){
			console.log(data);
		})

	}


</script>


<!-- Modal -->
{{-- Really Bro? Multiple Modals? --}}
{{-- Why not just create 1, and change the content and title? --}}
{{-- Really? --}}
<div class="modal fade" id="myModalHelper" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Locate User Helper</h4>
      </div>
      <div class="modal-body">
        <ul>
        	<li>Step 1. Please input member's username.</li>
        	<li>Step 2. Locate member.</li>
        	<li>Step 3. Check if member is found.</li>
        	<li>Step 4. If member is found please input number of packages to generate codes.</li>
        	<li>Step 5. Generate Codes.</li>
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="usersModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Member found</h4>
      </div>
      <div class="modal-body">
        <ul>
        	<!-- <li>Account ID : <label id='m_account_id'></label></li> -->
        	<li>Name : <label id='m_name'></label></li>
        	<li>Username : <label id='m_username'></label></li>
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" id="proceed" class="btn btn-primary">Proceed</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="userDontExist" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Warning</h4>
      </div>
      <div class="modal-body">
        Member you locate can't be found.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="messages" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-danger" id="myModalLabel">Warning</h4>
      </div>
      <div class="message-modal modal-body text-danger">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

{{-- Modal -- Created January 15, 2019 --}}
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  <h4 class="modal-title" id="modal-label">
		  </h4>
		</div>
		<div class="modal-body pre" id="modal-body">
		</div>
		<div class="modal-footer">
		  <button id="button-close" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		  <button id="button-confirm" type="button" class="btn btn-primary">Confirm</button>
		</div>
	  </div>
	</div>
  </div>

  <style>
	  .pre{
		  white-space: pre-line;
	  }

	  /* styled radio buttons */

	.price_type {
		margin:0 0 0.75em 0;
	}

	.price_type > input[type="radio"] {
		display:none;
	}
	.price_type > input[type="radio"] + label {
		color: #292321;
		font-family:Arial, sans-serif;
		font-size:14px;
	}
	.price_type > input[type="radio"] + label span {
		display:inline-block;
		width:19px;
		height:19px;
		margin:-1px 4px 0 0;
		vertical-align:middle;
		cursor:pointer;
		border-radius:  50%;
	}

	.price_type > input[type="radio"] + label span {
		background-color: #292321;
	}

	.price_type > input[type="radio"]:checked + label span{
		background-color: #CC3300;
	}

	.price_type > input[type="radio"] + label span,
	.price_type > input[type="radio"]:checked + label span {
	transition:background-color 0.4s linear;
	}

	.price_type > input[type="radio"] + label span,
	.price_type > input[type="radio"]:checked + label span {
		transition:background-color 0.4s linear;
	}

  </style>
 