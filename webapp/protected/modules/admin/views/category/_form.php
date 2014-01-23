<?php
/* @var $this CategoryController */
/* @var $model Category */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'category-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'dateCreated'); ?>
		<?php echo $form->textField($model,'dateCreated'); ?>
		<?php echo $form->error($model,'dateCreated'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'dateLastModified'); ?>
		<?php echo $form->textField($model,'dateLastModified'); ?>
		<?php echo $form->error($model,'dateLastModified'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'categoryName'); ?>
		<?php echo $form->textField($model,'categoryName',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'categoryName'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->