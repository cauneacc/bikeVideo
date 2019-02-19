<div class="article-row">

    <div class="thumb">
        <a href="<?php echo yii::app()->createUrl('/cms2/cms2Articles/view', array('id' => $data->id)) ?>"><img src="<?php echo Cms2Images::createSmallImageUrl($data->image_id) ?>" width="100"  alt='<?php echo $data->name ?>' />
        </a>
    </div> 
    <div class="desc">
        <h2><?php echo CHtml::link(CHtml::encode($data->name), array('cms2Articles/view', 'id' => $data->id)); ?>
        </h2>
        <?php
        $aux = explode(' ', strip_tags($data->desc));
        $aux = array_splice($aux, 0, 30);
        $aux = implode(' ', $aux);
        $dots = '...';
        echo CHtml::encode($aux . $dots);
        ?>

    </div>
    <div class="clear"></div>
</div>