<?php
$this->breadcrumbs=array(
'Banner Types'=>array('index'),
	$model->title,
	);

?>

<h2><?php echo $model->title; ?></h2>

<?php
$locale = CLocale::getInstance(Yii::app()->language);

 $this->widget('zii.widgets.CDetailView', array(
'data'=>$model,
'attributes'=>array(
	'id',
	'title',
	'size',
),
	)); ?>
