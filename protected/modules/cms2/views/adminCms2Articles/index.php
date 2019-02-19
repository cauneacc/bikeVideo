<?php
$this->breadcrumbs=array(
	'Cms2 Articles',
);

$this->menu=array(
	array('label'=>'Create Cms2Articles', 'url'=>array('create')),
	array('label'=>'Manage Cms2Articles', 'url'=>array('admin')),
);
?>

<h1>Cms2 Articles</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
