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
        $curlError = curl_error($ch);
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
    $model = new DistanceForm();

    if (isset($_POST['DistanceForm'])) {
        $model->attributes = $_POST['DistanceForm'];

        if ($model->validate()) {
            try {
                $coords1 = $this->getCoordinatesFromOpenCage($model->location1);
                $coords2 = $this->getCoordinatesFromOpenCage($model->location2);

                if ($coords1 && $coords2) {
                    $distance = $this->haversine(
                        $coords1['results'][0]['geometry']['lat'], 
                        $coords1['results'][0]['geometry']['lng'],
                        $coords2['results'][0]['geometry']['lat'], 
                        $coords2['results'][0]['geometry']['lng']
                    );

                    $model->distance = round($distance, 2);
                    $model->lat1 = $coords1['results'][0]['geometry']['lat'];
                    $model->lng1 = $coords1['results'][0]['geometry']['lng'];
                    $model->lat2 = $coords2['results'][0]['geometry']['lat'];
                    $model->lng2 = $coords2['results'][0]['geometry']['lng'];

                    Yii::app()->user->setFlash('success', "Distance: {$model->distance} km");
                } else {
                    Yii::app()->user->setFlash('error', 'Failed to fetch coordinates. Check your input.');
                }
            } catch (Exception $e) {
                Yii::app()->user->setFlash('error', 'Error: ' . $e->getMessage());
            }
        }
    }

    $this->render('index', array('model' => $model));
}

}
?>
