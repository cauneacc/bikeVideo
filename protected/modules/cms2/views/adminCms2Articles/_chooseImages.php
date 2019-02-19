<b><?php echo $data->name?></b>
<img src="<?php echo Cms2Images::createSmallImageUrl($data)?>"
	 onclick="
		 $('#chosenImageContainer').html('<img src=\'<?php echo Cms2Images::createSmallImageUrl($data)?>\' alt=\'<?php echo addslashes($data->name)?>\' title=\'<?php echo addslashes($data->name)?>\' /><input type=\'hidden\' name=\'Cms2Articles[image_slug]\' value=\'<?php echo $data->slug?>\' />');
	 $('#chooseImages').dialog('close')" alt="<?php echo addslashes($data->name)?>" title="<?php echo addslashes($data->name)?>" />
<br />
