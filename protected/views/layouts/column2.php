<?php $this->beginContent('/layouts/main'); ?>
<div class="container">
	<div id="content">
		<?php echo $content; ?>
	</div><!-- content -->
</div>
<div id="sidebar">
	<?php if(!Yii::app()->user->isGuest) $this->widget('UserMenu'); ?>
</div><!-- sidebar -->
<?php $this->endContent(); ?>