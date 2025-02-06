<?php
/* @var $this PassageiroController */
/* @var $passageiro Passageiro */
?>

<h1>Update Stats for <?php echo CHtml::encode($motorista->email); ?></h1>

<?php
// Display success or error message
if (Yii::app()->user->hasFlash('success')) {
    echo '<div class="success">' . Yii::app()->user->getFlash('success') . '</div>';
} elseif (Yii::app()->user->hasFlash('error')) {
    echo '<div class="error">' . Yii::app()->user->getFlash('error') . '</div>';
}
?>

<?php
// Begin the form to update stats
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'update-stats-form',
    'enableAjaxValidation' => false,
)); ?>

    <div class="form">
        <div class="row">
            <b><?php echo CHtml::encode($motorista->getAttributeLabel('stats')); ?>:</b>
            <?php echo $form->dropDownList($motorista, 'stats', array(
                'A' => 'Active',
                'I' => 'Inactive',
            ), array('prompt' => 'Select Status')); ?>
            <?php echo $form->error($motorista, 'stats'); ?>
        </div>

        <div class="row buttons">
            <?php echo CHtml::submitButton('Save'); ?>
        </div>
    </div>

<?php $this->endWidget(); ?>
