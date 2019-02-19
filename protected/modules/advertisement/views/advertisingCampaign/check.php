<?php
$this->breadcrumbs=array(
	'Werbekampagnen'=>array(Yii::t('app', 'index')),
	'Abgelaufene Kampagnen'
);

?>

<h1><?php echo Yii::t('app','Advertising campaigns administration')?></h1>

<?php
echo '<table>';
echo '<tr><th>Firma</th><th>Kampagne</th><th>Views</th><th>Klicks</th></tr>';
foreach($campaigns as $campaign) {
	if(isset($campaign['company']))
	printf('<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>',
			$campaign['company'],
			$campaign['campaign'],
			$campaign['views'],
			$campaign['clicks']);
}

echo '</table>';
?>

