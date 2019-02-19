<ul style="background-color: #000; height:100px;">
<?php foreach($this->getRecentArticles() as $model): ?>
<li>
<?php echo CHtml::link(CHtml::encode($model->name),array('','id'=>$model->id)); ?>
</li>
<?php endforeach; ?>
</ul>