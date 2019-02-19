<ul>
<?php foreach($this->getRecentPosts() as $model): ?>
<li>
<?php echo CHtml::link(CHtml::encode($model->name),array('cms2Articles/view','id'=>$model->id)); ?>
    
</li>
<?php endforeach; ?>
</ul>