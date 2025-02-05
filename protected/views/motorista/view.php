<?php
/* @var $this MotoristaController */
/* @var $model Motorista */

$this->breadcrumbs=array(
	'Motoristas'=>array('index'),
	$model->email,
);

$this->menu=array(
	array('label'=>'List Motorista', 'url'=>array('index')),
	array('label'=>'Create Motorista', 'url'=>array('create')),
	array('label'=>'Update Motorista', 'url'=>array('update', 'id'=>$model->email)),
	array('label'=>'Delete Motorista', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->email),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Motorista', 'url'=>array('admin')),
);
?>

<h1>View Motorista #<?php echo $model->email; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nome',
		'nascimento',
		'email',
		'telefone',
		'stats',
		'status_tempo',
		'placa',
		'obs',
		'corridas',
	),
)); ?>
