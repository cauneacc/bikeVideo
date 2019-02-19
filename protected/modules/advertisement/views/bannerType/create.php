<?php
$this->breadcrumbs=array(
	'Banner Types'=>array(Yii::t('app', 'index')),
	Yii::t('app', 'Create'),
);

$this->menu=array(
	array('label'=>Yii::t('app', 'List') . ' BannerType', 'url'=>array('index')),
	array('label'=>Yii::t('app', 'Manage') . ' BannerType', 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app', 'Create banner type') ?></h1>
<?php
$this->renderPartial('_form', array(
			'model' => $model,
			'buttons' => 'create'));

?>

