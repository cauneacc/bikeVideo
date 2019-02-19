<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'advertising-type-form',
	'enableAjaxValidation'=>true,
)); 
	echo $form->errorSummary($model);
?>
<div class="row">
<?php echo $form->labelEx($model,'title'); ?>
<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
<?php echo $form->error($model,'title'); ?>
</div>

<div class="row">
<?php echo $form->labelEx($model,'text'); ?>
<?php echo $form->textArea($model,'text',array('rows'=>6, 'cols'=>50)); ?>
<?php echo $form->error($model,'text'); ?>
</div>

<div class="row">
<?php echo $form->labelEx($model,'dimension'); ?>
<?php echo $form->textField($model,'dimension',array('size'=>60,'maxlength'=>255)); ?>
<?php echo $form->error($model,'dimension'); ?>
</div>

<div class="row">
<?php echo $form->labelEx($model,'price'); ?>
<?php echo $form->textField($model,'price'); ?>
<?php echo $form->error($model,'price'); ?>
</div>

<div class="row">
<?php echo $form->labelEx($model,'type'); ?>
<?php echo CHtml::activeDropDownList($model, 'type', array(
			'PERIOD' => Yii::t('app', 'PERIOD') ,
			'SCOPE' => Yii::t('app', 'SCOPE') ,
)); ?>
<?php echo $form->error($model,'type'); ?>
</div>

<div class="row">
<?php echo $form->labelEx($model,'option'); ?>
<?php echo CHtml::activeDropDownList($model, 'option', array(
			'ROTATE' => Yii::t('app', 'ROTATE') ,
			'KATEGORIE' => Yii::t('app', 'KATEGORIE') ,
)); ?>
<?php echo $form->error($model,'option'); ?>
</div>

<div class="row">
<?php echo $form->labelEx($model,'banner_type'); ?>
<?php echo $form->textField($model,'banner_type'); ?>
<?php echo $form->error($model,'banner_type'); ?>
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
