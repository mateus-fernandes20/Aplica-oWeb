<?php
$this->breadcrumbs=array(
	'Corridas'=>array('index'),
	'Solicitar',
);
?>

<h1>Solicitar Corrida</h1>

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
        <?php echo CHtml::submitButton('Calcular Distância'); ?>
    </div>

    <?php $this->endWidget(); ?>
</div>

<?php if(isset($model->distance)): ?>
    <h2>Distância: <?php echo $model->distance; ?> km</h2>

    <div id="map" style="height: 400px; width: 100%;"></div>

    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var map = L.map('map').setView([0, 0], 2);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            var lat1 = <?php echo isset($model->lat1) ? $model->lat1 : 'null'; ?>;
            var lng1 = <?php echo isset($model->lng1) ? $model->lng1 : 'null'; ?>;
            var lat2 = <?php echo isset($model->lat2) ? $model->lat2 : 'null'; ?>;
            var lng2 = <?php echo isset($model->lng2) ? $model->lng2 : 'null'; ?>;

            var loc1 = "<?php echo isset($model->loc1) ? addslashes($model->loc1) : ''; ?>";
            var loc2 = "<?php echo isset($model->loc2) ? addslashes($model->loc2) : ''; ?>";

            if (lat1 && lng1 && lat2 && lng2) {
                var marker1 = L.marker([lat1, lng1]).addTo(map)
                    .bindPopup("<b>" + loc1 + "</b>").openPopup();
                var marker2 = L.marker([lat2, lng2]).addTo(map)
                    .bindPopup("<b>" + loc2 + "</b>").openPopup();

                var polyline = L.polyline([[lat1, lng1], [lat2, lng2]], { color: 'blue' }).addTo(map);

                map.fitBounds(polyline.getBounds());
            }
        });
    </script>
<?php endif; ?>
