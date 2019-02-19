<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'cms2-articles-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>200,'maxlength'=>255,'class'=>'input-xxlarge')); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'desc'); ?>
		<?php

$this->widget('ext.ckeditor.CKEditorWidget',array(
  "model"=>$model,                 # Data-Model
  "attribute"=>'desc',          # Attribute in the Data-Model
  "defaultValue"=>$model->desc,     # Optional

  # Additional Parameter (Check http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.config.html)
  "config" => array(
      "height"=>"400px",
      "width"=>"100%",
      "toolbar"=>"Full",
	'filebrowserBrowseUrl'=>Yii::app()->createAbsoluteUrl('/cms2/adminCms2Images/getAvailableImages'),
      ),

  #Optional address settings if you did not copy ckeditor on application root
  "ckEditor"=>Yii::app()->basePath."/../ckeditor/ckeditor.php",
                                  # Path to ckeditor.php
  "ckBasePath"=>Yii::app()->baseUrl."/ckeditor/",
                                  # Realtive Path to the Editor (from Web-Root)
  ) );

		?>
		<?php echo $form->error($model,'desc'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'tease'); ?>
		<?php echo $form->textArea($model,'tease',array('class'=>'input-xxlarge','cols'=>200,'rows'=>7)); ?>
		<?php echo $form->error($model,'tease'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->checkBox($model,'status');
		?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'category_id'); ?>
		<?php
		echo $form->dropdownList($model,'category_id',CHtml::listData($categories, 'cat_id', 'name')); ?>
		<?php echo $form->error($model,'category_id'); ?>
	</div>
	<div class="row">
<script type="text/javascript">
	function chooseImage(id, url, name,slug) {
//		$("#juiDialog").dialog("close")
		document.getElementById('chosenImageContainer').innerHTML='<img src="'+url+'" alt="'+name+'" title="'+name+'" width="100"/>'+
                                '<input type="hidden" name="Cms2Articles[image_slug]" value="'+slug+'" />'
                            '</span>';
	}
</script>

		<div id="chosenImageContainer">
			<?php
			if($model->image_slug){
				?>
				<img src='<?php echo Cms2Images::createSmallImageUrl($model->Cms2Images)?>' alt='<?php echo $model->Cms2Images->name?>' />
				<input type='hidden' name='Cms2Articles[image_slug]' value='<?php echo $model->Cms2Images->slug?>' />
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

		
		
		<?php
		/*
		$this->beginWidget('zii.widgets.jui.CJuiDialog'
				, array('id'=>'chooseImages',
					'options'=>array(
					'title'=>'Choose Image in articol'
					, 'modal'=>true
					,'autoOpen'=>false,
				'width'=>600,
				'height'=>400

					, 'buttons'=>array('OK'=>'js:function(){$(this).dialog("close")}')
					))
		);
		 * 
		 */
		?>
		<!--
		<div id="chooseImagesContainer">
			<?php 
			/*
			$this->widget('zii.widgets.CListView', array(
				'dataProvider'=>$images,
				'itemView'=>'_chooseImages',
				'ajaxUrl'=>Yii::app()->createUrl('//cms2/AdminCms2Images/getAvailableImagesForArticle')
			)); 
			 * 
			 */
			?>
		</div>
  -->
		<?php
		/*
		$this->endWidget('zii.widgets.jui.CJuiDialog');

		echo CHtml::link('choose image', '#', array(
			'onclick'=>'$("#chooseImages").dialog("open"); return false;',
		));
		 * 
		 */
		?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'gallery_id'); ?>
		<?php
		echo $form->dropdownList($model,'gallery_id',CHtml::listData(Cms2Galleries::model()->findAll(), 'id', 'name'), array('prompt'=>'Select a gallery if you wish:')); ?>
		<?php echo $form->error($model,'gallery_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->