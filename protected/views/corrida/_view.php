<?php
/* @var $this CorridaController */
/* @var $data Corrida */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('motorista')); ?>:</b>
	<?php echo CHtml::encode($data->motorista); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('passageiro')); ?>:</b>
	<?php echo CHtml::encode($data->passageiro); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('origem')); ?>:</b>
	<?php echo CHtml::encode($data->origem); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('destino')); ?>:</b>
	<?php echo CHtml::encode($data->destino); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('inicio')); ?>:</b>
	<?php echo CHtml::encode($data->inicio); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('stats')); ?>:</b>
	<?php echo CHtml::encode($data->stats); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('fim')); ?>:</b>
	<?php echo CHtml::encode($data->fim); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('previsao')); ?>:</b>
	<?php echo CHtml::encode($data->previsao); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tarifa')); ?>:</b>
	<?php echo CHtml::encode($data->tarifa); ?>
	<br />

	*/ ?>

</div>