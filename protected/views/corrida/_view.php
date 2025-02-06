<?php
/* @var $this CorridaController */
/* @var $data Corrida */

/* Add time filter form */

    $motoristaNome = Yii::app()->db->createCommand()
    ->select('nome')
    ->from('motorista')
    ->where('id = :id', [':id' => $data->motorista])
    ->queryScalar();

    $passageiroNome = Yii::app()->db->createCommand()
    ->select('nome')
    ->from('passageiro')
    ->where('email = :email', [':email' => $data->passageiro])
    ->queryScalar();
?>

    <div class="view">

        <b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
        <?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
        <br />

        <b><?php echo CHtml::encode($data->getAttributeLabel('stats')); ?>:</b>
        <?php echo CHtml::encode($data->stats); ?>
        <br />

        <b><?php echo CHtml::encode($data->getAttributeLabel('inicio')); ?>:</b>
        <?php echo CHtml::encode($data->inicio); ?>
        <br />

        <b><?php echo CHtml::encode($data->getAttributeLabel('motorista')); ?>:</b>
        <?php echo CHtml::encode($motoristaNome ? $motoristaNome : "Não encontrado"); ?>
        <br />

        <b><?php echo CHtml::encode($data->getAttributeLabel('passageiro')); ?>:</b>
        <?php echo CHtml::encode($passageiroNome ? $passageiroNome : "Não encontrado"); ?>
        <br />

        <b><?php echo CHtml::encode($data->getAttributeLabel('origem')); ?>:</b>
        <?php echo CHtml::encode($data->origem); ?>
        <br />

        <b><?php echo CHtml::encode($data->getAttributeLabel('destino')); ?>:</b>
        <?php echo CHtml::encode($data->destino); ?>
        <br />

    </div>
