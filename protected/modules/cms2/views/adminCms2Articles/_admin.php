

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'cms2-articles-grid',
    'dataProvider' => $model->search(),
    'summaryText' => false,
    'htmlOptions'=>array('style'=>'width:500'),

    'pager' => array(
        'class' => 'CLinkPager',
        'nextPageLabel' => yii::t('core', 'Next'),
        'prevPageLabel' => yii::t('core', 'Previous'),
        'firstPageLabel' => yii::t('core', 'First'),
        'lastPageLabel' => yii::t('core', 'Last'),
        'header' => yii::t('core', 'Go to') . ': ',
    ),
    'filter' => $model,
    'columns' => array(
        'id',
        'name',
        'add_date',
        array('name' => 'status', 'value' => '
			$data->status?\'Enabled\':\'Disabled\'',
            'filter' => array('0' => 'Disabled', '1' => 'Enabled'),),
        array('name' => 'category_id', 'value' => '$data->VideoCategories->name'),
        /*
          'image_id',
         */
        array(
            'header' => 'Actions',
            'class' => 'CButtonColumn',
            'htmlOptions' => array('width' => '80', 'class' => 'but'),
            'viewButtonImageUrl' => Yii::app()->baseUrl . '/images/icons/' . 'search.png',
            'updateButtonImageUrl' => Yii::app()->baseUrl . '/images/icons/' . 'edit.png',
            'deleteButtonImageUrl' => Yii::app()->baseUrl . '/images/icons/' . 'delete.png',
        ),
    ),
));
?>

