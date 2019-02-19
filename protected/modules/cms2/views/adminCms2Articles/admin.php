<?php
$this->menu = array(
    array('label' => 'Create New Article', 'url' => array('create')),
);

?>

<?php


$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'cms2-articles-grid',
    'dataProvider' => $model->search(),
    'summaryText' =>false,
    'afterAjaxUpdate'=>"function() {
                           jQuery('#edit_date_grid').datepicker({'showAnim':'fold','dateFormat':'yy-mm-dd','changeMonth':'true','changeYear':'true','constrainInput':'false'});
                       
                        }",

    
    'pager' => array(
        'class' => 'CLinkPager',
        'nextPageLabel' => yii::t('core', 'Next'),
        'prevPageLabel' => yii::t('core', 'Previous'),
        'firstPageLabel' => yii::t('core', 'First'),
        'lastPageLabel' => yii::t('core', 'Last'),
        'header' => false,
    ),
    'filter' => $model,
    'columns' => array(
        array(
            'name' => 'name',
            'type' => 'raw',
            'value' => 'CHtml::link( CHtml::encode($data->name), Yii::app()->createUrl("cms2/AdminCms2Articles/view",array("id"=>$data->id)))',
            'htmlOptions' => array('id'=>'titles_column', 'style'=>'width=500px'),
        

        ),
        array(
            'name' => 'edit_date1',
            'value' => '$data->add_date',
            'htmlOptions' => array('align' => 'center'),
            'filter' => $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model' => $model,
                'attribute' => 'add_date',
                'htmlOptions' => array('id'=>'edit_date_grid'),
                'options' => array(
                    'showAnim' => 'fold',
                    'dateFormat'=>'yy-mm-dd',
                    'changeMonth' => 'true',
                    'changeYear'=>'true',
                    'constrainInput' => 'false',
                    /*'showOn' => 'button',
                    'buttonText' => false,
                    'buttonImage' => Yii::app()->request->baseUrl . '/images/calendar.png',
                    'buttonImageOnly' => true,*/
                    
                )
                    ), true),
        ),
        array('name' => 'status', 'value' => '
			$data->status?\'Enabled\':\'Disabled\'',
                        'filter' => array('0' => 'Disabled', '1' => 'Enabled'),),
        array(
            'name' => 'category_id',
            'value' => '$data->VideoCategories->name',
           
            ),
        /*
          'image_id',
         */
        array(
            'header' => 'Actions',
            'class' => 'CButtonColumn',
            'htmlOptions'=>array('width'=>'80', 'class'=>'but'),
            'viewButtonImageUrl' => Yii::app()->baseUrl . '/images/icons/' . 'search.png',
            'updateButtonImageUrl' =>Yii::app()->baseUrl . '/images/icons/' . 'edit.png',
            'deleteButtonImageUrl' => Yii::app()->baseUrl . '/images/icons/' . 'delete.png',
        ),
    ),
    
  

));

?>
