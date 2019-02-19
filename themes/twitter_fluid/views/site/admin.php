<?php

$this->menu=array(
	array('label'=>'List Video', 'url'=>array('index')),
	array('label'=>'Create Video', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('server-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1> 
	<?php echo Yii::t('masterControl', 'Video')?>
</h1>
<div class="bloc">
    <div class="title"><?php echo Yii::t('masterControl','Manage') ?></div>
    <div class="content">
<a href="<?php echo Yii::app()->createUrl('//site/addVideo')?>">
	<?php echo Yii::t('masterControl','Add new video')?>
</a>



<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'server-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'video_id',
		'title',
		'description',
		array('header'=>'Thumb',
         'value'=>'\'<img src="\'.$data->thumb_url.\'" alt="\'.$data->title.\'" />\'',
		'type'=>'raw'),
		array(
			'class'=>'CButtonColumn',
         'template' => '{update}{delete}',
		),
	),
)); ?>
	</div>
</div>
