<?php
/* @var $this Controller */
/* @var $memberUpload MemberUpload */
/* @var $ratingForm RatingForm */

//generate the dashboard menu here
$this->renderPartial('dashboardNav');
$this->beginWidget(
    'bootstrap.widgets.TbModal',
    array('id' => 'ratingModal')
);
?>
<div class="modal-body">
	<?php $this->renderPartial('ratingForm', array('ratingForm' => $ratingForm));?>
</div>

<div class="modal-footer">
	<?php $this->widget(
		'bootstrap.widgets.TbButton',
		array(
			//'context' => 'primary',
			'label' => 'Save changes',
			'url' => '#',
			'htmlOptions' => array('onClick' => '$("#rating-form").submit();'),
		)
	); ?>
	<?php $this->widget(
		'bootstrap.widgets.TbButton',
		array(
			'label' => 'Close',
			'url' => '#',
			'htmlOptions' => array('data-dismiss' => 'modal'),
		)
	); ?>
</div>

<?php $this->endWidget(); ?>
<h1><?php echo $memberUpload->memberUploadTitle;?></h1>
<p><?php echo $memberUpload->memberUploadDescription;?></p>

<div class="row-fluid">
	<span class="pull-left">Rating:&nbsp;</span>
	<?php
	d($memberUpload->rating);
	$this->widget('ext.dzRaty.DzRaty', array(
		'model' => $memberUpload,
		'attribute' => 'rating',
		'htmlOptions' => array(
			'class' => 'pull-left',
		),
		'options' => array(
			'readOnly' => TRUE,
		),
	));
	?>
	
	<button class="btn rate-upload pull-left" data-toggle="modal" data-target="#ratingModal">Rate</button>
</div>
<br/>
<a class="btn btn-large btn-success" href="<?php echo $downloadUrl;?>">Download</a>
