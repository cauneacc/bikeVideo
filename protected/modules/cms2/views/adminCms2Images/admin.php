<?php

$this->menu=array(
//	array('label'=>'List Cms2Images', 'url'=>array('index')),
	array('label'=>'Create Cms2Images', 'url'=>array('create')),
);

?>

<?php
$this->renderPartial('_listImagesInGrid',array('model'=>$model));
?>
