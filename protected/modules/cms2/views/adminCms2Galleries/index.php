<?php
$this->breadcrumbs=array(
	'Cms2 Galleries',
);

$this->menu=array(
	array('label'=>'Create Cms2Galleries', 'url'=>array('create')),
	array('label'=>'Manage Cms2Galleries', 'url'=>array('admin')),
);
?>

<h1>Cms2 Galleries</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
