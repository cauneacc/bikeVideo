<?php 

$params = "project=mnsrvc&title={$title}&amount={$amount}&paytext={$paytext}&theme=|1&account=22238&bgcolor=ffffff&theme=default";

$accessKey = 'ae6c440b9ca390d12bc24d927d1c9bb7';

$seal = md5($params . $accessKey);    

printf('<iframe src="http://billing.micropayment.de/%s/event/?project=%s&title=%s&amount=%d&paytext=%s&theme=|1&account=22238&bgcolor=ffffff&theme=default&seal=%s" width="608" height="550" style=" overflow:hidden; border:none;">
		<p> Ihr Browser unterstützt keine Iframes.</p>
		</iframe>',
		$prefix,
		$project,
		$title,
		$amount,
		$paytext,
		$seal);

?>
