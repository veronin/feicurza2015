<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	yii::t('app','Users')=>array('index'),
	yii::t('app','Manage'),
);

$this->menu=array(
	array('label'=>'List User', 'url'=>array('index')),
	array('label'=>'Create User', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#user-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<h1><?php echo yii::t('app', 'Manage');echo ' ';echo yii::t('app', 'User');?>s</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button'));
?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); 

?>

</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
        'afterAjaxUpdate'=>"function(){jQuery('#User_fechaNac').datepicker($.datepicker.regional[ 'es' ])}",
	'columns'=>array(
		'id',
		'username',
		//'password',
                 
                array(  //'type'=>'date', se aplica ahora el afterFind
                        'name'=>'fechaNac',
                        //'value'=>'$data->fechaNac!=null?date("d/m/y", strtotime($data->fechaNac)):""',
                        
                        'filter'=>$this->widget('zii.widgets.jui.CJuiDatePicker',array(
                                //'name'=>'publishDate',
                                'model'=>$model,
                                'attribute'=>'fechaNac',
                                'language'=>'es',
                                // additional javascript options for the date picker plugin
                                'options'=>array(
                                    'showAnim'=>'fold',
                                ),
                                'htmlOptions'=>array(
                                    'style'=>'height:20px;'
                                ),
                            ),true)
                        
                ),  
                'email',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); 

?>
