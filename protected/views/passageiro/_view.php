<?php
/* @var $this PassageiroController */
/* @var $data Passageiro */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->email), array('view', 'id'=>$data->email)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nome')); ?>:</b>
	<?php echo CHtml::encode($data->nome); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nascimento')); ?>:</b>
	<?php echo CHtml::encode($data->nascimento); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('telefone')); ?>:</b>
	<?php echo CHtml::encode($data->telefone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('stats')); ?>:</b>
	<?php echo CHtml::encode($data->stats); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status_tempo')); ?>:</b>
	<?php echo CHtml::encode($data->status_tempo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('obs')); ?>:</b>
	<?php echo CHtml::encode($data->obs); ?>
	<br />


</div>