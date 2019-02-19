<?php

$basePath = '/home/sites/agsi/protected/config/';
$handle = opendir($basePath);


if ($handle) {
	while (false !== ($entry = readdir($handle))) {
		if ($entry != '.' && $entry != '..' and $entry != '.maildir' and is_dir($basePath . $entry) == true
				and $entry != 'sites1.bigbang-1.com' and $entry != 'global' and $entry != 'original' and $entry != 'agsi') {
			echo $entry . PHP_EOL;
			if (is_file($basePath . $entry . '/applicationDb.php')) {
				$config = require($basePath . $entry . '/applicationDb.php');
				$dbConn = mysql_connect('localhost', $config['username'], $config['password']);
				if ($dbConn) {
					if (mysql_select_db($config['username'], $dbConn)) {
						$sql = "delete from `tbl_position` ";
						if (mysql_query($sql, $dbConn)) {
							$sql = "INSERT INTO `tbl_position` (`title`, `id`) VALUES
('Preroll300x250', 28),
('test', 27),
('640x100', 26),
('Disclaimer', 21),
('Infopop', 22),
('120x600', 23),
('970x45', 24),
('300x250', 25),
('728x90', 29),
('250x250', 30),
('Catcheur980x225', 31),
('mosaique2_300x250', 32),
('mosaique3_footer', 33),
('mosaique3_300x250', 34),
('bannieretop_reseau', 35),
('mosaique4_footer', 36);";
							if (mysql_query($sql, $dbConn)) {
								echo 'success' . PHP_EOL;
							} else {
								echo mysql_error($dbConn) . PHP_EOL;
							}
						} else {
							echo mysql_error($dbConn) . PHP_EOL;
						}
					} else {
						echo mysql_error($dbConn) . PHP_EOL;
					}

					mysql_close($dbConn);
				} else {
					echo mysql_error($dbConn) . PHP_EOL;
				}
			} else {
				echo 'could not find file "' . $basePath . $entry . '/applicationDb.php' . '"' . PHP_EOL;
			}




//			$text=file_get_contents($basePath.$entry.'/params.php');
//			$text=str_replace(array('{','}','Otso tzar gaiztoak biharamonean sagarretara joateko proposatzen dio orduan, baina bezperan bezala, txerritxoak aurrea hartu, sagarrondora igo eta sagarrak hartuta jeisten denean, otso tzar gaiztoarekin topo egiten du. Txerritxoak sagar bat urrutira jaurtitzen du eta otsoa atzetik abiatzen da, txerritxoari etxera ihes egiteko beta emanez.'), array('$','','Daginstitutioner, skoler, fritidshjem, klubber, plejehjem, sociale institutioner, handicapcentre, administrationsejendomme, kulturhuse, museer, biblioteker, idratsanlag, brandstationer, tekniske bygninger mm.'), $text);
//			file_put_contents($basePath.$entry.'/params.php',$text);
		}
	}
	closedir($handle);
}
?>
