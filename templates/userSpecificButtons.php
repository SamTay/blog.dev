

<div id="userSpecificButtons">
	<!-- Admin Buttons -->
	<a href="<?php echo(BASE_URL.DS.'post'.DS.'update');
	if ($id) echo '?id='.$id;
	?>" class="btn btn-primary options adminOptions<?php if ($user != $admin)
	echo ' hidden';
	?>">
		<span class="glyphicon glyphicon-edit"></span>  Update
	</a>

	<a href="<?php echo(BASE_URL.DS.'post'.DS.'delete');
	if ($id) echo '?id='.$id;
	?>" onClick="return confirm('Are you sure you want to delete this post?')"
	class="btn btn-danger options adminOptions<?php if ($user != $admin)
	echo ' hidden';
	?>">
		<span class="glyphicon glyphicon-remove"></span>  Delete
	</a>

	<!-- User Buttons -->

	<button id="comment-selector" class="btn btn-info options userOptions<?php
	if (!$user) {
		echo ' hidden';
	} ?>">
				<span class="glyphicon glyphicon-comment"></span>  Comment
	</button>

</div>