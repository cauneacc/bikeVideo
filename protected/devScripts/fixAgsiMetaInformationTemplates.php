<?php

$basePath = '/home/sites/agsi/protected/config/';
$handle = opendir($basePath);

$new_charset = 'utf8';
$new_collation = 'utf8_general_ci'; 

if ($handle) {
	while (false !== ($entry = readdir($handle))) {
		if ($entry != '.' && $entry != '..' and $entry != '.maildir' and is_dir($basePath . $entry) == true and $entry != 'sites1.bigbang-1.com' and $entry != 'sites2.bigbang-1.com') {
echo $entry.PHP_EOL;
			$config = require($basePath . $entry . '/applicationDb.php');
			$dbConn = mysql_connect('localhost', $config['username'], $config['password']);
			if ($dbConn) {
				if (mysql_select_db($config['username'], $dbConn)) {
					$sql = 'ALTER DATABASE ' . $config['username'] . ' DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci';
					if (mysql_query($sql, $dbConn)) {
						$result = mysql_query('show tables');
						while ($tables = mysql_fetch_array($result)) {
							$table = $tables[0];
							if($table=='tbl_action' or
$table=='tbl_advertising_campaign' or
$table=='tbl_advertising_category' or
$table=='tbl_advertising_type' or
$table=='tbl_banner_type' or
$table=='tbl_payment' or
$table=='tbl_position' or
$table=='tbl_user_has_usergroup' or
$table=='tbl_user_visit' or
$table=='tbl_yumtextsettings'
									){
								mysql_query("ALTER TABLE $table ENGINE = myisam");

							}
							mysql_query("ALTER TABLE $table DEFAULT CHARACTER SET $new_charset COLLATE $new_collation");
// loop through each column changing collation
							$columns = mysql_query("SHOW FULL COLUMNS FROM $table where collation is not null");
							while ($cols = mysql_fetch_array($columns)) {
								$column = $cols[0];
								$type = $cols[1];
								mysql_query("ALTER TABLE $table MODIFY $column $type CHARACTER SET $new_charset COLLATE $new_collation");
							}
						}
						if(mysql_query('DROP TABLE IF EXISTS `tbl_quicklists`')==false){
							echo mysql_error() . PHP_EOL;
						}
						if(mysql_query('DROP TABLE IF EXISTS `tbl_configuration`')==false){
							echo mysql_error() . PHP_EOL;
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




//			$text=file_get_contents($basePath.$entry.'/params.php');
//			$text=str_replace(array('{','}','Otso tzar gaiztoak biharamonean sagarretara joateko proposatzen dio orduan, baina bezperan bezala, txerritxoak aurrea hartu, sagarrondora igo eta sagarrak hartuta jeisten denean, otso tzar gaiztoarekin topo egiten du. Txerritxoak sagar bat urrutira jaurtitzen du eta otsoa atzetik abiatzen da, txerritxoari etxera ihes egiteko beta emanez.'), array('$','','Daginstitutioner, skoler, fritidshjem, klubber, plejehjem, sociale institutioner, handicapcentre, administrationsejendomme, kulturhuse, museer, biblioteker, idratsanlag, brandstationer, tekniske bygninger mm.'), $text);
//			file_put_contents($basePath.$entry.'/params.php',$text);
		}
	}
	closedir($handle);
}
?>
