<?php
$this->breadcrumbs=array(
	'Positions'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Position', 'url'=>array('index')),
	array('label'=>'Manage Position', 'url'=>array('admin')),
);
?>

<h1>Create Position</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>