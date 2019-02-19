<?php
$this->breadcrumbs=array(
	'Cms2 Galleries'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'Create Cms2Galleries', 'url'=>array('create')),
	array('label'=>'Update Cms2Galleries', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Cms2Galleries', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Cms2Galleries', 'url'=>array('admin')),
);
?>

<h1>View Cms2Galleries #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'desc',
	),
)); ?>
