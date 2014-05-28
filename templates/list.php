<div class="container">
	<!-- ADJUST THIS TO DYNAMIC ROWS/COLUMNS ACCORDING TO $THIS->DATA -->
	<div class="row">
		<?php $length = 350; ?>
		<?php for($i=0; $i<$this->N; $i++) { ?>
			<div class="col-md-<?php echo($this->colWidth); ?>">
				<h3 class="text-center"><?php echo($this->data[$i]['title']); ?></h3>

				<p>
					<?php if (strlen($this->data[$i]['body']) <= $length) {
						echo $this->data[$i]['body'] . '...';
					} else {
						echo (substr($this->data[$i]['body'],0,$length-5) . '...</div>');
					} ?>
				</p>
				<a href="<?php echo(BASE_URL.'/post/view?id='.$this->data[$i]['id']);?>" class="btn btn-success">Read More</a>
			</div>
		<?php } ?>

	</div>
</div>