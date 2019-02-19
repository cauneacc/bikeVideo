<?php
$this->breadcrumbs=array(
	'Advertising Types'=>array(Yii::t('app', 'index')),
	Yii::t('app', 'Manage'),
);
?>

<h2> Advertising Types </h2>

<?php
$locale = CLocale::getInstance(Yii::app()->language);
function displayCampaigns($data){
	$aux="";
	foreach($data->campaigns as $campaign){
		$aux=$aux.$campaign->title."<br />";
	}
	return $aux;
}
 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'advertising-type-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'title',
		'dimension',
		array('name'=>'campaign.title campaign',
			'type'=>'raw',
			'value'=>'displayCampaigns($data);'),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
