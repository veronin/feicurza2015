<?php
/* @var $this PostController */
/* @var $model Post */

$this->breadcrumbs=array(
	'Posts'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Post', 'url'=>array('index')),
	array('label'=>'Create Post', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#post-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Posts</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'post-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'title',
		'content',
		'tags',
		//'status',
            /*Referencias a un atributo virtual del modelo getNombreUsuario
                para que aparezca en el search debe estar en el MODELO
                'nombreUsuario',*/
            /*Atributo virtual con atributos de CDataColumn o
                'nombreUsuario:raw' 
		array(
                    'header'=>'User Atrib.Virtual',
                    'name'=>'nombreUsuario',
                    'type'=>'raw' ),   */
            
                array(
                    'filter'=>array('admin'=>'admin', 'demo'=>'demo', 'vero'=>'vero'),
                    'name'=>'nusuario',
                    'value'=>'$data->author->username',
                ),     
            /*Referencia a la relacion del modelo
                'author.username',*/
                array(
                    'header'=>'User Relacion',
                    'value'=>'$data->author->username',
                ),
                array(
                'header'=>'Create Time',
                'name'=>'create_time',
                'type'=>'datetime'
                ),
		/*
                'create_time', 
		'update_time',
		'author_id',
		*/
		array(
			'class'=>'CButtonColumn',
                        //'template'=> '{view}{update}',
                        'afterDelete'=>'function(link,success,data){ if(success) alert(data); }',
		),
	),
)); ?>
