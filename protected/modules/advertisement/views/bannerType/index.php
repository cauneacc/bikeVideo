<?php
$this->breadcrumbs = array(
	'Banner Types',
	Yii::t('app', 'Index'),
);

$this->menu=array(
	array('label'=>Yii::t('app', 'Create') . ' BannerType', 'url'=>array('create')),
	array('label'=>Yii::t('app', 'Manage') . ' BannerType', 'url'=>array('admin')),
);
?>

<h1>Banner Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
