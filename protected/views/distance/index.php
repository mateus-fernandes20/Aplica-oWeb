<?php if (Yii::app()->user->hasFlash('success')): ?>
    <div class="success">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?>

<?php if (Yii::app()->user->hasFlash('error')): ?>
    <div class="error">
        <?php echo Yii::app()->user->getFlash('error'); ?>
    </div>
<?php endif; ?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'distance-form',
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
));
?>

<div>
    <?php echo $form->labelEx($model, 'location1'); ?>
    <?php echo $form->textField($model, 'location1'); ?>
</div>

<div>
    <?php echo $form->labelEx($model, 'location2'); ?>
    <?php echo $form->textField($model, 'location2'); ?>
</div>

<div>
    <?php echo CHtml::submitButton('Calculate Distance'); ?>
</div>

<?php $this->endWidget(); ?>

<!-- Show Error or Calculate Distance, Time Estimate & Price -->
<?php
if ($_POST && isset($model->location1) && isset($model->location2)) {
    // Check if locations are the same
    if (strtolower(trim($model->location1)) === strtolower(trim($model->location2))) {
        echo "<div class='error'>The two locations are identical. Please enter different locations.</div>";
    } else {
        // Proceed with distance calculation
        if (isset($model->distance)) {
            if ($model->distance <= 0.1) { // 100 meters = 0.1 km
                echo "<div class='error'>The two locations are too close (less than 100 meters apart). Please select different locations.</div>";
            } else {
                // Display Distance
                echo "<h2>Distance: " . round($model->distance, 2) . " km</h2>";

                // Calculate time estimate
                $estimatedTimeInMinutes = round(($model->distance * 1000) / 200); // base calculation
                $estimatedTimeInMinutes += 3;   // Adding 3 minutes for fixed time

                // Check if the estimated time exceeds 8 hours (480 minutes)
                if ($estimatedTimeInMinutes > 480) {
                    echo "<div class='error'>The estimated time exceeds 8 hours. Please enter different locations.</div>";
                } else {
                    // Adjust current time with the time difference
                    $currentTime = new DateTime();
                    $currentTime->modify("+$estimatedTimeInMinutes minutes");
                    $currentTime->modify("-180 minutes");  // Subtract 180 minutes

                    $formattedTime = $currentTime->format('H:i');

                    // Display Estimated Time
                    echo "<h2>Estimated Time: " . $estimatedTimeInMinutes . " min</h2>";
                    echo "<h3>Estimated Arrival Time: $formattedTime</h3>";

                    // Calculate the price
                    $distanceCost = $model->distance * 2.00;  // R$ 2.00 per km
                    $timeCost = $estimatedTimeInMinutes * 0.50; // R$ 0.50 per minute
                    $basePrice = 5.00; // Fixed base price

                    // Total price
                    $totalPrice = $distanceCost + $timeCost + $basePrice;

                    // Make sure the price is non-negative
                    if ($totalPrice < 0) {
                        $totalPrice = 0; // Set to 0 if negative value occurs
                    }

                    // Display Price
                    echo "<h3>Price: R$ " . number_format($totalPrice, 2, ',', '.') . "</h3>";

                    // Display Map
                    echo "<div id='map' style='height: 400px; width: 100%;'></div>";

                    // Leaflet.js
                    echo "<link rel='stylesheet' href='https://unpkg.com/leaflet/dist/leaflet.css' />";
                    echo "<script src='https://unpkg.com/leaflet/dist/leaflet.js'></script>";

                    echo "<script>
                            document.addEventListener('DOMContentLoaded', function () {
                                var map = L.map('map').setView([0, 0], 2); // Default view

                                // Add OpenStreetMap layer
                                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                    attribution: '© OpenStreetMap contributors'
                                }).addTo(map);

                                var lat1 = " . (isset($model->lat1) ? $model->lat1 : 'null') . ";
                                var lng1 = " . (isset($model->lng1) ? $model->lng1 : 'null') . ";
                                var lat2 = " . (isset($model->lat2) ? $model->lat2 : 'null') . ";
                                var lng2 = " . (isset($model->lng2) ? $model->lng2 : 'null') . ";

                                var loc1 = \"" . (isset($model->loc1) ? addslashes($model->loc1) : '') . "\";
                                var loc2 = \"" . (isset($model->loc2) ? addslashes($model->loc2) : '') . "\";

                                if (lat1 && lng1 && lat2 && lng2) {
                                    var marker1 = L.marker([lat1, lng1]).addTo(map)
                                        .bindPopup('<b>' + loc1 + '</b>').openPopup();
                                    var marker2 = L.marker([lat2, lng2]).addTo(map)
                                        .bindPopup('<b>' + loc2 + '</b>').openPopup();

                                    // Draw line between points
                                    var polyline = L.polyline([[lat1, lng1], [lat2, lng2]], { color: 'blue' }).addTo(map);

                                    // Fit map to markers
                                    map.fitBounds(polyline.getBounds());
                                }
                            });
                          </script>";
                }
            }
        }
    }
}
?>
