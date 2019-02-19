<?php
/*
 * CHANGE ADS
 */
$basePath = '/home/sites/agsi/protected/config/';
//$basePath = '/home/claudiu/Munca/php/agsi/protected/config/';
$handle = opendir($basePath);


if ($handle) {
	while (false !== ($entry = readdir($handle))) {
		if ($entry != '.' && $entry != '..' and is_dir($basePath . $entry) == true
				and $entry != 'sites1.bigbang-1.com' and $entry != 'sites2.bigbang-1.com' and $entry != 'agsi'  and $entry != 'global' and $entry!='original') {
			echo $entry . PHP_EOL;
			if (is_file($basePath . $entry . '/applicationDb.php')) {
				$config = require($basePath . $entry . '/applicationDb.php');
				$dbConn = mysql_connect('localhost', $config['username'], $config['password']);
				if ($dbConn) {
					if (mysql_select_db($config['username'], $dbConn)) {
//						$v=<<<'EOD'
//<script type='text/javascript'><!--//<![CDATA[
//   var m3_u = (location.protocol=='https:'?'https://openx.vmedia.tv/www/delivery/ajs.php':'http://openx.vmedia.tv/www/delivery/ajs.php');
//   var m3_r = Math.floor(Math.random()*99999999999);
//   if (!document.MAX_used) document.MAX_used = ',';
//   document.write ("<scr"+"ipt type='text/javascript' src='"+m3_u);
//   document.write ("?zoneid=23");
//   document.write ('&amp;cb=' + m3_r);
//   if (document.MAX_used != ',') document.write ("&amp;exclude=" + document.MAX_used);
//   document.write (document.charset ? '&amp;charset='+document.charset : (document.characterSet ? '&amp;charset='+document.characterSet : ''));
//   document.write ("&amp;loc=" + escape(window.location));
//   if (document.referrer) document.write ("&amp;referer=" + escape(document.referrer));
//   if (document.context) document.write ("&context=" + escape(document.context));
//   if (document.mmm_fo) document.write ("&amp;mmm_fo=1");
//   document.write ("'><\/scr"+"ipt>");
////]]>--></script><noscript><a href='http://openx.vmedia.tv/www/delivery/ck.php?n=af7f1bbc&amp;cb=INSERT_RANDOM_NUMBER_HERE' target='_blank'><img src='http://openx.vmedia.tv/www/delivery/avw.php?zoneid=23&amp;cb=INSERT_RANDOM_NUMBER_HERE&amp;n=af7f1bbc' border='0' alt='' /></a></noscript>
//EOD;
//						$sql = "update `tbl_advertising_campaign` set script='".mysql_real_escape_string($v)."' where title='Preroll300x250' ";
//						if (mysql_query($sql, $dbConn)==false) {
//							echo mysql_error($dbConn) . PHP_EOL;
//						}
						
						$sql = "delete from `tbl_advertising_campaign` where title='970x45' ";
						if (mysql_query($sql, $dbConn)==false) {
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


		}
	}
	closedir($handle);
}
?>
