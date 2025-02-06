<?php

/**
 * This is the model class for table "Corrida".
 *
 * The followings are the available columns in table 'Corrida':
 * @property integer $id
 * @property integer $motorista
 * @property string $passageiro
 * @property string $origem
 * @property string $destino
 * @property string $inicio
 * @property string $stats
 * @property string $fim
 * @property string $previsao
 * @property string $tarifa
 *
 * The followings are the available model relations:
 * @property Motorista $motorista0
 * @property Passageiro $passageiro0
 */
class Corrida extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Corrida';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('motorista, passageiro, origem, destino, inicio, stats', 'required'),
			array('motorista', 'numerical', 'integerOnly'=>true),
			array('passageiro', 'length', 'max'=>100),
			array('origem, destino', 'length', 'max'=>200),
			array('stats', 'length', 'max'=>1),
			array('tarifa', 'length', 'max'=>6),
			array('fim, previsao', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, motorista, passageiro, origem, destino, inicio, stats, fim, previsao, tarifa', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'motorista0' => array(self::BELONGS_TO, 'Motorista', 'motorista'),
			'passageiro0' => array(self::BELONGS_TO, 'Passageiro', 'passageiro'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'motorista' => 'Motorista',
			'passageiro' => 'Passageiro',
			'origem' => 'Origem',
			'destino' => 'Destino',
			'inicio' => 'Inicio',
			'stats' => 'Stats',
			'fim' => 'Fim',
			'previsao' => 'Previsao',
			'tarifa' => 'Tarifa',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('motorista',$this->motorista);
		$criteria->compare('passageiro',$this->passageiro,true);
		$criteria->compare('origem',$this->origem,true);
		$criteria->compare('destino',$this->destino,true);
		$criteria->compare('inicio',$this->inicio,true);
		$criteria->compare('stats',$this->stats,true);
		$criteria->compare('fim',$this->fim,true);
		$criteria->compare('previsao',$this->previsao,true);
		$criteria->compare('tarifa',$this->tarifa,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Corrida the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
