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
		<?php echo $form->labelEx($model,'categoryName'); ?>
		<?php echo $form->textField($model,'categoryName',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'categoryName'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'parentId'); ?>
		<?php
		$dataTree = new ClosureTableTree(array(
            'sourceTable' => Category::model(),
            'relationTable' => CategoryRelation::model(),
            'parentField' => 'parentCategoryId',
            'childField' => 'childCategoryId',
            'textField' => 'categoryName',
        ));
		
		$listData = $dataTree->getChildrenAsFlatArray();
		d($listData);
		echo $form->dropDownList($model,'parentId', $listData, array('encode'=>false, 'prompt'=>'-- Select a Parent --'));
		?>
		<?php echo $form->error($model,'categoryName'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->