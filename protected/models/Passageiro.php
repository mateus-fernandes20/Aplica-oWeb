<?php

/**
 * This is the model class for table "passageiro".
 *
 * The followings are the available columns in table 'passageiro':
 * @property string $nome
 * @property string $nascimento
 * @property string $email
 * @property string $telefone
 * @property string $stats
 * @property string $status_tempo
 * @property string $obs
 */
class Passageiro extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'passageiro';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nome, nascimento, email, telefone, stats', 'required'),
			array('nome', 'match', 'pattern' => '/^(?=[A-Za-zÀ-ÖØ-öø-ÿ]{3,} [A-Za-zÀ-ÖØ-öø-ÿ]{3,}$)[A-Za-zÀ-ÖØ-öø-ÿ ]+$/', 'message' => 'Nome deve conter duas partes com mínimo de 3 caracteres para cada parte.'),
			array('email', 'email', 'message' => 'Email inválido.'),
			array('telefone', 'match', 'pattern' => '/^\+\d{2}-\d{2}-9\d{8}$/', 'message' => 'Telefone inválido. Use +xx-xx-9xxxxxxxx'),
			array('stats', 'match', 'pattern' => '/^[AI]$/', 'message' => 'Stats must be either "A" or "I".'),
			array('nome, email', 'length', 'max'=>100),
			array('telefone', 'length', 'max'=>20),
			array('stats', 'length', 'max'=>1),
			array('obs', 'length', 'max'=>200),
			array('status_tempo', 'safe', 'on' => 'insert'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('nome, nascimento, email, telefone, stats, status_tempo, obs', 'safe', 'on'=>'search'),
		);
	}

	public function beforeSave()
    {
        if ($this->isNewRecord) {
			$this->stats = 'A';
            $this->status_tempo = new CDbExpression('CURRENT_TIMESTAMP');
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
			'nome' => 'Nome',
			'nascimento' => 'Nascimento',
			'email' => 'Email',
			'telefone' => 'Telefone',
			'stats' => 'Stats',
			'status_tempo' => 'Status Tempo',
			'obs' => 'Obs',
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

		$criteria->compare('nome',$this->nome,true);
		$criteria->compare('nascimento',$this->nascimento,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('telefone',$this->telefone,true);
		$criteria->compare('stats',$this->stats,true);
		$criteria->compare('status_tempo',$this->status_tempo,true);
		$criteria->compare('obs',$this->obs,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Passageiro the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
