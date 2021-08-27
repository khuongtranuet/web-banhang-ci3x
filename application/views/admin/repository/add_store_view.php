<div class="row">
	<div class="col-lg-12">
		<h3>Thêm đơn nhập kho</h3>
	</div>
	<div class="col-lg-12 col-sm-12 text-center mb-1" style="position: absolute; top: 110px; right: 0px;">
		<img src="<?php echo base_url('public/images/data-loading.gif') ?>" id="data-loading" style="display: none; width: 65px">
	</div>
	<form action="" class="form-horizontal" method="POST">
		<div class="col-lg-12">
			<div class="col-lg-6 form-group">
				<div class="row">
					<div class="col-lg-4">
						<label class="control-label" for="repository">Kho nhập<span style="color: red;">(*)</span>:</label>
					</div>
					<div class="col-lg-8">
						<select class="form-control" name="repository" id="repository">
							<option value="-1">- Kho hàng -</option>
							<?php if(isset($repository) && $repository):?>
								<?php foreach ($repository as $result_repository):?>
									<option value="<?php echo $result_repository['id']; ?>"
										<?php if(set_value('repository') == $result_repository['id']) {echo 'selected';} ?>><?php echo $result_repository['name']; ?></option>
								<?php endforeach; ?>
							<?php endif; ?>
						</select>
						<?php echo form_error('repository'); ?>
					</div>
				</div>
			</div>
			<div class="col-lg-5 form-group" style="margin-left: 10px;">
				<div class="row">
					<div class="col-lg-4">
						<label class="control-label" for="import_date">Ngày nhập<span style="color: red;">(*)</span>:</label>
					</div>
					<div class="col-lg-8">
						<input type="datetime-local" class="form-control" id="import_date" name="import_date" value="<?php echo set_value('import_date'); ?>">
						<?php echo form_error('import_date'); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-12 field_wrapper">
			<div class="col-lg-6 form-group">
				<div class="row">
					<div class="col-lg-4">
						<label class="control-label" for="product">Sản phẩm<span style="color: red;">(*)</span>:</label>
					</div>
					<div class="col-lg-8">
						<select class="form-control selectpicker" data-live-search="true" data-size="15" name="product[]" id="product">
							<option value="-1">- Sản phẩm -</option>
							<?php if(isset($product) && $product):?>
								<?php foreach ($product as $result_product):?>
									<option value="<?php echo $result_product['id']; ?>"
										<?php if(set_value('product') == $result_product['id']) {echo 'selected';} ?>><?php echo $result_product['name']; ?></option>
								<?php endforeach; ?>
							<?php endif; ?>
						</select>
						<?php echo form_error('product[]'); ?>
					</div>
				</div>
			</div>
			<div class="col-lg-5 form-group" style="margin-left: 10px;">
				<div class="row">
					<div class="col-lg-4">
						<label class="control-label" for="import_quantity">Số lượng<span style="color: red;">(*)</span>:</label>
					</div>
					<div class="col-lg-8">
						<input type="text" class="form-control" id="import_quantity" name="import_quantity[]" value="<?php echo set_value('import_quantity'); ?>">
						<?php echo form_error('import_quantity'); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-12" id="div-ajax"></div>
		<div class="col-lg-12">
			<a class="btn btn-primary add_button" id="plus" style="border-radius: 15px;"><i class="fa fa-plus"></i></a>
		</div>
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12 col-sm-12 col-xs-12" style="text-align: center;">
					<button class="btn btn-primary" type="submit" name="submit">Thêm</button>
				</div>
			</div>
		</div>
	</form>
	<script type="text/javascript">
		$(document).ready(function(){
			var maxField = 10; //Input fields increment limitation
			var addButton = $('.add_button'); //Add button selector
			var wrapper = $('.field_wrapper'); //Input field wrapper
			var fieldHTML = '<div><div class="col-lg-6 form-group">';
			fieldHTML += '<div class="row">';
			fieldHTML += '<div class="col-lg-4">';
			fieldHTML += '<label class="control-label" for="product">Sản phẩm<span style="color: red;">(*)</span>:</label>';
			fieldHTML += '</div>';
			fieldHTML += '<div class="col-lg-8">';
			fieldHTML += '<select class="form-control" name="product[]" id="product">';
			fieldHTML += '<option value="-1">- Sản phẩm -</option>';
			fieldHTML += "<?php if(isset($product) && $product):?>";
			fieldHTML += "<?php foreach ($product as $result_product):?>";
			fieldHTML += '<option value="';
			fieldHTML += "<?php echo $result_product['id']; ?>";
			fieldHTML += '"';
			fieldHTML += '<?php if(set_value('product') == $result_product['id']) {echo 'selected';} ?>';
			fieldHTML += '><?php echo $result_product['name']; ?></option>';
			fieldHTML += "<?php endforeach; ?>";
			fieldHTML += "<?php endif; ?>";
			fieldHTML += '</select>';
			fieldHTML += '<?php echo form_error('product'); ?>';
			fieldHTML += '</div>';
			fieldHTML += '</div>';
			fieldHTML += '</div>';
			fieldHTML += '<div class="col-lg-5 form-group" style="margin-left: 10px;">';
			fieldHTML += '<div class="row">';
			fieldHTML += '<div class="col-lg-4">';
			fieldHTML += '<label class="control-label" for="import_quantity">Số lượng<span style="color: red;">(*)</span>:</label>';
			fieldHTML += '</div>';
			fieldHTML += '<div class="col-lg-8">';
			fieldHTML += '<input type="text" class="form-control" id="import_quantity" name="import_quantity[]" value="<?php echo set_value('import_quantity'); ?>">';
			fieldHTML += '<?php echo form_error('import_quantity'); ?>';
			fieldHTML += '</div>';
			fieldHTML += '</div>';
			fieldHTML += '</div>';
			fieldHTML += '<div class="col-lg-1"><a class="btn btn-primary remove_button" id="minus" style="border-radius: 15px;"><i class="fa fa-minus"></i></a></div>';
			fieldHTML += '</div>';
			console.log(fieldHTML);
			var x = 1; //Initial field counter is 1

			//Once add button is clicked
			$(addButton).click(function(){
				//Check maximum number of input fields
				if(x < maxField){
					x++; //Increment field counter
					$(wrapper).append(fieldHTML); //Add field html
				}
			});

			//Once remove button is clicked
			$(wrapper).on('click', '.remove_button', function(e){
				e.preventDefault();
				$(this).parent('div').parent('div').remove(); //Remove field html
				x--; //Decrement field counter
			});
		});
	</script>
