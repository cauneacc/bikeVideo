<?php
$form = $this->beginWidget('CActiveForm', array(
			'id'=>'advertising-campaign-form',
			'enableAjaxValidation'=>true,
			)); 

$form->errorSummary($model);
?>

<div class="image_preview">
<?php echo $model->getImage(); ?>
</div>
<div class="row">
<?php
echo CHtml::activeLabelEx($model, 'status');
echo CHtml::activeDropDownList($model, 'status', array(
			'0' => 'Inactive',
			'1' => 'Active',));

?>
</div>

<div class="row">
<?php 
if($model->payment_date == 0) {
	echo $form->hiddenField($model, 'payment_date', array('value' => time()));
echo CHtml::button('Cancel', array('submit' => array('admin'))). '<br />'; 
echo CHtml::submitButton('Confirm Payment for NOW'); 
} else {
echo '<label> Ad runs from</label>';

$this->widget('zii.widgets.jui.CJuiDatePicker', array(
				'name'=>'AdvertisingCampaign[start_time]',
				'value' => date('d.m.Y',$model->start_time),
				'language' => 'de',
				'options'=>array('showAnim'=>'fold',
					),
				)); 

echo '<label> Ad runs until </label>';

$this->widget('zii.widgets.jui.CJuiDatePicker', array(
				'name'=>'AdvertisingCampaign[end_time]',
				'value' => date('d.m.Y',$model->end_time),
				'language' => 'de',
				'options'=>array('showAnim'=>'fold',
					),
				)); 

	echo '<br />Payed at: '.date('d. m. Y', $model->payment_date). '<br />';
echo CHtml::button('Cancel', array('submit' => array('admin'))); 
echo CHtml::submitButton('Save Campaign'); 
}
?>
</div>
<?php $this->endWidget(); ?>


