<?php
$this->breadcrumbs=array(
	'Cms2 Galleries'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Manage Cms2Galleries', 'url'=>array('admin')),
);
?>

<h1>Create Cms2Galleries</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>