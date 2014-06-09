<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title">Comments (<?php echo count($this->data['comments']);?>)</h3>
				</div>
				<div id="user-specific-comment">
					<ul id="user-specific-comment-contents" class="list-group">
						<?php foreach($this->data['comments'] as $comment) { ?>
							<li class="list-group-item">
								<p><strong><?php echo $comment->username.": "; ?></strong></p>
								<p><?php echo $comment->comment; ?></p>
								<p class = "date"><?php echo $comment->created; ?></p>
							</li>
						<?php } ?>

						<?php if (SessionModel::get('user')) { ?>
						<li role="form" class="list-group-item">
							<form method="post" action="<?php
							echo BASE_URL.DS.'post'.DS.'comment?id='.$this->data['post']->id;?>">
								<div class="form-group">
									<label for="comment"><?php echo SessionModel::get('user') . ":"; ?></label>
									<a id="comment"><textarea class="halfthebuttons form-control" rows="4" id="comment" name="comment"></textarea></a>
								</div>
								<input type="submit" value="Comment" class="btn btn-info">
							</form>
						</li>
						<?php } ?>
					</ul>
				</div>
			</div>



		</div>
	</div>
</div>