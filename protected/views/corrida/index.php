<?php
/* @var $this CorridaController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Corridas',
);

$this->menu=array(
	array('label'=>'Create Corrida', 'url'=>array('create')),
	array('label'=>'Manage Corrida', 'url'=>array('admin')),
);
?>

<h1>Corridas</h1>

<?php if (Yii::app()->user->hasFlash('error')): ?>
    <div class="error">
        <?php echo Yii::app()->user->getFlash('error'); ?>
    </div>
<?php endif; ?>

<?php if (isset($errorMessage) && $errorMessage): ?>
    <div class="error">
        <?php echo CHtml::encode($errorMessage); ?>
    </div>
<?php endif; ?>

<!-- Filter Form -->
<form method="GET" action="<?php echo Yii::app()->createUrl('corrida/index'); ?>">
    <input type="hidden" name="r" value="corrida/index" />

    <label for="start_time">Start Time:</label>
    <input type="datetime-local" id="start_time" name="start_time" 
        value="<?php echo isset($_GET['start_time']) ? CHtml::encode($_GET['start_time']) : ''; ?>" />

    <label for="end_time">End Time:</label>
    <input type="datetime-local" id="end_time" name="end_time" 
        value="<?php echo isset($_GET['end_time']) ? CHtml::encode($_GET['end_time']) : ''; ?>" />

    <input type="submit" value="Filter" />
</form>



<!-- Display Filtered Results -->
<?php
$this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_view', // Calls _view.php for each Corrida
));
?>

<?php if (Yii::app()->user->hasFlash('error')): ?>
    <div class="error">
        <?php echo Yii::app()->user->getFlash('error'); ?>
    </div>
<?php endif; ?>

