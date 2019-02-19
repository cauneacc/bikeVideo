
<h1>View Cms2Articles #<?php echo $model->id; ?></h1>
<hr>
<h2><?php echo $model->name?></h2>
<div><?php echo $model->desc?></div>
<hr>

<?php 
$statusText='';
if($model->status==1){
	$statusText='enabled';
}else{
	$statusText='disabled';
}
if($model->image_slug!=''){
	$aux=new stdClass();
	$aux->slug=$model->image_slug;
	$image='<img src="'.Cms2Images::createSmallImageUrl($aux).'" />';
}else{
	$image='';
}
$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'add_date',
		array('label'=>'Status','value'=>$statusText),
		array('label'=>'Category','value'=>$model->VideoCategories->name),
		array('label'=>'Gallery','value'=>$model->Cms2Galleries->name),
		array('label'=>'Image',
			'type'=>'raw',
			'value'=>$image),
	),
)); ?>
