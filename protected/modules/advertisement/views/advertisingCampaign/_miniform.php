<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'advertising-campaign-form',
	'enableAjaxValidation'=>true,
)); 
	echo $form->errorSummary($model);
?>
<div class="row">
<?php echo $form->labelEx($model,'company_id'); ?>
<?php echo $form->textField($model,'company_id'); ?>
<?php echo $form->error($model,'company_id'); ?>
</div>

<div class="row">
<?php echo $form->labelEx($model,'advertising_id'); ?>
<?php echo $form->textField($model,'advertising_id'); ?>
<?php echo $form->error($model,'advertising_id'); ?>
</div>

<div class="row">
<?php echo $form->labelEx($model,'createtime'); ?>
<?php echo $form->textField($model,'createtime'); ?>
<?php echo $form->error($model,'createtime'); ?>
</div>

<div class="row">
<?php echo $form->labelEx($model,'updatetime'); ?>
<?php echo $form->textField($model,'updatetime'); ?>
<?php echo $form->error($model,'updatetime'); ?>
</div>

<div class="row">
<?php echo $form->labelEx($model,'start_time'); ?>
<?php echo $form->textField($model,'start_time'); ?>
<?php echo $form->error($model,'start_time'); ?>
</div>

<div class="row">
<?php echo $form->labelEx($model,'end_time'); ?>
<?php echo $form->textField($model,'end_time'); ?>
<?php echo $form->error($model,'end_time'); ?>
</div>

<div class="row">
<?php echo $form->labelEx($model,'status'); ?>
<?php echo $form->checkBox($model,'status'); ?>
<?php echo $form->error($model,'status'); ?>
</div>

<div class="row">
<?php echo $form->labelEx($model,'target_url'); ?>
<?php echo CHtml::activeDropDownList($model, 'target_url', array(
			'INTERNAL' => Yii::t('app', 'INTERNAL') ,
			'EXTERNAL' => Yii::t('app', 'EXTERNAL') ,
)); ?>
<?php echo $form->error($model,'target_url'); ?>
</div>

<div class="row">
<?php echo $form->labelEx($model,'target_modul'); ?>
<?php echo CHtml::activeDropDownList($model, 'target_modul', array(
			'BLOG' => Yii::t('app', 'BLOG') ,
			'NEWS' => Yii::t('app', 'NEWS') ,
			'FORUM' => Yii::t('app', 'FORUM') ,
			'PRESS' => Yii::t('app', 'PRESS') ,
)); ?>
<?php echo $form->error($model,'target_modul'); ?>
</div>

<div class="row">
<?php echo $form->labelEx($model,'target_category'); ?>
<?php echo $form->textField($model,'target_category'); ?>
<?php echo $form->error($model,'target_category'); ?>
</div>

<div class="row">
<?php echo $form->labelEx($model,'url_picture'); ?>
<?php echo $form->textField($model,'url_picture',array('size'=>60,'maxlength'=>255)); ?>
<?php echo $form->error($model,'url_picture'); ?>
</div>

<div class="row">
<?php echo $form->labelEx($model,'url_link'); ?>
<?php echo $form->textField($model,'url_link',array('size'=>60,'maxlength'=>255)); ?>
<?php echo $form->error($model,'url_link'); ?>
</div>

<div class="row">
<?php echo $form->labelEx($model,'accept_agb'); ?>
<?php echo $form->checkBox($model,'accept_agb'); ?>
<?php echo $form->error($model,'accept_agb'); ?>
</div>

<div class="row">
<?php echo $form->labelEx($model,'payment_date'); ?>
<?php echo $form->textField($model,'payment_date'); ?>
<?php echo $form->error($model,'payment_date'); ?>
</div>

<div class="row">
<?php echo $form->labelEx($model,'payment_type'); ?>
<?php echo CHtml::activeDropDownList($model, 'payment_type', array(
			'PREPAYMENT' => Yii::t('app', 'PREPAYMENT') ,
			'PAYPAL' => Yii::t('app', 'PAYPAL') ,
)); ?>
<?php echo $form->error($model,'payment_type'); ?>
</div>

<div class="row">
<?php echo $form->labelEx($model,'advertising_type'); ?>
<?php echo $form->textField($model,'advertising_type'); ?>
<?php echo $form->error($model,'advertising_type'); ?>
</div>


<?php
echo CHtml::Button(
	Yii::t('app', 'Cancel'),
	array(
		'onClick' => "$('#".$relation."_dialog').dialog('close');"
	));
echo CHtml::Button(
	Yii::t('app', 'Create'),
	array(
		'id' => "submit_".$relation
	));
$this->endWidget(); 

?></div> <!-- form -->
