<div class="form" id="advert">
<p class="note">Fields with * are required</p>

<?php $form=$this->beginWidget('CActiveForm', array(
'id'=>'advertising-campaign-form',
	'enableAjaxValidation'=>true,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
	)); 
	echo $form->errorSummary($model);
?>

<div class="row">
<?php echo $form->labelEx($model,'title'); ?>
<?php echo $form->textField($model,'title', array('size' => 80)); ?>
<?php echo $form->error($model,'title'); ?>
</div>

<fieldset id="countries">
<legend id="country_switch"> Filter by Country </legend>
<div class="row wide flags" style="display: none;">
<?php echo $form->labelEx($model,'countries'); ?>
<?php $this->widget(
		'application.modules.advertisement.components.CountryChooser', array(
			'flagPath' => 'application.modules.advertisement.components.flags.32',
			'multiple' => true,
			'htmlOptions' => array(
				'template' => '<div style="float: left;margin: 10px;">{input}<br />{label}</div>',
				'separator' => '',
				'checkAll' => 'Select all Countries',),
			)); ?>
<?php echo $form->error($model,'countries'); ?>
<?php Yii::app()->clientScript->registerScript('countries', "
		$('#country_switch').click(function() { $('.flags').toggle(500); } ); 	
"); ?>
</div>
</fieldset>




<div class="row">
<label for="type"> Category</label>
<div class="hint"> Choose a category this advertising Campaign belongs to </div>
<?php echo $form->dropDownList($model, 'category', 
		CHtml::listData(AdvertisingCategory::model()->findAll(), 'id', 'title')); ?>

<div class="row">
<?php
echo $form->labelEx($model,'start_time'); 
$this->widget('zii.widgets.jui.CJuiDatePicker', array(
    'name'=>'AdvertisingCampaign[start_time]',
		'value' => date('m/d/Y', $model->start_time),
    'options'=>array( 'showAnim'=>'fold',
		'constrainInput' => true,
		'minDate' => '+7',
),
));
?>

<?php echo $form->error($model,'end_time'); ?>
</div>

<div class="row">
<?php
echo $form->labelEx($model,'end_time'); 
$this->widget('zii.widgets.jui.CJuiDatePicker', array(
			'name'=>'AdvertisingCampaign[end_time]',
			'value' => date('m/d/Y', $model->end_time),
			'options'=>array( 'showAnim'=>'fold',
				'constrainInput' => true,
				'minDate' => '+7',
				),
			));
?>

<?php echo $form->error($model,'end_time'); ?>
</div>

<div class="row">
<?php echo $form->labelEx($model,'positions'); ?>
<div class="hint"> Enter all positions where advertisements of this type should be shown.
Leave it empty to show it in all positions of the Website. <br />
Example: index, detailview <br /> </div>
<?php
echo $form->dropdownList($model, 'positions', AdvertisingCampaign::getPositions()); ?>
<?php echo $form->error($model,'positions'); ?>
</div>

<div class="row">
<?php echo $form->labelEx($model,'dimension'); ?>
<div class="hint">
After how many views should this Advertising Campaign automatically be set to suspend? Leave empty to disable this feature
</div>
<?php echo $form->textField($model,'dimension',array('size'=>60,'maxlength'=>255)); ?>
<?php echo $form->error($model,'dimension'); ?>
</div>

<div class="row">
<?php echo $form->labelEx($model,'priority'); ?>
<?php $priorities = array();
for($i = 1; $i <= 5; $i++)
	$priorities[$i] = $i; ?>
<?php echo CHtml::activeDropDownList($model, 'priority', $priorities); ?>
<?php echo $form->error($model,'priority'); ?>
</div>


<div class="row">
<?php echo $form->labelEx($model,'sponsor_id'); ?>
<div class="hint"> Enter the sponsor for this advertisement. </div>
<?php

echo $form->dropdownList($model, 'sponsor_id', CHtml::listData(AdvertisingSponsor::model()->findAll(),'id','name')); ?>

<?php echo $form->error($model,'sponsor_id'); ?>
</div>

<div class="row">
<?php echo $form->labelEx($model,'tags'); ?>
<div class="hint"> Enter one or more Tags for this advertisement, separated by comma. </div>
<?php echo $form->textField($model,'tags', array('size' => 80)); ?>
<?php echo $form->error($model,'tags'); ?>
</div>

<div class="row">
<?php echo $form->labelEx($model,'status'); ?>
<?php echo $form->dropDownList($model,'status', array(
-1 => 'Suspended',
0 => 'Inactive',
1 => 'Active',
)); ?>
<?php echo $form->error($model,'status'); ?>
</div>

<div class="row">
<div class="row">
<?php echo $form->label($model,'mode'); ?>
<?php echo $form->dropDownList($model,'mode',array(
'text' => 'Text',
'script' => 'Script',
'dhtml' => 'DHtml',
'image' => 'Image'));
?>
</div>

<div class="options_image" style="display: none;height:200px;">
<div class="row">
<?php echo $form->label($model,'url_picture'); ?>
<?php echo $form->fileField($model,'url_picture',array('size'=>60,'maxlength'=>255)); ?>
</div>

<div class="row"> 
<?php echo $form->labelEx($model,'url_link'); ?>
<?php echo $form->textField($model,'url_link',array('size'=>60,'maxlength'=>255)); ?>
<?php echo $form->error($model,'url_link'); ?>
</div>
</div>

<div class="options_script" style="display: none;">
<div class="row">
<?php echo $form->label($model,'script'); ?>
<?php echo $form->textArea($model,'script',array('rows'=>10,'cols'=>60)); ?>
</div>
</div>

<div class="options_text" style="display: none;">

<div class="row">
<?php echo CHtml::label('Title', 'AdvertisingCampaign[text][title]'); ?>
<?php echo CHtml::textField('AdvertisingCampaign[text][title]',
		$model->text['title']); ?>
</div>

<div class="row">
<?php echo CHtml::label('Url Input', 'AdvertisingCampaign[text][url_input]'); ?>
<?php echo CHtml::textField('AdvertisingCampaign[text][url_input]', $model->text['url_input']); ?>
</div>

<div class="row">
<?php echo CHtml::label('Line 1', 'AdvertisingCampaign[text][line1]'); ?>
<?php echo CHtml::textField('AdvertisingCampaign[text][line1]',
		$model->text['line1']); ?>
</div>

<div class="row">
<?php echo CHtml::label('Line 2', 'AdvertisingCampaign[text][line2]'); ?>
<?php echo CHtml::textField('AdvertisingCampaign[text][line2]',
		$model->text['line2']); ?>
</div>

<div class="row">
<?php echo CHtml::label('Line 3', 'AdvertisingCampaign[text][line3]'); ?>
<?php echo CHtml::textField('AdvertisingCampaign[text][line3]',
		$model->text['line3']); ?>
</div>
<div class="row">
<?php echo CHtml::label('Visible Url', 'AdvertisingCampaign[text][visibleUrl]'); ?>
<?php echo CHtml::textField('AdvertisingCampaign[text][visibleUrl]',
		$model->text['visibleUrl']); ?>
</div>






</div>


<br />
<?php
echo CHtml::Button(Yii::t('app', 'Cancel'), array(
			'submit' => array('admin'))); 
echo CHtml::submitButton(Yii::t('app', 'Save')); 

$this->endWidget(); ?>
</div> <!-- form -->


<?php
Yii::app()->clientScript->registerScript('choose_mode', "
	if($('#AdvertisingCampaign_mode').val() == 'text') 
		$('.options_text').show();
	if($('#AdvertisingCampaign_mode').val() == 'script') 
		$('.options_script').show();
	if($('#AdvertisingCampaign_mode').val() == 'image') 
		$('.options_image').show();
	if($('#AdvertisingCampaign_mode').val() == 'dhtml') 
		$('.options_script').show();


	$('#AdvertisingCampaign_mode').change(function() {
	$('.options_script').hide(500);
	$('.options_text').hide(500);
	$('.options_image').hide(500);
	if($(this).val() == 'text') 
		$('.options_text').show(500);
	if($(this).val() == 'script' || $(this).val() == 'dhtml') 
		$('.options_script').show(500);
	if($(this).val() == 'image') 
		$('.options_image').show(500);
});
");
