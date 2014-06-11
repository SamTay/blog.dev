<!-- NEED TO MODIFY HTML formatting ! -->


<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

			<div class="panel panel-success">
				<div class="panel-heading">
					<h2 class="text-center panel-title"><?php echo $this->data['post']->title; ?></h2>
				</div>
				<div class="panel-body">
					<?php echo $this->data['post']->body; ?>
					<br><br>
					<p class = "date">
						Created: <?php echo $this->data['post']->created; ?> <br>
						<?php if ( ($this->data['post']->created != $this->data['post']->modified)
							&& ($this->data['post']->modified != null))
								echo 'Modified: ' . $this->data['post']->modified; ?>
					</p>
				</div>
			</div>

			<!-- Only non-intrusive place for the comments anchor tag -->
			<a id="comments"></a>

			<div id="user-specific-options">
				<!-- ONLY FOR ADMIN VIEW -->
				<?php $config = Config::getConfig();
				$admin = $config->get('admin','username');
				if (SessionModel::get('user') == $admin) { ?>

					<a href="<?php echo(BASE_URL.DS.'post'.DS.'update');
					if ($this->data['post']->id) echo '?id='.$this->data['post']->id;
					?>" class="btn btn-primary"><span class="glyphicon
					glyphicon-edit"></span>  Update</a>

					<a href="<?php echo(BASE_URL.DS.'post'.DS.'delete');
					if ($this->data['post']->id) echo '?id='.$this->data['post']->id;
					?>" onClick="return confirm('Are you sure you want to delete this post?')"
					class="btn btn-danger"><span class="glyphicon
					glyphicon-remove"></span>  Delete</a>

				<?php } ?>
				<!----------------------->

				<!-- ONLY FOR REGULAR USER VIEW -->
				<?php if (SessionModel::get('user')) { ?>

					<button id="comment-selector" class="btn btn-info"><span class="glyphicon
					glyphicon-comment"></span>  Comment</button>

				<?php } ?>
				<!----------------------->
			</div>

		</div>
	</div>
</div>
<br>