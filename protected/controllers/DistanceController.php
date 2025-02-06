<?php
class DistanceController extends Controller
{
    // Get API token from secret.txt
    public function getApiToken() {
        $file = Yii::getPathOfAlias('application') . '/config/secret.txt';
        return file_exists($file) ? trim(file_get_contents($file)) : null;
    }

    // Get coordinates from OpenCage API
    public function getCoordinatesFromOpenCage($location) {
        $apiToken = $this->getApiToken();
        if (!$apiToken) {
            throw new Exception("API token is missing.");
        }

        $url = "https://api.opencagedata.com/geocode/v1/json?q=" . urlencode($location) . "&key=" . $apiToken;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        Yii::log("OpenCage API Response: " . $response, CLogger::LEVEL_INFO, 'application');

        if ($statusCode == 200) {
            $data = json_decode($response, true);
            if (isset($data['results']) && !empty($data['results'])) {
                return $data;
            } else {
                throw new Exception("No results found in OpenCage API response.");
            }
        } else {
            throw new Exception("Error fetching data from OpenCage API. Status code: " . $statusCode);
        }
    }

    // Calculate distance (Haversine formula)
    private function haversine($lat1, $lng1, $lat2, $lng2) {
        $earthRadius = 6371; // Earth radius in km
        $latDiff = deg2rad($lat2 - $lat1);
        $lngDiff = deg2rad($lng2 - $lng1);

        $a = sin($latDiff / 2) * sin($latDiff / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($lngDiff / 2) * sin($lngDiff / 2);

        return 2 * $earthRadius * atan2(sqrt($a), sqrt(1 - $a));
    }

    public function actionIndex()
    {
        // Ensure that the response content-type is JSON
        header('Content-Type: application/json');

        // Read the entrada.json file
        $jsonFilePath = Yii::getPathOfAlias('application') . '/config/entrada.json';
        if (!file_exists($jsonFilePath)) {
            echo json_encode(['sucesso' => false, 'message' => 'entrada.json file not found.']);
            Yii::app()->end();
        }

        $jsonData = file_get_contents($jsonFilePath);
        $data = json_decode($jsonData, true);

        if (!$data) {
            echo json_encode(['sucesso' => false, 'message' => 'Invalid JSON format.']);
            Yii::app()->end();
        }

        try {
            // Extract origin and destination addresses
            $origem = $data['origem'];
            $destino = $data['destino'];

            // Get coordinates from OpenCage API
            $coordsOrigem = $this->getCoordinatesFromOpenCage($origem['endereco']);
            $coordsDestino = $this->getCoordinatesFromOpenCage($destino['endereco']);

            // Calculate distance (you can replace haversine if necessary)
            $distance = $this->haversine(
                $coordsOrigem['results'][0]['geometry']['lat'],
                $coordsOrigem['results'][0]['geometry']['lng'],
                $coordsDestino['results'][0]['geometry']['lat'],
                $coordsDestino['results'][0]['geometry']['lng']
            );

            // Calculate estimated time in minutes
            $estimatedTimeInMinutes = round(($distance * 1000) / 200);
            $estimatedTimeInMinutes += 3;  // Add 3 minutes of fixed time

            if ($estimatedTimeInMinutes > 480) {
                echo json_encode([
                    'sucesso' => false,
                    'message' => 'The estimated time exceeds 8 hours.',
                ]);
                Yii::app()->end();
            }

            $motorista = Motorista::model()->find('Stats = :stats', ['stats' => 'A']);

            // Calculate the arrival time
            $currentTime = new DateTime();
            $currentTime->modify("+$estimatedTimeInMinutes minutes");
            $currentTime->modify("-180 minutes");  // Subtract 180 minutes
            $formattedTime = $currentTime->format('Y-m-d H:i');

            $distanceCost = $distance * 2.00; // R$ 2.00 per km
            $timeCost = $estimatedTimeInMinutes * 0.50; // R$ 0.50 per minute
            $basePrice = 5.00; // Fixed base price
            $totalPrice = $distanceCost + $timeCost + $basePrice;

            $emailPassageiro = isset($data['passageiro']['id']) ? trim($data['passageiro']['id']) : null;

            $tbl_origem = isset($data['origem']['endereco']) ? $data['origem']['endereco'] : null;
            $tbl_destino = isset($data['destino']['endereco']) ? $data['destino']['endereco'] : null;

            if ($motorista === null) {
                // If no active motorista is found, return an error

                Yii::app()->db->createCommand()->insert('Corrida', [
                    'passageiro' => $emailPassageiro,
                    'origem' => $tbl_origem,
                    'destino' => $tbl_destino,
                    'inicio' => new CDbExpression('CURRENT_TIMESTAMP'),
                    'fim' => new CDbExpression('CURRENT_TIMESTAMP'),
                    'stats' => 'N',
                    'previsao' => $formattedTime,
                    'tarifa' => $totalPrice,
                ]);

                echo json_encode([
                    'sucesso' => false,
                    'message' => 'Nenhum motorista disponível.',
                ]);

                Yii::app()->end();
            } else{
                Yii::app()->db->createCommand()->insert('Corrida', [
                    'motorista' => $motorista['id'],
                    'passageiro' => $emailPassageiro,
                    'origem' => $tbl_origem,
                    'destino' => $tbl_destino,
                    'inicio' => new CDbExpression('CURRENT_TIMESTAMP'),
                    'stats' => 'A',
                    'previsao' => $formattedTime,
                    'tarifa' => $totalPrice,
                ]);
            }

            // Prepare success response
            $response = [
                'sucesso' => true,
                'corrida' => [
                    'id' => Yii::app()->db->lastInsertID,
                    'previsao_chegada_destino' => $formattedTime,
                    'previsao_tempo' => $estimatedTimeInMinutes,
                    'preco' => number_format($totalPrice, 2, ',', '.'),
                    //'teste' => $emailPassageiro,
                ],
                'motorista' => [
                    'nome' => $motorista->nome,
                    'placa' => $motorista->placa,
                    'quantidade_corridas' => $motorista->corridas,
                ],
            ];

            echo json_encode($response);
        } catch (Exception $e) {
            echo json_encode([
                'sucesso' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }

        // Terminate the request and avoid any further output
        Yii::app()->end();
    }

}

?>
