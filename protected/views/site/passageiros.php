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

    <?php
    	// Display the result
		foreach($results as $result) {?>
    		<li><?php echo "Database connection is working! Result: " . $result['nome'] . "<br>";?></li>
        <?php	}
    ?>

