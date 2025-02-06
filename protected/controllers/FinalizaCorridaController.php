<?php
class FinalizaCorridaController extends Controller
{
    public function actionIndex()
    {
        $filePath = Yii::getPathOfAlias('application') . '/config/finaliza.json';
        
        if (!file_exists($filePath)) {
            echo json_encode(["sucesso" => false, "message" => "finaliza.json file not found."]);
            Yii::app()->end();
        }

        $jsonData = json_decode(file_get_contents($filePath), true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode(["sucesso" => false, "message" => "Invalid JSON format: " . json_last_error_msg()]);
            Yii::app()->end();
        }

        // Extract corrida ID and motorista ID
        $corridaId = isset($jsonData['corrida']['id']) ? (int)$jsonData['corrida']['id'] : null;
        $motoristaId = isset($jsonData['motorista']['id']) ? (int)$jsonData['motorista']['id'] : null;

        if (!$corridaId || !$motoristaId) {
            echo json_encode(["sucesso" => false, "message" => "Missing required fields."]);
            Yii::app()->end();
        }

        // Find the corrida record
        $corrida = Yii::app()->db->createCommand()
            ->select('*')
            ->from('corrida')
            ->where('id = :id', [':id' => $corridaId])
            ->queryRow();

        if (!$corrida) {
            echo json_encode(["sucesso" => false, "message" => "Corrida not found."]);
            Yii::app()->end();
        }

        // Find the motorista record
        $motorista = Yii::app()->db->createCommand()
            ->select('*')
            ->from('motorista')
            ->where('id = :id', [':id' => $motoristaId])
            ->queryRow();

        if (!$motorista) {
            echo json_encode(["sucesso" => false, "message" => "Motorista not found."]);
            Yii::app()->end();
        }

        // Update 'fim' field in 'corrida' table with current timestamp
        Yii::app()->db->createCommand()
            ->update('corrida', ['fim' => new CDbExpression('NOW()')], 'id = :id', [':id' => $corridaId]);

        // Increment 'corrida' count in 'motorista' table
        Yii::app()->db->createCommand()
            ->update('motorista', ['corridas' => new CDbExpression('corridas + 1')], 'id = :id', [':id' => $motoristaId]);

        echo json_encode(["sucesso" => true, "message" => "Corrida finalizada com sucesso."]);
    }
}
