<div id="message">
<?php
if(isset($errorMessage)){
?>
<h3 style="color:red"><?php echo $errorMessage?></h3>
<?php
}
?>
</div>
<form action="" method="post">
	<table>
		<tr>
			<td>
				<label for="url">url</label>
			</td>
			<td>
				<input type="text"  name="url" style="width:600px" onblur="getInformation()" value="<?php echo $model->url ?>" id="urlInput"/>
			</td>
		</tr>
		<tr>
			<td>
				<label for="title">title</label>
			</td>
			<td>
				<input type="text" name="title" value="<?php echo $model->title ?>" style="width:600px" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="description">description</label>
			</td>
			<td>
				<textarea cols="60" rows="5" name="description" style="width:600px"><?php echo $model->description ?></textarea>
			</td>
		</tr>

		<tr>
			<td>
				<label for="tags">tags</label>
			</td>
			<td>
				<input type="text" name="tags" value="<?php echo $tags ?>" style="width:600px" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="categories">categories</label>
			</td>
			<td>

				<select name="categories[]" multiple="multiple" size="<?php echo count($categories) ?>">
					<?php
					foreach ($categories as $category) {
						?>
						<option value="<?php echo $category->cat_id ?>"<?php
					if (isset($selectedCategories)) {
						if (in_array($category->cat_id, $selectedCategories)) {
							echo ' selected="selected" ';
						}
					}
						?>><?php echo $category->name ?></option>
								<?php
							}
							?>
				</select>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="hidden" name="thumbUrl" value="<?php echo $model->thumb_url ?>" id="thumbUrl" />
				<input type="hidden" name="id" value="<?php echo $model->video_id ?>"/>
				<input type="submit" name="submit" value="submit" />
			</td>
		</tr>
</form>
</div>
<div style="float:right" id="thumbnails">
	<?php
	if (empty($model->thumb_url) == false) {
		?>
		<img src="<?php echo $model->thumb_url ?>" />
		<?php
	}
	?>
</div>



<style type="text/css">
	.thumbSelected{
		border:red 2px;
	}
</style>
<script type="text/javascript">
	function getYoutubeId(url){
		var video_id = url.split('v=')[1];
		var ampersandPosition = video_id.indexOf('&');
		if(ampersandPosition != -1) {
			video_id = video_id.substring(0, ampersandPosition);
		}
		return video_id;
		
	}
	
	function getScreen( url, size,number ){
		if(url === null){ return ""; }

		size = (size === null) ? "big" : size;
		var vid;
		var results;

		results = url.match("[\\?&]v=([^&#]*)");

		vid = ( results === null ) ? url : results[1];


		return "http://img.youtube.com/vi/"+vid+"/mqdefault.jpg";
	}
	/**
	 */
	function getInformation() {
	
		url=document.getElementById('urlInput').value;
		videoId=getYoutubeId(url);
		template='<img src="imageUrl" onclick="chooseImage(\'imageUrl\')" style="margin:5px" /><br />';
		selectedTemplate='<img src="imageUrl" onclick="chooseImage(\'imageUrl\')" style="border:solid 5px red" /><br />';

		imageUrl=getScreen(url,'small');

		document.getElementById('thumbUrl').value=imageUrl;
		document.getElementById('thumbnails').innerHTML=selectedTemplate.replace(/imageUrl/g, imageUrl);
		jQuery.post('<?php echo Yii::app()->createUrl('site/CheckUniqueVideoUrl')?>',{ 'url': url }, function(data) {
  document.getElementById('message').innerHTML='<h3 style="color:red">'+'Deja exista un videoclip cu url-ul ' + url+ '. Adaugati alt url'+'</h3>';
});

	}
</script>


