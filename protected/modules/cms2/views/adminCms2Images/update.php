<?php
$this->breadcrumbs=array(
	'Cms2 Images'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
//	array('label'=>'List Cms2Images', 'url'=>array('index')),
	array('label'=>'Create Cms2Images', 'url'=>array('create')),
	array('label'=>'View Cms2Images', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Cms2Images', 'url'=>array('admin')),
);
?>

<h1>Update Cms2Images <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>