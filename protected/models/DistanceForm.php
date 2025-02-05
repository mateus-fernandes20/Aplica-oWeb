<?php
class DistanceForm extends CFormModel
{
    public $location1;
    public $location2;
    public $distance;

    public $lat1;
    public $lng1;
    public $lat2;
    public $lng2;
    public $loc1;
    public $loc2;

    public function rules()
    {
        return array(
            array('location1, location2', 'required'),
            array('distance, lat1, lng1, lat2, lng2, loc1, loc2', 'safe'), // Allow these fields
        );
    }

    public function attributeLabels()
    {
        return array(
            'location1' => 'Partida',
            'location2' => 'Destino',
        );
    }
}
?>