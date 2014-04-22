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
	<div id="header">
		<?php
		$items = array(
			'---',
			array('label' => 'Sign Up', 'url' => array('/default/default/signup'), 'visible' => Yii::app()->user->isGuest),
			array('label' => 'Dashboard', 'url' => array('/dashboard'), 'visible' => !Yii::app()->user->isGuest),
			);
		
		if(Yii::app()->user->id)
		{
			$member = Member::model()->findByPk(Yii::app()->user->id);
		}

		$this->widget(
			'bootstrap.widgets.TbNavbar',
			array(
				'brand' => '<img src="/img/logo.png" />',
				//'fixed' => false,
				'collapse' => true,
				'items' => array(
					array(
						'class' => 'bootstrap.widgets.TbMenu',
						'items' => $items
					),
					
					'<form class="navbar-search pull-left" method="POST" action ="'.$this->createUrl('/search').'">
						<input type="text" name="SearchAudioFileForm[searchText]" class="search-query" placeholder="search">
					</form>',
					
					Yii::app()->user->isGuest ?
					'
						<form class="navbar-form pull-right" method="POST" action="'.$this->createUrl('/login').'">
						<input type="text" class="span2 input-small" name="LoginForm[username]" placeholder="Email">
						<input type="password" class="span2 input-small" name="LoginForm[password]" placeholder="Password">
						<button type="submit" class="btn">Login</button>
						</form>
					'
					:
					'
						<form class="navbar-form pull-right" action="'.$this->createUrl('/logout').'">
						<span>'.$member->memberEmail.'</span>&nbsp;
						<button type="submit" class="btn">Logout</button>
						</form>
					'
			
				),
				
			)	
		);

		foreach (Yii::app()->user->getFlashes() as $key => $message)
		{
			$classParts = explode("_", $key);
			$class = $classParts[0];
			//show flash messages
			Yii::app()->clientScript->registerScript($classParts[1],'
				$(document).ready(function(){
				$("#header .navbar").notify("'.$message.'",
					{autoHideDelay: 8000, elementPosition: "bottom center", className: "'.$class.'", arrowSize: 10, gap: 40});			
				});');
		}
		?>
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
