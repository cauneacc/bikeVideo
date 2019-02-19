<h2>
	<?php echo Yii::t('app','Advertising Sponsors')?>
</h2>
<?php
 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'advertising-sponsor-grid',
	'dataProvider'=>$dataProvider,
	'columns'=>array(
		'id',
		'name',
		'priority',
		'percent',
		array(
			   'class'=>'CButtonColumn',
				'template'=>'{update}{delete}',
		),
	),
)); ?>
<a href="<?php echo Yii::app()->createUrl('//advertisement/sponsor/create')?>">
	<?php echo Yii::t('app','Create new sponsor')?>
</a>