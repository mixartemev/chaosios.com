<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="ru" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<body>
<div id="page" class="wrap_x">
	<div class="wrap_y">
		<div id="header">
			<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
		</div><!-- header -->
		<div id="sub-header">
			<div id="mainmenu">
				<?php $this->widget('zii.widgets.CMenu',array(
					'items'=>array(
						array('label'=>'Domains', 'url'=>array('site/index'),'tabl'=>'Domain'),
						array('label'=>'Emails', 'url'=>array('site/index','tabl'=>'Email')),
						array('label'=>'Hoster Accounts', 'url'=>array('site/page', 'view'=>'about')),
						array('label'=>'Contact', 'url'=>array('site/contact')),
						array('label'=>'Login', 'url'=>array('site/login'), 'visible'=>Yii::app()->user->isGuest),
						array('label'=>'Logout ('.((isset(Yii::app()->user->title))?Yii::app()->user->title:Yii::app()->user->name).')', 'url'=>array('site/logout'), 'visible'=>!Yii::app()->user->isGuest)
					),
				)); ?>
			</div><!-- mainmenu -->
			<?php /*$this->widget('zii.widgets.CBreadcrumbs', array(
				'links'=>$this->breadcrumbs,
			));*/ ?><!-- breadcrumbs -->
		</div><!-- sub-header -->

		<?php echo $content; ?>

		<div id="empty"></div>
	</div>
	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by Blurax.<br/>
	</div><!-- footer -->
</div><!-- page -->
</body>
</html>