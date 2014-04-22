<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>

<div class="span2">
	<div id="sidebar">
		<?php
			if($this->clips['categories'])
			{
				echo '<h4>Categories</h4>';
				echo $this->clips['categories'];
			}
		?>
		<?php
			if($this->clips['dashboardNav'])
			{
				echo $this->clips['dashboardNav'];
			}
		?>
	</div><!-- sidebar -->
</div>
<div class="span10">
	<div>
		<?php echo $content; ?>
	</div><!-- content -->
</div>
<?php $this->endContent(); ?>

