<h1><?php echo ucfirst($video->title) ?></h1>
<?php
echo $video->embed_code;
?>
	<br /><br />
	
	
	<p>
		<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div class="fb-like" data-send="true" data-width="450" data-show-faces="false" data-font="arial" style="display:inline"></div>
<a href="https://twitter.com/share" class="twitter-share-button" data-size="large" data-count="none">Tweet</a><script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
<!-- Place this tag where you want the share button to render. -->
<div class="g-plus" data-action="share" data-height="24"></div>

<!-- Place this tag after the last share tag. -->
<script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>
	</p>
	
	
	<p class="videoDescription">
		<?php echo ucfirst($video->description) ?>
	</p>
		
	<br /><br />

	<?php
	if ($relatedVideos) {
		?>
		<ul class="thumbnails">
			<?php
			foreach ($relatedVideos as $video) {
				echo $this->renderPartial('//video/default/_videoRectangle',array('video'=>$video));
			}
			?>
		</ul>
		<?php
	}
	?>
