<!-- NEED TO MODIFY HTML formatting ! -->


<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h3 class="text-center"><?php echo $this->data['title']; ?></h3>
			<?php echo $this->data['body']; ?>
			<p class = "date">
				Created: <?php echo $this->data['created']; ?> <br>
				<?php if ( ($this->data['created'] != $this->data['modified'])
					&& ($this->data['modified'] != null))
						echo 'Modified: ' . $this->data['modified']; ?>
			</p>

			<a href="" class="btn btn-success">Next Post</a>

		</div>
	</div>
</div>