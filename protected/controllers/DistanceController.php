<?php
class DistanceController extends Controller
{
    private function getCoordinates($location, $apiKey)
    {
        $url = "https://api.opencagedata.com/geocode/v1/json?q=" . urlencode($location) . "&key=" . $apiKey;
        
        $response = file_get_contents($url);
        $data = json_decode($response, true);
    
        if (!empty($data['results']) && isset($data['results'][0]['geometry'])) {
            return $data['results'][0]['geometry'];
        }
    
        return false;
    }
    
    private function haversine($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371;

        $latDelta = deg2rad($lat2 - $lat1);
        $lonDelta = deg2rad($lon2 - $lon1);

        $a = sin($latDelta / 2) * sin($latDelta / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($lonDelta / 2) * sin($lonDelta / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return bcdiv($earthRadius * $c, 1, 2);
    }

    public function actionIndex()
    {
        $model = new DistanceForm();

        if (isset($_POST['DistanceForm'])) {
            $model->attributes = $_POST['DistanceForm'];
            
            if ($model->validate()) {
                $apiKey = "apiKey";

                $coords1 = $this->getCoordinates($model->location1, $apiKey);
                $coords2 = $this->getCoordinates($model->location2, $apiKey);

                if ($coords1 && $coords2) {
                    $model->distance = $this->haversine(
                        $coords1['lat'], $coords1['lng'],
                        $coords2['lat'], $coords2['lng']
                    );

                    $model->lat1 = $coords1['lat'];
                    $model->lng1 = $coords1['lng'];
                    $model->lat2 = $coords2['lat'];
                    $model->lng2 = $coords2['lng'];
                    $model->loc1 = $model->location1;
                    $model->loc2 = $model->location2;
                } else {
                    Yii::app()->user->setFlash('error', 'Failed to fetch coordinates. Check your input.');
                }
            }
        }

        $this->render('index', array('model' => $model));
    }
}
?>
