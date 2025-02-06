<?php
/* @var $this CorridaController */
/* @var $model Corrida */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'corrida-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'motorista'); ?>
		<?php echo $form->textField($model,'motorista'); ?>
		<?php echo $form->error($model,'motorista'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'passageiro'); ?>
		<?php echo $form->textField($model,'passageiro',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'passageiro'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'origem'); ?>
		<?php echo $form->textField($model,'origem',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'origem'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'destino'); ?>
		<?php echo $form->textField($model,'destino',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'destino'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'inicio'); ?>
		<?php echo $form->textField($model,'inicio'); ?>
		<?php echo $form->error($model,'inicio'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'stats'); ?>
		<?php echo $form->textField($model,'stats',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'stats'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fim'); ?>
		<?php echo $form->textField($model,'fim'); ?>
		<?php echo $form->error($model,'fim'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'previsao'); ?>
		<?php echo $form->textField($model,'previsao'); ?>
		<?php echo $form->error($model,'previsao'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tarifa'); ?>
		<?php echo $form->textField($model,'tarifa',array('size'=>6,'maxlength'=>6)); ?>
		<?php echo $form->error($model,'tarifa'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->