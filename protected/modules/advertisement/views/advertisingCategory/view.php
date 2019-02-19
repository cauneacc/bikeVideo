<h2><?php echo $model->title; ?></h2>

<?php
$locale = CLocale::getInstance(Yii::app()->language);

$this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				'title',
				'description',
				),
			));
?>



