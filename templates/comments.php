<?php
$user = SessionModel::get('user');

$id = $this->data['post']->id;

$comments = $this->data['comments'];
?>

<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div  id="user-specific-comment" class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title">Comments (<?php echo count($comments);?>)</h3>
				</div>
					<ul class="list-group">
						<?php foreach($comments as $comment) { ?>
							<li class="list-group-item">
								<p><strong><?php echo $comment->username.": "; ?></strong></p>
								<p><?php echo $comment->comment; ?></p>
								<p class = "date"><?php echo $comment->created; ?></p>
							</li>
						<?php } ?>

						<li role="form" class="list-group-item options userOptions<?php
						if (!$user) {
							echo ' hidden';
						}
						?>">
							<form id="comment-form" method="post" action="<?php
							echo BASE_URL.DS.'post'.DS.'comment?id='.$id;?>">
								<div class="form-group">
									<label for="comment"><span class="username-text"><?php echo $user; ?></span>:</label>
									<textarea class="halfthebuttons form-control" rows="4" id="comment" name="comment"></textarea>
								</div>
								<input type="submit" value="Comment" class="btn btn-info">
							</form>
						</li>
					</ul>
			</div>



		</div>
	</div>
</div>