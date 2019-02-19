<?php
foreach($countries as $key => $value)
	$countries[$key] = sprintf('%s', $value);


	if($multiple) {
		$this->widget(
				'application.modules.advertisement.components.EMultiSelect',
				array('sortable'=>true, 'searchable'=>true)
				);

		$htmlOptions = array_merge($htmlOptions, array(
					'multiple' => 'multiple',
					'class' => 'multiselect',
					'key' => 'countries',
					));

		echo CHtml::dropDownList($field, $value, $countries, $htmlOptions);
	}
else
echo CHtml::radioButtonList($field, $value, $countries, $htmlOptions);
?>

<div id="flag">TEST</div>
