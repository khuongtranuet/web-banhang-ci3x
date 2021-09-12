<div id="myCarousel" class="carousel slide" data-ride="carousel">
<ol class="carousel-indicators">
	<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
	<?php if (isset($list_images) && $list_images): ?>
	<?php for($i = 1; $i <= count($list_images); $i++): ?>
		<li data-target="#myCarousel" data-slide-to="<?php echo $i; ?>"></li>
	<?php endfor; ?>
	<?php endif; ?>
</ol>
<!-- Wrapper for slides -->
<div class="carousel-inner" role="listbox">
	<div class="item active">
		<?php if (isset($image_main) && $image_main): ?>
		<img src="<?php echo base_url('uploads/product_image/'.$image_main[0]['path']); ?>" alt="Chania"
			 style="width: auto;height: 434px; max-width: 651px;">
		<?php endif; ?>
	</div>
	<?php if (isset($list_images) && $list_images): ?>
		<?php foreach ($list_images as $result_image): ?>
			<div class="item">
				<img src="<?php echo base_url('uploads/product_image/'.$result_image['path']) ?>" alt="Chania"
					 style="width: auto;height: 434px; max-width: 651px;">
			</div>
		<?php endforeach; ?>
	<?php endif; ?>
</div>
<!-- Left and right controls -->
<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
	<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
	<span class="sr-only">Previous</span>
</a>
<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
	<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
	<span class="sr-only">Next</span>
</a>
</div>
