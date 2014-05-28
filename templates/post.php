<!-- NEED TO MODIFY HTML formatting ! -->


<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

			<div class="panel panel-default">
				<div class="panel-heading">
					<h2 class="text-center panel-title"><?php echo $this->data['title']; ?></h2>
				</div>
				<div class="panel-body">
					<?php echo $this->data['body']; ?>
					<br><br>
					<p class = "date">
						Created: <?php echo $this->data['created']; ?> <br>
						<?php if ( ($this->data['created'] != $this->data['modified'])
							&& ($this->data['modified'] != null))
								echo 'Modified: ' . $this->data['modified']; ?>
					</p>
				</div>
			</div>

			<!-- ONLY FOR ADMIN VIEW -->
			<?php $config = Config::getConfig();
			$admin = $config->get('admin','username');
			if ($_SESSION['user'] == $admin) { ?>

				<a href="<?php echo(BASE_URL.DS.'post'.DS.'update');
				if (isset($this->data['id'])) echo '?id='.$this->data['id'];
				?>" class="btn btn-info"><span class="glyphicon
				glyphicon-edit"></span>  Update</a>

				<a href="<?php echo(BASE_URL.DS.'post'.DS.'delete');
				if (isset($this->data['id'])) echo '?id='.$this->data['id'];
				?>" onClick="return confirm('Are you sure you want to delete this post?')"
				class="btn btn-danger"><span class="glyphicon
				glyphicon-remove"></span>  Delete</a>

			<?php } ?>
			<!----------------------->

			<!-- ONLY FOR REGULAR USER VIEW -->
			<?php if (!empty($_SESSION['user'])) { ?>

				<a href="#" class="btn btn-primary"><span class="glyphicon
				glyphicon-comment"></span>  Comment</a>

			<?php } ?>
			<!----------------------->

		</div>
	</div>
</div>
<br>