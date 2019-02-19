<h1><?php echo $model->name ?></h1>
<p><?php echo $model->desc ?></p>
<style type="text/css">
.imageGalleryContainerCms2{
margin:5px;position:relative;
}
</style>
<script type="text/javascript">
$(function() {
	$('a.lightbox').lightBox();	

})
</script>
<div style="width:500px">
<?php
if(isset($model->cms2Images)){
	$max=count($model->cms2Images);
	for($i=0;$i<$max;$i++){
		?>
		<a href="<?php echo Cms2Images::createMediumImageUrl($model->cms2Images[$i])?>" class="lightbox">
			<img src="<?php echo Cms2Images::createSmallImageUrl($model->cms2Images[$i])?>" 
				 alt="<?php echo $model->cms2Images[$i]->name ?>" 
				 title="<?php echo $model->cms2Images[$i]->name ?>" width="100"
				 class="imageGalleryContainerCms2" />
		</a>
		<?php
	}
}
?>
</div>
