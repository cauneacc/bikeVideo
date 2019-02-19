<?php
$this->breadcrumbs=array(
	'Advertising Types'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	Yii::t('app', 'Update'),
);

?>

<h1> <?php echo $model->title; ?> </h1>
<?php
$this->renderPartial('_form', array(
			'model'=>$model));
?>
