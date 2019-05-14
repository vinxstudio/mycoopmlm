@extends('layouts.master')
@section('content')
	<div class="panel panel-theme rounded shadow">
		<div class="alert-in alert hide" role="alert">
		</div>
		<div class="panel-heading">
			<div class="pull-left">
				<h3 class="panel-title">Unilevel Products<code></code></h3>
			</div>
			<div class="clearfix"></div>
        	</div>
        	<div class="panel-body form-body">
            	<div class="form-group col-sm-2">
            		<label class="col-sm-12 control-label">Products</label>
            		<select class="form-control products-list">
            			{{-- <option value="1">Kojic</option>
            			<option value="2">Gluta Soap</option>
            			<option value="3">Toner</option>
            			<option value="4">Serum</option>
            			<option value="5">Ultiman</option>
						<option value="6">My C</option> --}}
						@if(isset($products))
							@foreach ($products as $product)
								<option value="{{ $product->id }}">{{ $product->name }}</option>
							@endforeach
						@endif	
            		</select>
				</div>
				<div class="form-group col-sm-2">
					<label class="col-sm-12 control-label">Set Unilevel Amount</label>
					<div class="col-md-7">
						<input id="set-unilevel-ammount-input" type="number" class="form-control"/>
					</div>
					<button id="set-unilevel-ammount-btn" type="button" class="btn btn-primary btn-md">Submit</button>
				</div>
			</div>
		</div>
    <table class="table table-bordered table-stripe">
        <thead>
        <tr>
            <th>{{ Lang::get('products.level') }}</th>
            <th>{{ Lang::get('products.amount') }}</th>
            <th>{{ Lang::get('labels.action') }}</th>
        </tr>
        </thead>
        <tbody>
        	
        </tbody>
    </table>
@stop

@section('custom_includes')
    <script type="text/javascript">
        $(function(){

			// cause of deleted set amount by level
            $.ajax({
            	url: "/admin/products/unilevel-list",
	            type: "POST",
	    	    dataType: "JSON",
	            success: function(res){
		            html(res);
	             },
				error: function(res){
					console.log(res.responseText);
				}
             });

			// get product limit id = 1
			$.ajax({
				url : '/admin/products/unilevel-product-limit/1',
				type : 'GET',
				contentType: 'application/json',
				dataType : 'json',
				success: function(res){
					$('#set-unilevel-ammount-input').val(res);
				},
				error: function(res){
					console.log(res);
				}
			});

			$(".products-list").change(function(){
				var id = $(this).val();
				$.ajax({
					url: '/admin/products/unilevel-list',
					type: 'POST',
					dataType: 'JSON',
					data: {id: id},
					success: function(res){
						html(res);
					},
					error: function(res){
						console.log(res);
					}
				});

				$.ajax({
					url : '/admin/products/unilevel-product-limit/' + id,
					type : 'GET',
					contentType: 'application/json',
					dataType : 'json',
					success: function(res){
						$('#set-unilevel-ammount-input').val(res);
					},
					error: function(res){
					}
				});

			})

			// update unilevel product limit
			$('#set-unilevel-ammount-btn').click(function(e){
				var id = $('.products-list').val();
				var new_ammount = $('#set-unilevel-ammount-input').val();

				var alert = $('.alert-in');
				$.ajax({
					url: '/admin/products/set-unilevel-amount',
					type: 'POST',
					dataType: 'json',
					data: {product_id : id, new_ammount: new_ammount},
					success: function(result){
						//success
						ShowInfo(alert, result.message, 'alert-success', 'alert-danger', 'success');
					},
					error: function(result){	
						// show error
						console.log(result);
						ShowInfo(alert, result.responseJSON.message, 'alert-danger', 'alert-success', 'error');
						
					}
				});

			});
			
			$(document).on("click",".unilevel_update",function(){
				var id = $(this).attr("data-id");
				var amount = $(this).closest("tr").find("input").val();
				var prodcut_id = $('.products-list').val();

				var info = $(this).siblings('.alert-update-unilevel');

				$.ajax({
					url: '/admin/products/update-unilevel',
					type: 'POST',
					dataType: 'JSON',
					data: {
						id: id,
						amount: amount,
						product_id: prodcut_id
					},
					success: function(res){
						ShowInfo(info, res.message, 'alert-success', 'alert-danger', 'successss');
					},
					error: function(res){
						ShowInfo(info, res.responseJSON.message, 'alert-danger', 'alert-success', 'error');
					}
				})
			});
			
			function html(data){
				$('tbody > tr').remove();
				var html = "";
				if(data.length > 0)
				{
					for(var i = 0; i < data.length; i++){
						html += "<tr class='" + ((i == 0) ? 'hide' : '') + "'>" +
									"<td>"+ (data[i].level - 1) +"</td>" +
									"<td><input value='"+data[i].amount+"' class='form-control'" + ((i == 0) ? "disabled" : "disabled") +"></td>" +
									"<td class='col-md-2'>"+
										"<button disabled value='update' class='btn btn-primary btn-xs unilevel_update mb-5" + ((i == 0) ? 'hide' : '') + "' type='submit' data-id='"+data[i].id+"'>Update</button>"+
										"<div class='alert alert-update-unilevel' style='margin: 0; padding: 5px; padding-left: 10px' role='alert'></div>" +
									"</td>"+
								"</tr>";
					}
				}
				else
				{
					html = '<tr>No Unilevel for this Product</tr> ';
				}
				$("tbody").append(html);
			}

        });

		function ShowInfo(alert, message, addclass, removeclass, type){
			
			alert.removeClass(removeclass);
			alert.empty();
			alert.addClass(addclass);
			alert.append(message);
			alert.removeClass('hide');
		
			if(type == 'success'){
				setTimeout(function(){
					location.reload();
				}, 300);
			}
			else if(type == 'error'){
				//hide error after 3 seconds
				setTimeout(function(){
					alert.addClass('hide');
				}, 3000);
			}
			else{
				setTimeout(function(){
					alert.addClass('hide');
				}, 1500);
			}
		}


    </script>
@stop