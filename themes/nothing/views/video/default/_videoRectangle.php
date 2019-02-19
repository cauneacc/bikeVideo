	<li class="span3">
		<div class="thumbnail" style="background-color:#C3CFC6;height:260px;overflow:hidden">

				<a href="<?php echo Yii::app()->createUrl('video/default/view',array('id'=>$video->video_id,'slug'=>$video->slug,'category'=>$video->category_slug))?>" title="<?php echo $video->title?>">
					<img src="<?php	echo $video->thumb_url;	?>" alt="<?php echo $video->description?>" title="<?php echo $video->title?>" class="imgthumbnail">
				</a>
				
			
			<h4>
				<a href="<?php echo Yii::app()->createUrl('video/default/view',array('id'=>$video->video_id,'slug'=>$video->slug,'category'=>$video->category_slug))?>" title="<?php echo $video->title?>">
				<?php echo ucfirst($video->title) ?>
				</a>
			</h4>
			<p style="color:#586D6E">
				<?php 
				$truncated = (strlen($video->description) > 30) ? substr($video->description, 0, 30) . '...' : $video->description;
				echo ucfirst($truncated)?>
			</p>

		</div>
	</li>

