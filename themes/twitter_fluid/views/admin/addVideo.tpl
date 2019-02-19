<div style="background:grey;width:100%;height:100%" >
<div style="float:left;background:grey" >
	<form action="" method="post">
		<table>
			<tr>
				<td>
					<label for="url">url</label>
				</td>
				<td>
					<input type="text"  name="url" size="60" onblur="getInformation()" value="http://www.youtube.com/watch?v=fWNaR-rxAic&feature=g-music" id="urlInput"/>
				</td>
			</tr>
			<tr>
				<td>
					<label for="title">title</label>
				</td>
				<td>
					<input type="text" name="title" value="" />
				</td>
			</tr>
			<tr>
				<td>
					<label for="description">description</label>
				</td>
				<td>
					<textarea cols="60" rows="5" name="description"></textarea>
				</td>
			</tr>

			<tr>
				<td>
					<label for="tags">tags</label>
				</td>
				<td>
					<input type="text" name="tags" value="" />
				</td>
			</tr>
			<tr>
				<td>
					<label for="categories">categories</label>
				</td>
				<td>

					<select name="categories[]" multiple="multiple" size="{$categories|count}">
						{foreach $categories as $category}
							<option value="{$category->cat_id}">{$category->name}</option>
						{/foreach}
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="hidden" name="thumbUrl" value="" id="thumbUrl" />
					<input type="submit" name="submit" value="submit" />
				</td>
			</tr>
	</form>
</div>
<div style="float:right" id="thumbnails">
	
</div>
{literal}
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

  if(size == "small"){
    return "http://img.youtube.com/vi/"+vid+"/"+number+".jpg";
  }else {
    return "http://img.youtube.com/vi/"+vid+"/"+number+".jpg";
  }
}
/**
 */
function getInformation() {
	
    url=document.getElementById('urlInput').value;
	videoId=getYoutubeId(url);
	template='<img src="imageUrl" onclick="chooseImage(\'imageUrl\')" style="margin:5px" /><br />';
	selectedTemplate='<img src="imageUrl" onclick="chooseImage(\'imageUrl\')" style="border:solid 5px red" /><br />';
	for(i=1;i<4;i++){
		imageUrl=getScreen(url,'small',i);
		if(i==2){
			document.getElementById('thumbUrl').value=imageUrl;
			document.getElementById('thumbnails').innerHTML=document.getElementById('thumbnails').innerHTML+selectedTemplate.replace(/imageUrl/g, imageUrl);
		}else{
			document.getElementById('thumbnails').innerHTML=document.getElementById('thumbnails').innerHTML+template.replace(/imageUrl/g, imageUrl);
		}
	}

}
</script>
{/literal}
</div>