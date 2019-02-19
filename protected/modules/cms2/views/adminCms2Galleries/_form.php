<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'cms2-galleries-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255,'class'=>'input-xxlarge')); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'desc'); ?>
		<?php echo $form->textArea($model,'desc',array('rows'=>6, 'cols'=>100,'class'=>'input-xxlarge')); ?>
		<?php echo $form->error($model,'desc'); ?>
	</div>
  
<style type="text/css">
.remove {
	position: absolute;
	bottom:5px;
	right:5px;
	display: block;
	font-size: 18px;
	font-weight: bold;
	font-family: Arial;
	color: #fff;
	text-decoration: none;
	height: 16px;
	width: 16px;
	line-height: 20px;
	overflow: hidden;
	text-align: center;
	background: url("<?php echo Yii::app()->params['rootUrl'] ?>images/cms2/design/bicos.png") no-repeat left -288px;
	text-indent: -50px;
	opacity: 0.7;
    z-index:99;
    cursor:pointer;
}
.remove:hover {
    background: url("<?php echo Yii::app()->params['rootUrl'] ?>images/cms2/design/bicos.png") no-repeat -16px -288px;
	text-decoration: none;
	opacity: 1;
}
.imageGalleryContainerCms2{
margin:5px;position:relative;
}
</style>
<script type="text/javascript">
    function removeFromGallery(id) {
       $('#imageContainer'+id).remove();
    }
	function chooseImage(id, url, name,slug) {
//		$("#juiDialog").dialog("close")
		document.getElementById('chosenImageContainer').innerHTML=document.getElementById('chosenImageContainer').innerHTML+'<span class="imageGalleryContainerCms2" id="imageContainer'+id+'">'+
                                '<img src="'+url+'" alt="'+name+'" title="'+name+'" width="100"/>'+
                                '<input type="hidden" name="Cms2Image[]" value="'+id+'" />'+
                                '<span class="remove" onclick="removeFromGallery('+id+')">-</span>'+
                            '</span>';
	}
</script>
	<div class="row">
		<div id="chosenImageContainer">
			<?php
                        foreach($model->cms2Images as $image){
                        ?>
                            <span class="imageGalleryContainerCms2" id="imageContainer<?php echo $image->id?>">
                                <img src="<?php echo Cms2Images::createSmallImageUrl($image)?>" alt="<?php echo $image->name ?>" title="<?php echo $image->name ?>" width="100"/>
                                <input type="hidden" name="Cms2Image[]" value="<?php echo $image->id?>" />
                                <span class="remove" onclick="removeFromGallery(<?php echo $image->id?>)" style="color:black">-</span>
                            </span>
                            
                        <?php
                        }
			?>
		</div>

            
 
<?php echo CHtml::ajaxLink('Choose Image',
        $this->createUrl('/cms2/adminCms2Images/getAvailableImagesForGallery'),
        array(
            'success'=>'function(r){$("#juiDialog").html(r).dialog("open"); return false;}'
        ),
        array('id'=>'showJuiDialog') // not very useful, but hey...
);?>
<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
                'id'=>'juiDialog',
                'options'=>array(
                    'title'=>'Choose Image',
                    'autoOpen'=>false,
                    'modal'=>true,
                    'width'=>'800',
                    'height'=>'600',
					'buttons'=>array('OK'=>'js:function(){$(this).dialog("close")}')
                ),
                ));
$this->endWidget();
?>
            
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->