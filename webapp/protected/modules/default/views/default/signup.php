<?php
/* @var $this DefaultController */
/* @var $model SignupForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Signup';
?>
<h1>Sign Up</h1>

<p>Please fill out the following form to sign up:</p>

<div class="row-fluid">
	<div class="span6 form well">
		<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
			'id' => 'signUpForm',
			'type' => 'horizontal',
			'enableClientValidation'=>true,
			'enableAjaxValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>true,
			),
		));
		?>
		<?php echo $form->textFieldRow($model, 'firstName');?>
		<?php echo $form->textFieldRow($model, 'lastName');?>
		<?php echo $form->textFieldRow($model, 'userName');?>
		<?php echo $form->textFieldRow($model, 'email');?>
		<?php echo $form->passwordFieldRow($model, 'password');?>
		<?php echo $form->passwordFieldRow($model, 'passwordConfirm');?>
		
		<?php echo $form->checkBoxRow($model, 'userAgreement');?>
		<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 
			'label'=>'Sign Up', 
			'htmlOptions'=>array('class'=>'btn btn-large pull-right'))); ?>

		<?php $this->endWidget(); ?>
	</div>
</div>
