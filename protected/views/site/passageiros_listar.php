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
        try {
            $newSQL = "SELECT * FROM passageiro";
        
            $connection = new CDbConnection('mysql:host=localhost;dbname=tabela', 'root', 'root');

            $connection->active = true;
        
            $command = $connection->createCommand($newSQL);
        
            $results = $command->queryAll();
        
            foreach ($results as $result) {
                echo "<h3><li>" . $result['nome'] . "</li></h3>";
                echo "<ul>";
                echo "<li>Data de nascimento: " . $result['nascimento'] . "</li>";
                echo "<li>Email: " . $result['email'] . "</li>";
                echo "<li>Telefone: " . $result['telefone'] . "</li>";
                echo "<li>Status: " . $result['stats'] . "</li>";
                echo "<li>Obs: " . $result['obs'] . "</li>";
                echo "</ul>";
            }
        } catch (CDbException $e) {
            echo "Database error: " . $e->getMessage();
        } catch (Exception $e) {
            echo "An error occurred: " . $e->getMessage();
        } finally {
            if (isset($connection) && $connection->active) {
                $connection->active = false;
            }
        }
        
    ?>

