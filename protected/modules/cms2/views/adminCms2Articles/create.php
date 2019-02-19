<?php
$this->breadcrumbs=array(
	'Cms2 Articles'=>array('index'),
	'Create',
);

$this->menu=array(
//	array('label'=>'List Cms2Articles', 'url'=>array('index')),
	array('label'=>'Manage Cms2Articles', 'url'=>array('admin')),
);
?>

<h1>Create Cms2Articles</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,
	'categories'=>$categories,
	'images'=>$images
	)); ?>