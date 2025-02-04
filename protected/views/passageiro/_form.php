<?php
Yii::app()->clientScript->registerCssFile("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css");
/* @var $this PassageiroController */
/* @var $model Passageiro */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'passageiro-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'nome'); ?>
		<?php echo $form->textField($model,'nome',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'nome'); ?>
	</div>

	<div class="row">
    <?php echo $form->labelEx($model, 'nascimento'); ?>

    <div class="input-container">
        <?php 
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model,
            'attribute' => 'nascimento',
            'options' => array(
                'dateFormat' => 'yy-mm-dd',
                'changeYear' => true,
                'changeMonth' => true,
                'yearRange' => '1900:' . date('Y'),
                'showAnim' => 'fadeIn',
            ),
            'htmlOptions' => array(
                'size' => 10,
                'maxlength' => 10,
                'class' => 'date-input',
            ),
        ));
        ?>

        <i class="fa fa-calendar calendar-icon"></i>
    </div>

    <?php echo $form->error($model, 'nascimento'); ?>
	</div>

	<style>
		.input-container {
			position: relative;
			display: inline-block;
		}

		.date-input {
			padding-right: 30px;
		}

		.calendar-icon {
			position: absolute;
			right: 10px;
			top: 50%;
			transform: translateY(-50%);
			cursor: pointer;
			color: #555;
		}
	</style>

	<script>
		$(document).ready(function() {
			$(".calendar-icon").click(function() {
				$("#<?php echo CHtml::activeId($model, 'nascimento'); ?>").focus();
			});
		});
	</script>


	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'telefone'); ?>
		<?php echo $form->textField($model,'telefone',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'telefone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'stats'); ?>
		<?php echo $form->textField($model,'stats',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'stats'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'obs'); ?>
		<?php echo $form->textField($model,'obs',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'obs'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->