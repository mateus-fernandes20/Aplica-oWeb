<?php
/* @var $this PassageiroController */
/* @var $model Passageiro */

$this->breadcrumbs=array(
	'Passageiros'=>array('index'),
	$model->email=>array('view','id'=>$model->email),
	'Update',
);

$this->menu=array(
	array('label'=>'List Passageiro', 'url'=>array('index')),
	array('label'=>'Create Passageiro', 'url'=>array('create')),
	array('label'=>'View Passageiro', 'url'=>array('view', 'id'=>$model->email)),
	array('label'=>'Manage Passageiro', 'url'=>array('admin')),
);
?>

<h1>Update Passageiro <?php echo $model->email; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>