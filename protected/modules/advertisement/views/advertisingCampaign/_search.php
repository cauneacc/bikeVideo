<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
)); ?>

        <div class="row">
                <?php echo $form->label($model,'company_id'); ?>
                <?php echo $form->textField($model,'company_id'); ?>
        </div>
    
        <div class="row">
                <?php echo $form->label($model,'createtime'); ?>
                <?php echo $form->textField($model,'createtime'); ?>
        </div>
    
        <div class="row">
                <?php echo $form->label($model,'updatetime'); ?>
                <?php echo $form->textField($model,'updatetime'); ?>
        </div>
    
        <div class="row">
                <?php echo $form->label($model,'start_time'); ?>
                <?php echo $form->textField($model,'start_time'); ?>
        </div>
    
        <div class="row">
                <?php echo $form->label($model,'end_time'); ?>
                <?php echo $form->textField($model,'end_time'); ?>
        </div>
    
        <div class="row">
                <?php echo $form->label($model,'id'); ?>
                <?php echo $form->textField($model,'id'); ?>
        </div>
    
        <div class="row">
                <?php echo $form->label($model,'status'); ?>
                <?php echo $form->checkBox($model,'status'); ?>
        </div>
    
        <div class="row">
                <?php echo $form->label($model,'target_url'); ?>
                <?php echo CHtml::activeDropDownList($model, 'target_url', array(
			'INTERNAL' => Yii::t('app', 'INTERNAL') ,
			'EXTERNAL' => Yii::t('app', 'EXTERNAL') ,
)); ?>
        </div>
    
        <div class="row">
                <?php echo $form->label($model,'target_modul'); ?>
                <?php echo CHtml::activeDropDownList($model, 'target_modul', array(
			'BLOG' => Yii::t('app', 'BLOG') ,
			'NEWS' => Yii::t('app', 'NEWS') ,
			'FORUM' => Yii::t('app', 'FORUM') ,
			'PRESS' => Yii::t('app', 'PRESS') ,
)); ?>
        </div>
    
        <div class="row">
                <?php echo $form->label($model,'target_category'); ?>
                <?php echo $form->textField($model,'target_category'); ?>
        </div>
    
        <div class="row">
                <?php echo $form->label($model,'url_picture'); ?>
                <?php echo $form->textField($model,'url_picture',array('size'=>60,'maxlength'=>255)); ?>
        </div>
    
        <div class="row">
                <?php echo $form->label($model,'url_link'); ?>
                <?php echo $form->textField($model,'url_link',array('size'=>60,'maxlength'=>255)); ?>
        </div>
    
        <div class="row">
                <?php echo $form->label($model,'accept_agb'); ?>
                <?php echo $form->checkBox($model,'accept_agb'); ?>
        </div>
    
        <div class="row">
                <?php echo $form->label($model,'payment_date'); ?>
                <?php echo $form->textField($model,'payment_date'); ?>
        </div>
    
        <div class="row">
                <?php echo $form->label($model,'payment_type'); ?>
                <?php echo CHtml::activeDropDownList($model, 'payment_type', array(
			'PREPAYMENT' => Yii::t('app', 'PREPAYMENT') ,
			'PAYPAL' => Yii::t('app', 'PAYPAL') ,
)); ?>
        </div>
    
        <div class="row">
                <?php echo $form->label($model,'advertising_type'); ?>
                <?php echo $form->textField($model,'advertising_type'); ?>
        </div>
    
        <div class="row buttons">
                <?php echo CHtml::submitButton(Yii::t('app', 'Search')); ?>
        </div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
