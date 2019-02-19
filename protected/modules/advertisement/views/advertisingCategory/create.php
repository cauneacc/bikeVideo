<?php
$this->menu=array(
	array('label'=>Yii::t('app', 'List') . ' AdvertisingType', 'url'=>array('index')),
	array('label'=>Yii::t('app', 'Manage') . ' AdvertisingType', 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('app', 'Create advertisement category') ?></h1>
<?php
$this->renderPartial('_form', array(
			'model' => $model,
			'buttons' => 'create'));

?>

