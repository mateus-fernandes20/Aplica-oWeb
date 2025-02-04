<?php
/* @var $this PassageiroController */
/* @var $model Passageiro */

$this->breadcrumbs=array(
	'Passageiros'=>array('index'),
	$model->email,
);

$this->menu=array(
	array('label'=>'List Passageiro', 'url'=>array('index')),
	array('label'=>'Create Passageiro', 'url'=>array('create')),
	array('label'=>'Update Passageiro', 'url'=>array('update', 'id'=>$model->email)),
	array('label'=>'Delete Passageiro', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->email),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Passageiro', 'url'=>array('admin')),
);
?>

<h1>View Passageiro #<?php echo $model->email; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'nome',
		'nascimento',
		'email',
		'telefone',
		'stats',
		'status_tempo',
		'obs',
	),
)); ?>
