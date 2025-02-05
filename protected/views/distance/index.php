<h1>Calculate Distance Between Two Locations</h1>

<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'distance-form',
        'enableClientValidation' => true,
        'clientOptions' => array('validateOnSubmit' => true),
    )); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'location1'); ?>
        <?php echo $form->textField($model, 'location1'); ?>
        <?php echo $form->error($model, 'location1'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'location2'); ?>
        <?php echo $form->textField($model, 'location2'); ?>
        <?php echo $form->error($model, 'location2'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Calculate Distance'); ?>
    </div>

    <?php $this->endWidget(); ?>
</div>

<?php 
if (isset($model->location1) && isset($model->location2)) {
    if (strtolower(trim($model->location1)) === strtolower(trim($model->location2))) {
        echo "<div class='error'>The two locations are identical. Please enter different locations.</div>";
    } else {
        if (isset($model->distance)) {
            if ($model->distance <= 0.1):
                echo "<div class='error'>The two locations are too close (less than 100 meters apart). Please select different locations.</div>";
            else:
                echo "<h2>Distance: " . $model->distance . " km</h2>";

                $estimatedTimeInMinutes = round(($model->distance * 1000) / 200);

                $estimatedTimeInMinutes += 3;

                if ($estimatedTimeInMinutes < 0) {
                    $estimatedTimeInMinutes = 0;
                }

                $currentTime = new DateTime();
                $currentTime->modify("+$estimatedTimeInMinutes minutes");
                $currentTime->modify("-180 minutes");
                $formattedTime = $currentTime->format('H:i');

                echo "<h2>Estimated Time: " . $estimatedTimeInMinutes . "</h2>";
                echo "<h3>Estimated Arrival Time: $formattedTime</h3>";

                $distanceCost = $model->distance * 2.00;
                $timeCost = $estimatedTimeInMinutes * 0.50;
                $basePrice = 5.00;

                $totalPrice = $distanceCost + $timeCost + $basePrice;

                if ($totalPrice < 0) {
                    $totalPrice = 0;
                }

                echo "<h3>Price: R$ " . number_format($totalPrice, 2, ',', '.') . "</h3>";

                echo "<div id='map' style='height: 400px; width: 100%;'></div>";

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
            endif;
        }
    }
}
?>
