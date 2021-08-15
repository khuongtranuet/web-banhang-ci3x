<?php if($this->session->flashdata('success')): ?>
    <div class="row" style="margin-top: 10px;">
		<div class="col-lg-12">
			<div class="alert alert-block alert-success" style="margin-bottom: 5px">
				<button type="button" class="close" data-dismiss="alert">
					<i class="ace-icon fa fa-times"></i>
				</button>
				<i class="ace-icon fa fa-check green"></i>
				<?php echo $this->session->flashdata('success'); ?>
			</div>
		</div>
    </div>
<?php endif; ?>
<?php if($this->session->flashdata('error')): ?>
    <div class="row" style="margin-top: 10px;">
		<div class="col-lg-12">
			<div class="alert alert-block alert-danger" style="margin-bottom: 5px">
				<button type="button" class="close" data-dismiss="alert">
					<i class="ace-icon fa fa-times"></i>
				</button>
				<i class="ace-icon fa fa-times"></i>
				<?php echo $this->session->flashdata('error'); ?>
			</div>
		</div>
    </div>
<?php endif; ?>
