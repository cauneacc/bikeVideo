<div class="form">
<p class="note">
<?php echo Yii::t('app','Fields with');?> <span class="required">*</span> <?php echo Yii::t('app','are required');?>.
</p>

<?php $form=$this->beginWidget('CActiveForm', array(
'id'=>'advertising-sponsor-form',
	'enableAjaxValidation'=>true,
	)); 
	echo $form->errorSummary($model);
?>
	<div class="row">
<?php echo $form->labelEx($model,'name'); ?>
<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
<?php echo $form->error($model,'name'); ?>
</div>

<div class="row">
<?php echo $form->labelEx($model,'priority'); ?>
<?php echo $form->dropdownList($model,'priority',array(1=>1,2=>2,3=>3,4=>4,5=>5)) ?>
<?php echo $form->error($model,'priority'); ?>
</div>

<div class="row">
<?php echo $form->labelEx($model,'percent'); ?>
<?php echo $form->textField($model,'percent',array('size'=>6,'maxlength'=>2)); ?>
<?php echo $form->error($model,'percent'); ?>
</div>

<?php
echo CHtml::Button(Yii::t('app', 'Cancel'), array(
			'submit' => array('//advertisement/sponsor/index')));
echo CHtml::submitButton(Yii::t('app', 'Save')); 
$this->endWidget(); ?>
</div> <!-- form -->
