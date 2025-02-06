<?php
/* @var $this PassageiroController */
/* @var $model Passageiro */

$this->breadcrumbs = array(
    'Passageiros' => array('index'),
    $model->email,
);

$this->menu = array(
    array('label' => 'List Passageiro', 'url' => array('index')),
    array('label' => 'Create Passageiro', 'url' => array('create')),
    array('label' => 'Update Passageiro', 'url' => array('update', 'id' => $model->email)),
    array('label' => 'Delete Passageiro', 'url' => '#', 'linkOptions' => array(
        'submit' => array('delete', 'id' => $model->email),
        'confirm' => 'Are you sure you want to delete this item?'
    )),
    array('label' => 'Manage Passageiro', 'url' => array('admin')),
);
?>

<h1>Detalhes do Passageiro: <?php echo CHtml::encode($model->nome); ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'nome',
        'nascimento',
        'email',
        'telefone',
        'stats',
        'status_tempo',
        'obs',
    ),
));
?>

<h3>Últimas 5 Corridas</h3>
<?php
// Fetch the last 5 rides for this passageiro
$corridas = Yii::app()->db->createCommand()
    ->select('*')
    ->from('corrida')
    ->where('passageiro = :passageiro', [':passageiro' => $model->email])
    ->order('inicio DESC')
    ->limit(5)
    ->queryAll();

if (!empty($corridas)) {
    echo "<ul>";
    foreach ($corridas as $corrida) {
        echo "<li>";
        echo "<b>Origem:</b> " . CHtml::encode($corrida['origem']) . "<br />";
        echo "<b>Destino:</b> " . CHtml::encode($corrida['destino']) . "<br />";
        echo "<b>Início:</b> " . CHtml::encode($corrida['inicio']) . "<br />";
        echo "<b>Status:</b> " . CHtml::encode($corrida['stats']) . "<br />";
        echo "<b>Tarifa:</b> R$ " . number_format($corrida['tarifa'], 2, ',', '.') . "<br />";
        echo "</li><hr>";
    }
    echo "</ul>";
} else {
    echo "<p>Nenhuma corrida encontrada.</p>";
}
?>
