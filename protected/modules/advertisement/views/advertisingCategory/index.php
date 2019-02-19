<?php
$this->breadcrumbs = array(
	'Advertising Types',
	Yii::t('app', 'Index'),
);

$this->menu=array(
	array('label'=>Yii::t('app', 'Create') . ' AdvertisingType', 'url'=>array('create')),
	array('label'=>Yii::t('app', 'Manage') . ' AdvertisingType', 'url'=>array('admin')),
);
?>

<h1>Advertising Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
