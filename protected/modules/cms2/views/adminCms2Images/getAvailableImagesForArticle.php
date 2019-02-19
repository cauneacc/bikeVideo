<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'/adminCms2Articles/_chooseImages',
	'ajaxUrl'=>Yii::app()->createUrl('//cms2/AdminCms2Images/getAvailableImagesForArticle')
)); ?>
