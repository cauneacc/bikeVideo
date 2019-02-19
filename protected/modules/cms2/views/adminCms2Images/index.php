<?php
$this->breadcrumbs=array(
	'Cms2 Images',
);

$this->menu=array(
	array('label'=>'Create Cms2Images', 'url'=>array('create')),
	array('label'=>'Manage Cms2Images', 'url'=>array('admin')),
);
?>

<h1>Cms2 Images</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
