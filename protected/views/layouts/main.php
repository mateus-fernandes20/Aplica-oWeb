<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="en">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print">
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection">
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css">

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->

	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Home', 'url'=>array('/site/index')),
				array(
					'label'=>'Passageiros', 
					'url'=> '#',
					'items'=>array(
						array('label'=>'Listar Passageiros', 'url'=>'/index.php?r=passageiro'),
						array('label'=>'Criar Passageiros', 'url'=>'/index.php?r=passageiro/create'),
						array('label'=>'Gerenciar Passageiros', 'url'=>'/index.php?r=passageiro/admin'),
						array('label'=>'Status Passageiros', 'url'=>'/index.php?r=passageiro/status'),
					),
				),
				array(
					'label'=>'Motoristas', 
					'url'=> '#',
					'items'=>array(
						array('label'=>'Listar Motoristas', 'url'=>'/index.php?r=motorista'),
						array('label'=>'Criar Motoristas', 'url'=>'/index.php?r=motorista/create'),
						array('label'=>'Gerenciar Motoristas', 'url'=>'/index.php?r=motorista/admin'),
					),
				),
				array(
					'label'=>'Corridas', 
					'url'=> '#',
					'items'=>array(
						array('label'=>'Listar Corridas', 'url'=>'/index.php?r=corrida'),
						array('label'=>'Solicitar Corrida', 'url'=>'/index.php?r=distance/index'),
					),
				),

				array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
				array('label'=>'Contact', 'url'=>array('/site/contact')),
				array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
			),
		)); ?>
	</div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
