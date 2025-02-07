<?php

class MotoristaController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Motorista;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Motorista']))
		{
			$model->attributes=$_POST['Motorista'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->email));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Motorista']))
		{
			$model->attributes=$_POST['Motorista'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->email));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Motorista');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Motorista('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Motorista']))
			$model->attributes=$_GET['Motorista'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Motorista the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Motorista::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Motorista $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='motorista-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionUpdateStats($email)
    {
        // Find the passageiro by email
        $model = Motorista::model()->findByAttributes(array('email' => $email));

        // Check if the passageiro exists
        if ($model === null) {
            throw new CHttpException(404, 'The requested Motorista does not exist.');
        }

        // Toggle the 'stats' field (active to inactive, or vice versa)
        $model->stats = ($model->stats == 'A') ? 'I' : 'A';

        // Save the updated 'stats' field
        if ($model->save()) {
            // Redirect back to the index or list page after update
            $this->redirect(array('index'));
        } else {
            // If save fails, display an error message
            Yii::app()->user->setFlash('error', 'Error updating stats.');
            $this->redirect(array('index'));
        }
    }


	public function actionEstatisticas()
    {
        // Read motorista.json file
        $jsonFile = Yii::getPathOfAlias('application.config') . '/motorista.json';
        $config = json_decode(file_get_contents($jsonFile), true);

        // Extract motorista ID, intervalo, and periodicidade
        $motoristaId = $config['motorista']['id'] ?? null;
        $startDate = $config['intervalo']['inicio'] ?? null;
        $endDate = $config['intervalo']['fim'] ?? null;
        $periodicidade = $config['periodicidade'] ?? 'M'; // Default to 'M'

        // Validate parameters
        if (!$motoristaId || !$startDate || !$endDate) {
            echo json_encode(["error" => "Invalid input parameters"]);
            Yii::app()->end();
        }
		$motorista = Motorista::model()->findByPk($motoristaId);

        // Fetch statistics from database
        $lista = $this->getStatistics($motoristaId, $startDate, $endDate, $periodicidade);

        // Prepare JSON response
        $response = [
            "motorista" => [
                "id" => $motoristaId,
                "nome" => $motorista->nome // This should come from the database if needed
            ],
            "periodicidade" => $periodicidade,
            "lista" => $lista
        ];

        // Return JSON response
        header('Content-Type: application/json');
        echo json_encode($response);
        Yii::app()->end();
    }

    private function getStatistics($motoristaId, $startDate, $endDate, $periodicidade)
{
    // Determine grouping based on periodicidade
    $groupBy = match ($periodicidade) {
        "D" => "DATE(c.inicio)",  // Group by Day
        "S" => "YEARWEEK(c.inicio, 1)", // Group by Week (ISO Week)
        "M" => "DATE_FORMAT(c.inicio, '%Y-%m')" // Group by Month
    };

    // Query to fetch all occurrences of the motorista in the given period
    $rows = Yii::app()->db->createCommand()
        ->select("
            MIN(c.inicio) AS intervalo_inicio, 
            MAX(c.fim) AS intervalo_fim, 
            COUNT(c.motorista) AS quantidade, 
            COALESCE(SUM(c.tarifa), 0) AS faturamento,
			COALESCE(SUM(TIMESTAMPDIFF(SECOND, c.inicio, c.fim)), 0) AS duracao
        ")
        ->from('corrida c')
        ->where('c.motorista = :id AND c.inicio BETWEEN :start AND :end', [
            ':id' => $motoristaId,
            ':start' => $startDate . ' 00:00:00',
            ':end' => $endDate . ' 23:59:59'
        ])
        ->group($groupBy)
        ->queryAll();

    // Format response
    $lista = [];
    foreach ($rows as $row) {
		// Calculate hours, minutes, and seconds from the total duration in seconds
        $totalSeconds = (int)($row["duracao"] ?? 0);
        $hours = floor($totalSeconds / 3600);
        $minutes = floor(($totalSeconds % 3600) / 60);
        $seconds = $totalSeconds % 60;

        // Format the duration as hh:mm:ss
        $formattedDuration = sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);

        $lista[] = [
            "intervalo" => [
                "inicio" => $row["intervalo_inicio"] ?? $startDate,
                "fim" => $row["intervalo_fim"] ?? $endDate,
            ],
            "estatistica" => [
                "quantidade" => (int)($row["quantidade"] ?? 0),
                "faturamento" => (float)($row["faturamento"] ?? 0.0),
				"duracao" => $formattedDuration,
            ]
        ];
    }

    return $lista;
}

}
