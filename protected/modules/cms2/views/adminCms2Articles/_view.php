<div class="view" style=" display:block">
    <h2><?php echo CHtml::link(CHtml::encode($data->name), array('adminCms2Articles/view', 'id' => $data->id)); ?>
    </h2>
    
    <div class="thumb" style="float:left; padding: 5px; margin-right: 5px;">
        <a href="<?php echo yii::app()->createUrl('adminCms2Articles/view', array('id' => $data->id))?>"><img src='<?php echo Cms2Images::createSmallImageUrl($data) ?>' width="100" alt='<?php echo $data->name ?>' />
        </a>
    </div> 
    
    <div class="desc" style="">
                <?php 
                $aux=explode(' ', strip_tags($data->desc));
                $aux=array_splice($aux, 0, 10);
                $aux=implode(' ', $aux);
                echo  CHtml::encode($aux);
                ?>
                
    </div>
    <div class="clear"></div>
</div>