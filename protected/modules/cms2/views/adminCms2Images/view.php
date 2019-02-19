<?php
$this->breadcrumbs=array(
	'Cms2 Images'=>array('index'),
	$model->name,
);

$this->menu=array(
//	array('label'=>'List Cms2Images', 'url'=>array('index')),
	array('label'=>'Create Cms2Images', 'url'=>array('create')),
	array('label'=>'Update Cms2Images', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Cms2Images', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Cms2Images', 'url'=>array('admin')),
);
?>

<h1>View Cms2Images #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'add_date',
		'name',
		'description',
	),
)); ?>
<br /><br />
<img src="<?php echo Cms2Images::createSmallImageUrl($model)?>" />
<br /><br />
<img src="<?php echo Cms2Images::createMediumImageUrl($model)?>" />