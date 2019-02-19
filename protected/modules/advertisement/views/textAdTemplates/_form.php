<div class="form" id="advert">
	<p class="note">
		<?php echo Yii::t('app','Fields with * are required')?>
	</p>

	<?php
	$form=$this->beginWidget('CActiveForm', array(
			'id'=>'advertising-template-form',
			'enableAjaxValidation'=>true,
			'htmlOptions'=>array('enctype'=>'multipart/form-data'),
		));
	echo $form->errorSummary($model);
	?>

	<div class="row">
		<?php echo $form->labelEx($model, 'name'); ?>
		<?php echo $form->textField($model, 'name', array('size'=>80)); ?>
		<?php echo $form->error($model, 'name'); ?>
	</div>
	<div class="row">
		<?php echo $form->label($model, 'template'); ?>
		<?php echo Yii::t('app','Note: The template must contain the tags {title} , {line1} , {line2} , {line3} , {visibleUrl} .')?>
		<?php echo $form->textArea($model, 'template', array('rows'=>15, 'cols'=>80)); ?>
	</div>
	<div class="row">
		<?php echo $form->label($model, 'css'); ?>
		<?php echo $form->textArea($model, 'css', array('rows'=>15, 'cols'=>80)); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'position_id'); ?>
		<?php echo $form->dropdownList($model, 'position_id', CHtml::listData(Position::model()->findAll(),'id','title')); ?>
		<?php echo $form->error($model,'position_id'); ?>
	</div>

	<br />
	<?php
		echo CHtml::Button(Yii::t('app', 'Cancel'), array(
			'submit'=>array('index')));
		echo '&nbsp;';
		echo CHtml::submitButton(Yii::t('app', 'Save'));

		$this->endWidget();
	?>
</div> <!-- form -->


