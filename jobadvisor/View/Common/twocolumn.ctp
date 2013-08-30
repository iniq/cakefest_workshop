<?php $this->layout = 'default'; ?>
<div class="row-fluid">
	<div class="span6 left-column">
		<?php echo $this->fetch('left-column'); ?>
	</div>
	<div class="span6 right-column">
		<?php echo $this->fetch('right-column'); ?>
	</div>
</div>
<?php echo $this->fetch('content'); ?>
<?php
// then just fill the blocks for left-column, right-column in any inheriting view.