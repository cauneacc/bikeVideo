<?php
$this->breadcrumbs=array(
	'Cms2 Articles'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Preview Article', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Back to Article Manager', 'url'=>array('admin')),
);
?>

<h1>Update Article <?php echo $model->name; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,
	'categories'=>$categories,
	'images'=>$images
	)); ?>