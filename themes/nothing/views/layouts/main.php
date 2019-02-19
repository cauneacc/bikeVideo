<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta charset="utf-8">
		<title><?php
			echo $this->pageTitle;
			?></title>
		<link rel="shortcut icon" href="/favicon.ico">
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-35439219-1']);
  _gaq.push(['_trackPageview']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
		<link href="/themes/nothing/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="/themes/nothing/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
		<script src="http://code.jquery.com/jquery-latest.js"></script>
		<script src="/themes/nothing/bootstrap/js/bootstrap.min.js"></script>

<?php 
if(empty($this->canonicalLink)==false){
?>
	<link rel="canonical" href="<?php echo $this->canonicalLink?>" />
<?php
}
?>

<?php 
if(empty($this->relPrev)==false){
?>
	<link rel="prev" href="<?php echo $this->relPrev?>" />
<?php
}
?>
<?php 
if(empty($this->relNext)==false){
?>
	<link rel="next" href="<?php echo $this->relNext?>" />
<?php
}
?>

	</head>
	<style type="text/css">
		h2{
font-size: 20px;
line-height: 10px;
		}
		h1{
			color:white;
			background-color:#FF9000
		}
		a{
			color:#00878D
		}
		.footer > a{
			color:white;
			text-decoration:none;
		}
		.footer{
			padding:10px;
			text-align:center;
		}
		.videoDescription{
			color:#586D6E;padding:10px;font-size:large;
		}
img.imgthumbnail:hover{ 
	opacity:0.8;
	border:2px solid white
} 
img.imgthumbnail{ 
border:2px solid black
} 
.bodyContainer{
	background-color:#00878D;
}
	</style>
	<body  class="bodyContainer">
		<div class="container" style="background-color:white">
			<div class="row">
				<div class="span12" style="text-align:center">
					<div style="position:absolute;top:200px;z-index:100;">
						<a href="http://addictedtocycling.com/" style="color:white;line-height:40px;font-size:30px;margin-left:10px;font-weight:900">Addicted to cycling</a>
					</div>
					<img src="/themes/nothing/headeren.jpg" />
				</div>
			</div>

			<div class="row">
				<div class="span3" >
					<?php $this->renderPartial('//site/categories'); ?>
						<span style="padding-left:40px">
						<a href="https://twitter.com/addictedcycling" class="twitter-follow-button" data-show-count="false" data-size="large" >Follow @addictedcycling</a>
						<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
					</span>

				</div>
				<div class="span9">
					
					<?php echo $content?>
					
				</div>
			</div>
			<div class="row">
				<div class="span12" style="background-color:#FF9000;height:75px;color:white">
					
					<?php // echo $this->renderPartial('//video/default/_footerLinks') ?>
					<div class="footer">Copyright - <?php echo date('Y')?>  <?php echo Yii::app()->params['siteName']?> - <a href="<?php echo Yii::app()->createUrl('//video/manage/contact')?>">Contact</a></div>
					
				</div>
			</div>
			
		</div>


	
</html>