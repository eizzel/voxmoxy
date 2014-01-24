<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<h1>Browse Audio</h2>
<div class="well pull-right">
	<?php 
	$searchAudioFileForm = new SearchAudioFileForm();
	$form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'searchForm',
		'type'=>'inline',
	));
	echo $form->dropDownListRow($searchAudioFileForm, 'attribute', $searchAudioFileForm->attributeList);
	echo $form->textFieldRow($searchAudioFileForm, 'searchText');
	echo CHtml::submitButton('Search', array('class'=>'btn pull-right btn-success'));
	$this->endWidget();	
	?>
</div>

<?php 
$columns = array(
		array('name'=>'memberUploadTitle', 'header'=>'Title'),
		array('name'=>'member.memberUserName', 'header'=>'Author'),
		);

$this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'category-grid',
	'dataProvider' => $dataSource,
	'columns'=>$columns,
	'type'=>'bordered striped'
));
?>
