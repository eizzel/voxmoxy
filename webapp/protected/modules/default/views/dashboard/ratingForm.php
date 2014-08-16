<?php 
/* @var $ratingForm RatingForm */
?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
			'id'=>'rating-form',
			'enableClientValidation'=>true,
			'clientOptions'=>array('validateOnSubmit'=>true,),
		)); ?>
<?php echo $form->hiddenField($ratingForm, 'memberUploadId');?>
<label for="RatingForm_rating" class="required" >
	Rating <span class="required">*</span>
	<div>
	<?php $this->widget('ext.dzRaty.DzRaty', array(
			'model' => $ratingForm,
			'attribute' => 'rating',
		));
	?>	
	</div>
	<?php echo $form->error($ratingForm, 'rating'); ?>
</label>

<?php echo $form->textAreaRow($ratingForm, 'comments');?>
<?php $this->endWidget();?>

