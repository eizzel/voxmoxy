<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

//generate the dashboard menu here
$this->renderPartial('dashboardNav');
?>
<h1>My Uploads</h1>
<div class="pull-left">
	<?php $collapse = $this->beginWidget('bootstrap.widgets.TbCollapse'); ?>
	<a class="btn" data-toggle="collapse" href="#uploadFormContainer">File Upload</a>
	<div class="clearfix"></div>

	<div class="collapse" id="uploadFormContainer">
		<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
			'id'=>'upload-form',
			'action'=>$uploadUrl,
			'type'=>'horizontal',
			'enableClientValidation'=>false,
			'clientOptions'=>array('validateOnSubmit'=>true,),
			'htmlOptions'=>array('class' => 'well', 'enctype' => 'multipart/form-data', 'accept-charset=' => "utf-8"),
		)); ?>
		<?php echo $form->fileFieldRow($uploadForm, 'fileName');?>
		<?php echo $form->textFieldRow($uploadForm, 'title');?>
		<?php echo $form->textFieldRow($uploadForm, 'author');?>
		<?php echo $form->textAreaRow($uploadForm, 'description');?>
		<?php echo CHtml::submitButton('Upload', array('class'=>'btn btn-block')); ?>
		<?php $this->endWidget();?>
	</div>
	<?php $this->endWidget();?>
</div>
<div class="clearfix"></div>


<?php
$columns = array(
array('name'=>'memberUploadTitle', 'header'=>'Title'),
array('name'=>'memberUploadAuthor', 'header'=>'Author'),
array('name'=>'memberUploadDescription', 'header'=>'Description'),
array('name'=>'avgRating', 'header'=>'Rating'),
);

$this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'memberUpload-grid',
	'dataProvider' => $uploadList,
	'columns'=>$columns,
));
?>




