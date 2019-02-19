<?php
$this->breadcrumbs=array(
		'Campaign'=>array('index'),
		$model->id
		);
		
?>


<h3> Campaign number: 
<?php echo 'W-'.date('Y', $model->createtime).'-'.$model->id; ?> </h3>

<?php
if($model->status == 0) {
	echo '<h2> This campaign is not yet activated. <br /> A statistic is not available. </h2>';
		if($model->payment_type == 1) // Vorkasse
			$prefix = 'prepay';
		if($model->payment_type == 2) // Lastschrift
			$prefix = 'lastschrift';
		if($model->payment_type == 3) // Online-Überweisung
			$prefix = 'ebank2pay';

}
?> 


<?php if($model->mode == 'image') { ?>
<div class="imagepreview">
<?php echo $model->getImage(); ?>
</div>
<?php } else if ($model->mode == 'text') 
echo $model->drawTextAd();
else if ($model->mode == 'script') 
echo CHtml::textArea('script', $model->script); 

?>



<?php
$locale = CLocale::getInstance(Yii::app()->language);

$this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				'title',
				array(
					'name'=>'createtime',
					'value' =>$locale->getDateFormatter()->formatDateTime($model->createtime, 'medium', 'medium')),
				array(
					'name'=>'updatetime',
					'value' =>$locale->getDateFormatter()->formatDateTime($model->updatetime, 'medium', 'medium')),
				array(
					'name'=>'start_time',
					'value' =>$locale->getDateFormatter()->formatDateTime($model->start_time, 'medium', '')),
				array(
					'name'=>'end_time',
					'value' =>$locale->getDateFormatter()->formatDateTime($model->end_time, 'medium', '')),
				array(
					'name' =>'status',
					'type' => 'raw',
					'value' => $model->status ? "Campaign is active" : "Campaign is inactive"),
				array(			'name'=>'url_picture',
					),
				array(			'name'=>'url_link',
					),
				array('name'=>'sponsor',
					'value'=>$model->advertisingSponsor->name),
				'tags',
				'positions',
				'category.title',
				'countries',
				'dimension',
				'mode',
				))
); 

$this->renderPartial(
		'application.modules.advertisement.views.advertisingCategory.view', array(
			'model' => $model->category)); 
	
if(isset($model->visits)) {
	echo '<h2> Visitor Details </h2>';
	echo '<div style="clear: both;"></div>';

	$visit = new UserVisit;
	$visit->advertising_campaign_id = $model->id;
	$visit->user_id = null;

	$this->widget('zii.widgets.grid.CGridView', array(
				'dataProvider'=>$visit->search(),
				'filter'=>$visit,
				'columns' => array(
					'ip_addr',	
					'country',	
					'user_agent',	
					array('name' => 'visittime',
						'value' => "date('d/m/Y G:i', \$data->visittime)",
					),
				)));

}

?>


