<h1><?php echo $model->name ?></h1>
<div style="margin-right:10px">
<?php
if(empty($model->Cms2Images)==false){
?>
	<span style="border:3px solid black">
	<a href="<?php echo Cms2Images::createMediumImageUrl($model->Cms2Images) ?>" rel="gallery" title="<?php echo htmlspecialchars($model->Cms2Images->name, ENT_QUOTES) ?>">
		<img src='<?php echo Cms2Images::createSmallImageUrl($model->Cms2Images) ?>' alt='<?php echo $model->Cms2Images->name ?>' class="img-polaroid" align="right"/>
	</a>
	</span>
<?php
}
?>
<?php echo $model->desc ?>
<?php
if (empty($gallery) == false) {
	?>
	<h2>
		<?php echo $gallery->name ?>
	</h2>
	<ul class="thumbnails">
		<?php
		foreach ($gallery->cms2Images as $image) {
			?>
			<li class="span2">
				<div >
					<a href="<?php echo Cms2Images::createMediumImageUrl($image) ?>" rel="gallery" title="<?php echo htmlspecialchars($image->name, ENT_QUOTES) ?>" class="thumbnail">
					<img src="<?php echo Cms2Images::createSmallImageUrl($image) ?>" alt="<?php echo htmlspecialchars($image->name, ENT_QUOTES) ?>" title="<?php echo htmlspecialchars($image->name, ENT_QUOTES) ?>"/>
					</a>
					<br style="clear:both" />
					<?php
					if (isset($image->name)) {
					?>
						<b><?php echo $image->name ?></b>
					<?php
					}
					?>
					<?php
					if (isset($image->description)) {
					?>
						<p><?php echo $image->description ?></p>
					<?php
					}
					?>
				</div>
			</li>
			<?php
		}
		?>
	</ul>
	<?php
}
$this->widget('application.extensions.fancybox.EFancyBox', array(
    'target'=>'a[rel=gallery]',
    'config'=>array(),
    )
);
?>
</div>