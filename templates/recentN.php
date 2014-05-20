<div class="container">
    <div class="row">

		<?php for($i=0; $i<$this->N; $i++) { ?>
			<div class="col-md-<?php echo($this->colWidth); ?>">
				<a href="#"><img class="img-responsive img-circle" src="images/feat1.jpg"></a>
				<h3 class="text-center"><?php echo($this->data[$i]['title']); ?></h3>

				<p><?php echo(substr($this->data[$i]['body'],0,350)); ?>...</p>

				<a href="<?php echo(BASE_URL.'/post/view?id='.$this->data[$i]['id']);?>" class="btn btn-success">Read More</a>
			</div>
		<?php } ?>

    </div>
</div>