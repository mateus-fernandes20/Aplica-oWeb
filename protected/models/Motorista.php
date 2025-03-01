<?php

/**
 * This is the model class for table "Motorista".
 *
 * The followings are the available columns in table 'Motorista':
 * @property int $id
 * @property string $nome
 * @property string $nascimento
 * @property string $email
 * @property string $telefone
 * @property string $stats
 * @property string $status_tempo
 * @property string $placa
 * @property string $obs
 */
class Motorista extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Motorista';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nome, nascimento, email, telefone, stats, placa', 'required'),
			array('nome', 'match', 'pattern' => '/^(?=[A-Za-zÀ-ÖØ-öø-ÿ]{3,} [A-Za-zÀ-ÖØ-öø-ÿ]{3,}$)[A-Za-zÀ-ÖØ-öø-ÿ ]+$/', 'message' => 'Nome deve conter duas partes com mínimo de 3 caracteres para cada parte.'),
			array('email', 'email', 'message' => 'Email inválido.'),
			array('telefone', 'match', 'pattern' => '/^\+\d{2}-\d{2}-9\d{8}$/', 'message' => 'Telefone inválido. Use +xx-xx-9xxxxxxxx'),
			array('stats', 'match', 'pattern' => '/^[AI]$/', 'message' => 'Stats must be either "A" or "I".'),
			array('placa', 'match', 'pattern' => '/^[A-Z0-9]{7}$|^[A-Z]{3}-\d{4}$/', 'message' => 'Placa must be in the correct format (e.g., ABC-1234 or 1234567).'),
			array('nome, email', 'length', 'max'=>100),
			array('telefone', 'length', 'max'=>20),
			array('stats', 'length', 'max'=>1),
			array('placa', 'length', 'max'=>8),
			array('obs', 'length', 'max'=>200),
			array('status_tempo, id', 'safe', 'on' => 'insert'),
			array('corridas', 'safe', 'on' => 'update'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nome, nascimento, email, telefone, stats, status_tempo, obs, corridas', 'safe', 'on'=>'search'),
		);
	}

	public function beforeSave()
    {
        if ($this->isNewRecord) {
			$this->stats = 'A';
            $this->status_tempo = new CDbExpression('CURRENT_TIMESTAMP');
			//$this->status_tempo = new CDbExpression('AUTO_INCREMENT');
        } else {
			$this->status_tempo = new CDbExpression('CURRENT_TIMESTAMP');
		}
        return parent::beforeSave();
    }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nome' => 'Nome',
			'nascimento' => 'Nascimento',
			'email' => 'Email',
			'telefone' => 'Telefone',
			'stats' => 'Stats',
			'status_tempo' => 'Status Tempo',
			'placa' => 'Placa',
			'obs' => 'Obs',
			'corridas' => 'Corridas',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('nome',$this->nome,true);
		$criteria->compare('nascimento',$this->nascimento,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('telefone',$this->telefone,true);
		$criteria->compare('stats',$this->stats,true);
		$criteria->compare('status_tempo',$this->status_tempo,true);
		$criteria->compare('placa',$this->placa,true);
		$criteria->compare('obs',$this->obs,true);
		$criteria->compare('corridas',$this->corridas,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Motorista the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