<!--	<script type="text/javascript">-->
<!--		$(document).ready(function () {-->
<!--			clickByButton('minus');-->
<!--			clickByButton('plus');-->
<!--		});-->
<!---->
<!--		function clickByButton(id, url_ajax) {-->
<!--			$('#' + id).click(function () {-->
<!--				var type;-->
<!--				if (id == 'minus') {-->
<!--					type = 'minus';-->
<!--				}-->
<!--				if (id == 'plus') {-->
<!--					type = 'plus';-->
<!--				}-->
<!--				callAjax(type ,window.ajax_url.product_store);-->
<!--			});-->
<!--		}-->
<!---->
<!--		function callAjax(type, url_ajax) {-->
<!--			$('#data-loading').show()-->
<!--			$.ajax({-->
<!--				url: url_ajax,-->
<!--				type: 'POST',-->
<!--				dataType: 'html',-->
<!--				data: {-->
<!--					type: type,-->
<!--				}-->
<!--			}).done(function (result) {-->
<!--				$('#data-loading').hide();-->
<!--				$('#div-ajax').html(result);-->
<!--			})-->
<!--			$(document).ajaxError(function () {-->
<!--				$('#data-loading').hide();-->
<!--			});-->
<!--		}-->
<!--	</script>-->
</div>
<style>
	.form-control {
		border-color: #cccccc;
	}
</style>
