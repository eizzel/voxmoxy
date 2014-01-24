<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<div class="hero-unit" style="height: 500px;">
	<h1>Welcome to <?php echo Yii::app()->name;?></h1>
	<p>[describe our service here]</p>
	<a href="<?php echo $this->createUrl('/search');?>" class="btn btn-primary btn-large btn-block span3 pull-left">Browse Audio Files</a>
</div>
<div class="clearfix"></div>
<div class="row-fluid">
	<div class="span4">
		<div class="well" style="height: 100px;"></div>
	</div>
	<div class="span4">
		<div class="well" style="height: 100px;"></div>
	</div>
	<div class="span4">
		<div class="well" style="height: 100px;"></div>
	</div>
</div>

<div class="clearfix"></div>
