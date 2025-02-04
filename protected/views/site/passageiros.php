<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' - Passageiros';
$this->breadcrumbs=array(
	'Listar passageiros',
);
?>
<h1>Listar passageiros</h1>

<p>Tela para visualização dos passageiros.</p>


    <?php
        $newSQL = "SELECT * FROM passageiro";
		$connection = new CDbConnection('mysql:host=localhost;dbname=tabela','root','root');
		$command = $connection->createCommand($newSQL);
		$results = $command->queryAll();
    ?>

    <?php foreach($results as $result) {?>
    		<h3>
                <li>
                    <?php echo $result['nome'] . "<br>";?>
                </li>
            </h3>
            <ul>
                <li><?php echo "Data de nascimento: " . $result['nascimento'] . "<br>";?></li>
                <li><?php echo "Email: " . $result['email'] . "<br>";?></li>
                <li><?php echo "Telefone: " . $result['telefone'] . "<br>";?></li>
                <li><?php echo "Status: " . $result['stats'] . "<br>";?></li>
                <li><?php echo "Obs: " . $result['obs'] . "<br>";?></li>
            </ul>
        <?php } ?>

