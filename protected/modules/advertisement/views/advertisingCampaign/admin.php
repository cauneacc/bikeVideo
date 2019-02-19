<h1><?php echo Yii::t('app','Advertising campaigns administration')?></h1>
<a href="<?php echo Yii::app()->createUrl('//advertisement/advertisingCampaign/create')?>">
	<?php echo Yii::t('app','New Ad')?>
</a>
<?php
$locale = CLocale::getInstance(Yii::app()->language);

 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'advertising-campaign-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'title',
		'url_link',
		'mode',
		array('name'=>'sponsor',
			'value'=>'$data->advertisingSponsor->name'),
		'positions',
		'countries',
		'dimension',
		'price',
		'type',
		'priority',
		'tags',
		array(
			'name'=>'start_time',
			'filter' => false,
//				'value' =>'$data->start_time'),
				'value' =>'date("Y. m. d h:i:s", $data->start_time)'),
		array(
				'name'=>'end_time',
			'filter' => false,
				'value' =>'date("Y. m. d h:i:s", $data->end_time)'),
		array(
					'name'=>'status',
					'value'=>'$data->status?Yii::t(\'app\',\'Yes\'):Yii::t(\'app\', \'No\')',
							'filter'=>array('0'=>Yii::t('app','No'),'1'=>Yii::t('app','Yes')),
							),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
