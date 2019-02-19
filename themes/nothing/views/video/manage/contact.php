<?php
if (!isset($success)) {
	?>
	<form action = "" method = "post" class = "form-horizontal">
		<fieldset>
			<legend>Leave us a message</legend>
			<div class = "control-group">
				<label for = "email"><?php echo Yii::t('app', 'Email')
	?></label>
				<input type="text" name="email" class="input-xxlarge" value="<?php
				if (isset($email)) {
					echo $email;
				}
	?>" />
			</div>
			<div class="control-group">
				<label for="title"><?php echo Yii::t('app', 'Title') ?></label>
				<input type="text" name="title" class="input-xxlarge" value="<?php
				   if (isset($title)) {
					   echo $title;
				   }
	?>" />
			</div>
			<div class="control-group">
				<label for="message"><?php echo Yii::t('app', 'Message') ?></label>
				<textarea name="message" class="input-xxlarge" rows="6"><?php
				   if (isset($message)) {
					   echo $message;
				   }
	?></textarea>
			</div>
			<?php
			if (isset($recaptchaResult)) {
				?>
				<div class="control-group error">
					<?php echo $recaptchaHtml ?>
					<span class="help-inline">Please correct the error</span>
				</div>

				<?php
			} else {
				?>
				<div class="control-group">
					<?php echo $recaptchaHtml ?>
				</div>
				<?php
			}
			?>
		</fieldset>
		<input type="submit" value="<?php echo Yii::t('app', 'Submit') ?>" class="btn" name="submit" />

	</form>
	<?php
} else {
	?>
<h1>The message was sent. Thank you</h1>
	<?php
}
?>
