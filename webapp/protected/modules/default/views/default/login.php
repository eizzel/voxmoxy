<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>

<h1>Login</h1>
<p>Please fill out the following form with your login credentials:</p>

<div class="row-fluid">
	<div class="span4">
	<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'login-form',
		'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
		'htmlOptions' => array('class' => 'well')
	)); ?>
		<?php echo $form->textFieldRow($model, 'username'); ?>
		<?php echo $form->passwordFieldRow($model, 'password'); ?>
		<?php echo $form->checkBoxRow($model, 'rememberMe'); ?>
		<?php echo CHtml::submitButton('Login', array('class'=>'btn')); ?>
	<?php $this->endWidget(); ?>
	</div><!-- form -->
	<div class="span2">
		<center>-- Or --</center>
	</div>
	<div class="span4">
		<div class="well">
			<a class="btn btn-block btn-primary btn-large" href="<?php echo $this->createUrl('/signup');?>">Sign Up</a>
		</div>
	</div>
</div>
