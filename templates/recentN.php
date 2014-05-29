<div class="container">
    <div class="row">
		<?php $length = 350; ?>
		<?php for($i=0; $i<$this->N; $i++) { ?>
			<div class="col-md-<?php echo($this->colWidth); ?>">
				<h3 class="text-center"><?php echo($this->data[$i]['title']); ?></h3>

				<p>
					<?php
					$cleanBody = str_replace(array('<div>', '</div>'), '', $this->data[$i]['body']);
					echo substr($cleanBody, 0, $length) . '...';
					?>
				<a href="<?php echo(BASE_URL.'/post/view?id='.$this->data[$i]['id']);?>" class="label label-info">Read More</a>
				</p>
			</div>
		<?php } ?>

    </div>
</div>