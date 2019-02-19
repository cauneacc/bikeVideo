<h1><?php echo Yii::t('app','Advertising templates')?></h1>
<a href="<?php echo Yii::app()->createUrl('//advertisement/textAdTemplates/create')?>">
	<?php echo Yii::t('app','New Template')?>
</a>
<?php
 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'advertising-template-grid',
	'dataProvider'=>$dataProvider,
	'columns'=>array(
		'id',
		'name',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
