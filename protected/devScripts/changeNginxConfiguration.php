<?php
/**
 * SCRIPTUL DOAR AFISEAZA CE FISIERE DE CONFIGURATIE NU CONTINE CUVANTUL sitemap
 */
//$baseDir = '/home/claudiu/Munca/php/agsi/protected/config/';
$baseDir = '/etc/nginx/sites/';
$handle = opendir($baseDir);
if ($handle) {
	while (false !== ($entry = readdir($handle))) {
		if ($entry != '.' && $entry != '..' and is_file($baseDir . $entry)) {

			
			$text = file_get_contents($baseDir . $entry);
			if ($text) {
				if (strpos($text, 'sitemap') === false) {
					echo $entry.' nu am gasit' . PHP_EOL;
					$search = '		#avoid processing of calls to unexisting static files by yii
		location ~ \.(js|css|png|jpg|gif|swf|ico|pdf|mov|fla|zip|rar|txt)$ {
			try_files $uri =404;
		}
';
					$replace = '    #avoid processing of calls to unexisting static files by yii
    location ~ \.(js|css|png|jpg|gif|swf|ico|pdf|mov|fla|zip|rar|txt)$ {
        try_files $uri =404;
    }
	#redirect requests for sitemap files
	location ~ (sitemap|videoSitemap)[0-9]*\.(xml|xml\.gz)$ {
		root /home/sites/agsi/sitemaps/' . $entry . ';
		try_files $uri =404;
	}
';

//					$text = str_replace($search, $replace, $text);
//					if (file_put_contents($baseDir . $entry, $text) == false) {
//						echo 'nu am reusit sa scriu fisierul ' . $baseDir . $entry . '/main.php' . PHP_EOL;
//					}
				} else {
					$search = '	#redirect requests for sitemap files
	location ~ (sitemap|videoSitemap)[0-9]*\.(xml|xml\.gz)$ {
		root /home/sites/agsi/sitemaps/jeunette-porno-xxx.com;
		try_files $uri =404;
	}
	#redirect requests for sitemap files
	location ~ (sitemap|videoSitemap)[0-9]*\.(xml|xml\.gz)$ {
		root /home/sites/agsi/sitemaps/jeunette-porno-xxx.com;
		try_files $uri =404;
	}
';
					$replace = '	#redirect requests for sitemap files
	location ~ (sitemap|videoSitemap)[0-9]*\.(xml|xml\.gz)$ {
		root /home/sites/agsi/sitemaps/jeunette-porno-xxx.com;
		try_files $uri =404;
	}
';
//					$text = str_replace($search, $replace, $text);
//					if (file_put_contents($baseDir . $entry, $text) == false) {
//						echo 'nu am reusit sa scriu fisierul ' . $baseDir . $entry . '/main.php' . PHP_EOL;
//					}
				}
			} else {
				echo 'se pare ca nu e instalat ags pentru site-ul  "' . $entry . '"' . PHP_EOL;
			}
		}
	}
	closedir($handle);
}
?>
