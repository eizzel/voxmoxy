<?php
/* @var $this CategoryController */
/* @var $model Category */

$this->breadcrumbs=array(
	'Categories'=>array('index'),
	$model->categoryId=>array('view','id'=>$model->categoryId),
	'Update',
);

$this->menu=array(
	array('label'=>'Manage Category', 'url'=>array('admin')),
);
?>

<h1>Update Category <?php echo $model->categoryId; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>