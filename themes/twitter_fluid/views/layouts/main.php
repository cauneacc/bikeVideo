<?php
	Yii::app()->clientscript
		->registerCssFile( Yii::app()->theme->baseUrl . '/css/bootstrap.css' )
		->registerCssFile( Yii::app()->theme->baseUrl . '/css/bootstrap-responsive.css' )
			->registerCoreScript( 'jquery' )
		// use it when you need it!
		/*
		->registerCoreScript( 'jquery' )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-transition.js', CClientScript::POS_END )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-alert.js', CClientScript::POS_END )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-modal.js', CClientScript::POS_END )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-dropdown.js', CClientScript::POS_END )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-scrollspy.js', CClientScript::POS_END )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-tab.js', CClientScript::POS_END )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-tooltip.js', CClientScript::POS_END )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-popover.js', CClientScript::POS_END )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-button.js', CClientScript::POS_END )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-collapse.js', CClientScript::POS_END )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-carousel.js', CClientScript::POS_END )
		->registerScriptFile( Yii::app()->theme->baseUrl . '/js/bootstrap-typeahead.js', CClientScript::POS_END )
		*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Admin</title>
<meta name="description" content="">
<meta name="author" content="">

<!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<!-- Le styles -->
<style type="text/css">
  body {
	padding-top: 60px;
	padding-bottom: 40px;
  }
  .sidebar-nav {
	padding: 9px 0;
  }

	@media (max-width: 980px) {
		body{
			padding-top: 0px;
		}
	}
</style>

<!-- Le fav and touch icons -->
<link rel="shortcut icon" href="images/favicon.ico">
</head>

<body>
	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<a class="brand" href="#"><?php echo Yii::app()->name ?></a>
				<div class="nav-collapse">
					<?php $this->widget('zii.widgets.CMenu',array(
						'htmlOptions' => array( 'class' => 'nav' ),
						'activeCssClass'	=> 'active',
						'items'=>array(
							array('label'=>'Home', 'url'=>array('/')),
//							array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
//							array('label'=>'Contact', 'url'=>array('/site/contact')),
//							array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
							array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
						),
					)); ?>
					<?php
						if(Yii::app()->user->id){
					?>
						<p class="navbar-text pull-right">Logged in as <?php echo Yii::app()->user->name ?></p>
					<?php
					}
					?>
				</div><!--/.nav-collapse -->
			</div>
		</div>
	</div>

    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span2">
			
          
			  <?php
			  if(Yii::app()->user->id){
				?>
				<div class="well sidebar-nav">
					<ul class="nav nav-list">
						<li class="nav-header">Sidebar</li>
						<li><a href="<?php echo Yii::app()->createUrl('/site/admin')?>">List Videos</a></li>
						<li><a href="<?php echo Yii::app()->createUrl('/site/addVideo')?>">Add Video</a></li>
						<li><a href="<?php echo Yii::app()->createUrl('/cms2/AdminCms2Articles/admin')?>">List Articles</a></li>
						<li><a href="<?php echo Yii::app()->createUrl('/cms2/AdminCms2Articles/create')?>">Add Article</a></li>
						<li><a href="<?php echo Yii::app()->createUrl('/cms2/AdminCms2Galleries/admin')?>">List Galleries</a></li>
						<li><a href="<?php echo Yii::app()->createUrl('/cms2/AdminCms2Galleries/create')?>">Add Gallery</a></li>
						<li><a href="<?php echo Yii::app()->createUrl('/cms2/AdminCms2Images/admin')?>">List Images</a></li>
						<li><a href="<?php echo Yii::app()->createUrl('/cms2/AdminCms2Images/create')?>">Add Image</a></li>

					</ul>
				</div>
				<?php
			  }
			  ?>
          
			<!--/.well -->
        </div><!--/span-->
        <div class="span10">
          <div class="hero-unit">
			<?php echo $content ?>
          </div>
        </div><!--/span-->
      </div><!--/row-->

      <hr>

      <footer>
      </footer>

    </div><!--/.fluid-container-->
</body>
</html>
