<?php
$this->breadcrumbs=array(
	'Cms2 Images'=>array('index'),
	'Create',
);

$this->menu=array(
//	array('label'=>'List Cms2Images', 'url'=>array('index')),
	array('label'=>'Manage Cms2Images', 'url'=>array('admin')),
);
?>

<h1>Create Cms2Images</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>