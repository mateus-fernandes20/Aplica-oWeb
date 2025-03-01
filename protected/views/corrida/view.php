<?php
/* @var $this CorridaController */
/* @var $model Corrida */

$this->breadcrumbs=array(
	'Corridas'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Corrida', 'url'=>array('index')),
	array('label'=>'Create Corrida', 'url'=>array('create')),
	array('label'=>'Update Corrida', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Corrida', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Corrida', 'url'=>array('admin')),
);
?>

<h1>View Corrida #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'motorista',
		'passageiro',
		'origem',
		'destino',
		'inicio',
		'stats',
		'fim',
		'previsao',
		'tarifa',
	),
)); ?>
