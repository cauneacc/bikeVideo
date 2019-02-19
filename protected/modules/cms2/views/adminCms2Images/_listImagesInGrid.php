

<?php
$columns = array(
    'id',
);
if (isset($fceditorChooseImages) == false) {
    $columns[] = array('header' => 'Image',
        'value' => '"<img src=\"".Cms2Images::createSmallImageUrl($data)."\" width=\"100\" onclick=\'chooseImage(\"".$data->id."\",\"".Cms2Images::createSmallImageUrl($data)."\",\"".htmlentities($data->name, ENT_QUOTES)."\",\"".$data->slug."\")\' />"',
        'type' => 'raw');
} else {
    $columns[] = array('header' => 'Image',
        'value' => '"<img src=\"".Cms2Images::createSmallImageUrl($data)."\" width=\"100\" onclick=\'select(\"".Cms2Images::createSmallImageUrl($data)."\")\' />"',
        'type' => 'raw');
    ?>
    <script type="text/javascript">
        function select(id){

            if (confirm('Select image '+id+' ?')) {
                //alert(id+'-'+preset);
                //alert (url);
                window.opener.CKEDITOR.tools.callFunction(<?php echo $_REQUEST['CKEditorFuncNum'] ?>,id);
                window.close();
            };
        }
    </script>

    <?php
}
$columns[] = 'add_date';
$columns[] = 'name';
$columns[] = 'description';
if (isset($fceditorChooseImages) == false) {
    $columns[] = array(
        'class' => 'CButtonColumn',
        'header' => 'Actions',
        'htmlOptions' => array('width' => '80', 'class' => 'but'),
            'viewButtonImageUrl' => Yii::app()->baseUrl . '/images/icons/' . 'search.png',
            'updateButtonImageUrl' => Yii::app()->baseUrl . '/images/icons/' . 'edit.png',
            'deleteButtonImageUrl' => Yii::app()->baseUrl . '/images/icons/' . 'delete.png',
        );
}

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'cms2-images-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => $columns,
    'summaryText' => false,
    'pager' => array(
        'class' => 'CLinkPager',
        'nextPageLabel' => yii::t('core', 'Next'),
        'prevPageLabel' => yii::t('core', 'Previous'),
        'firstPageLabel' => yii::t('core', 'First'),
        'lastPageLabel' => yii::t('core', 'Last'),
        'header' => false,
    ),
));
?>












