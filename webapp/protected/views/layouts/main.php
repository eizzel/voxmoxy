<?php 
/* @var $this Controller */
/* @var $loginForm LoginForm */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>css/main.css" />
</head>

<body class="<?php echo Yii::app()->controller->action->id; ?>">
	<?php
	$items = array(
		'---',
		array('label' => 'Sign Up', 'url' => array('/default/default/signup'), 'visible' => Yii::app()->user->isGuest),
		//array('label' => 'Login', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest),
		);
	
	$this->widget(
		'bootstrap.widgets.TbNavbar',
		array(
			'brand' => 'Vox Moxy',
			//'fixed' => false,
			'collapse' => true,
			'items' => array(
				array(
					'class' => 'bootstrap.widgets.TbMenu',
					'items' => $items
				),
				'
					<form class="navbar-form pull-right">
					<input type="text" class="span2 input-small" placeholder="Email">
					<input type="password" class="span2 input-small" placeholder="Password">
					<button type="submit" class="btn">Login</button>
					</form>
				'
			),
			'htmlOptions' => array('class' => '')
		)	
	);

	?>
	<div id="header">
		
	</div><!-- header -->
	<div class="clear"></div>

	<div id="content" class="container">
		<div class="row-fluid">
			<?php echo $content; ?>
		</div>
	</div>
	<div class="clear"></div>

	<div id="footer">
		
	</div><!-- footer -->
</body>
</html>
