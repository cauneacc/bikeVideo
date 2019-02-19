<div class="view">

<div style="float: left;">
<?php echo $data->getImage(true); ?>
</div>

<div style="float: left; margin-left: 10px;"> 
<b><?php echo CHtml::encode($data->getAttributeLabel('advertising_type')); ?>:</b>
<?php echo CHtml::encode($data->category->title); ?>
<br />

<b><?php echo CHtml::encode($data->getAttributeLabel('createtime')); ?>:</b>
<?php $locale = CLocale::getInstance(Yii::app()->language);
echo $locale->getDateFormatter()->formatDateTime($data->createtime, 'medium', 'medium'); ?>
<br />

<b><?php echo CHtml::encode($data->getAttributeLabel('start_time')); ?>:</b>
<?php	echo $locale->getDateFormatter()->formatDateTime($data->start_time, 'medium', 'medium'); ?>
<br />

<b><?php echo CHtml::encode($data->getAttributeLabel('end_time')); ?>:</b>
<?php	echo $locale->getDateFormatter()->formatDateTime($data->end_time, 'medium', 'medium'); ?>
<br />

<?php 
if($data->status == 0) echo 'Campaign is not yet active'; 
if($data->status == 1) echo 'Campaign is active and running'; 
echo '<br />';
if($data->payment_date == 0) echo 'Campaign is not yet payed';
if($data->payment_date == 1) echo 'Campaign was payed at: ' . $locale->getDateFormatter()->formatDateTime($data->end_time, 'medium', 'medium'); 

echo '<br />';
echo CHtml::link('Statistics', array(
			'//advertisement/advertisingCampaign/view', 'id' => $data->id));
?>
</div>
<div class="clear"> </div>
</div>
