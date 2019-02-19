<h1><?php echo $browseTitle?></h1>

	<?php
if ($videos){
	if($videos[0]){
		?>
		<?php echo $videos[0]->embed_code?>
		<h4>
			<?php echo ucfirst($videos[0]->description) ?>
		</h4>
<?php
		unset($videos[0]);
	}
?>
<?php
if(empty($articles)==false){
	foreach($articles as $article){
?>
<div style="height:160px;padding-bottom:5px">
  <a class="pull-left" href="<?php echo Yii::app()->createUrl('cms2/cms2Articles/view',array('slug'=>$article->slug,'category'=>$category->slug))?>" style="padding-right:5px">
    <img class="img-polaroid" src="<?php echo Cms2Images::createSmallImageUrl($article->Cms2Images)?>" style="max-height:150px" align:left>
  </a>
  <a href="<?php echo Yii::app()->createUrl('cms2/cms2Articles/view',array('slug'=>$article->slug,'category'=>$category->slug))?>">
    <h5><?php echo $article->name ?></h5>
  </a>
	    <?php echo $article->tease ?>
</div>

<br style="clear:both"/>
<?php
	}
}
?>
<ul class="thumbnails" >
<?php
	foreach ($videos as  $k=>$video){
		echo $this->renderPartial('//video/default/_videoRectangle',array('video'=>$video));
	}
	?>
</ul>
<?php
	}else{
	?>
<p>
Nothing to display
</p>
<?php
	}
?>
<div class="clear"></div>
<div style="width:500px;text-align:center;">
<?php
	$pager=new CLinkPager();
	$pager->setPages($pages);
	$pager->init();
	$pager->run();
?>
</div>


