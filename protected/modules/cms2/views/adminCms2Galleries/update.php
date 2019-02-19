<?php
$this->breadcrumbs=array(
	'Cms2 Galleries'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Create Cms2Galleries', 'url'=>array('create')),
//	array('label'=>'View Cms2Galleries', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Cms2Galleries', 'url'=>array('admin')),
);
?>

<h1>Update Cms2Galleries <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>