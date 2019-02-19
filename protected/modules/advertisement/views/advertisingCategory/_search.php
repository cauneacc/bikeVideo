<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
)); ?>

        <div class="row">
                <?php echo $form->label($model,'id'); ?>
                <?php echo $form->textField($model,'id'); ?>
        </div>
    
        <div class="row">
                <?php echo $form->label($model,'title'); ?>
                <?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
        </div>
    
        <div class="row">
                <?php echo $form->label($model,'text'); ?>
                <?php echo $form->textArea($model,'text',array('rows'=>6, 'cols'=>50)); ?>
        </div>
    
        <div class="row">
                <?php echo $form->label($model,'dimension'); ?>
                <?php echo $form->textField($model,'dimension',array('size'=>60,'maxlength'=>255)); ?>
        </div>
    
        <div class="row">
                <?php echo $form->label($model,'price'); ?>
                <?php echo $form->textField($model,'price'); ?>
        </div>
    
        <div class="row">
                <?php echo $form->label($model,'type'); ?>
                <?php echo CHtml::activeDropDownList($model, 'type', array(
			'PERIOD' => Yii::t('app', 'PERIOD') ,
			'SCOPE' => Yii::t('app', 'SCOPE') ,
)); ?>
        </div>
    
        <div class="row">
                <?php echo $form->label($model,'option'); ?>
                <?php echo CHtml::activeDropDownList($model, 'option', array(
			'ROTATE' => Yii::t('app', 'ROTATE') ,
			'KATEGORIE' => Yii::t('app', 'KATEGORIE') ,
)); ?>
        </div>
    
        <div class="row">
                <?php echo $form->label($model,'banner_type'); ?>
                <?php echo $form->textField($model,'banner_type'); ?>
        </div>
    
        <div class="row buttons">
                <?php echo CHtml::submitButton(Yii::t('app', 'Search')); ?>
        </div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
