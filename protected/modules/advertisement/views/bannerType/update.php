<?php
$this->breadcrumbs=array(
	'Banner Types'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	Yii::t('app', 'Update'),
);

$this->menu=array(
	array('label'=>Yii::t('app', 'List') . ' BannerType', 'url'=>array('index')),
	array('label'=>Yii::t('app', 'Create') . ' BannerType', 'url'=>array('create')),
	array('label'=>Yii::t('app', 'View') . ' BannerType', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('app', 'Manage') . ' BannerType', 'url'=>array('admin')),
);
?>

<h1> <?php echo Yii::t('app', 'Update');?> BannerType #<?php echo $model->id; ?> </h1>
<?php
$this->renderPartial('_form', array(
			'model'=>$model));
?>
