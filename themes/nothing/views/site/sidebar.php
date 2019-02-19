<?php

Yii::app()->controller->renderPartial('//site/login'); 
	Yii::app()->controller->renderPartial('//site/categories', array(
	'videoCategories' => array(),
	//'photoCategories' => Photo::getCategories(),
	));
Yii::app()->controller->renderPartial('//site/tagcloud'); 

