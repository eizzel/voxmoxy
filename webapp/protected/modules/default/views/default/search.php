<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
Yii::app()->clientScript->registerScript('search', "
$('#searchForm').submit(function(){
	$('#memberUpload-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});"
);

?>
<h1 class="pull-left">Browse Audio Files</h2>
<div class="well input-prepend input-append pull-right">
	<div class="row-fluid">
	<?php 
	$searchAudioFileForm = new SearchAudioFileForm();
	$form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'searchForm',
		'type'=>'inline',
	));
	echo $form->dropDownListRow($searchAudioFileForm, 'attribute', $searchAudioFileForm->attributeList, array('class' => 'input-small'));
	echo $form->textFieldRow($searchAudioFileForm, 'searchText');
	echo CHtml::submitButton('Search', array('class'=>'btn'));
	$this->endWidget();	
	?>
	</div>
</div>
<div class="clearfix"></div>
<?php 
$columns = array(
		array('name'=>'memberUploadTitle', 'header'=>'Title'),
		array('name'=>'member.memberUserName', 'header'=>'Uploader'),
		);

$this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'memberUpload-grid',
	'dataProvider' => $dataSource,
	'columns'=>$columns,
	'type'=>'bordered striped'
));
?>
