<?php
/* @var $this CorridaController */
/* @var $model Corrida */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'motorista'); ?>
		<?php echo $form->textField($model,'motorista'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'passageiro'); ?>
		<?php echo $form->textField($model,'passageiro',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'origem'); ?>
		<?php echo $form->textField($model,'origem',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'destino'); ?>
		<?php echo $form->textField($model,'destino',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'inicio'); ?>
		<?php echo $form->textField($model,'inicio'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'stats'); ?>
		<?php echo $form->textField($model,'stats',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fim'); ?>
		<?php echo $form->textField($model,'fim'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'previsao'); ?>
		<?php echo $form->textField($model,'previsao'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tarifa'); ?>
		<?php echo $form->textField($model,'tarifa',array('size'=>6,'maxlength'=>6)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->