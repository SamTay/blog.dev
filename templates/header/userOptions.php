<li class="options userOptions dropdown<?php
if (empty($user)) {echo ' hidden';} ?>">
	<a href="" class="dropdown-toggle signout" data-toggle="dropdown"><span class="glyphicon
		glyphicon-off"></span><span id="username-text"> <?php echo $user; ?></span><b class="caret"></b>
	</a>
	<ul class="dropdown-menu">
		<li>
			<a id="logout" href="<?php echo(BASE_URL.DS.'user'.DS.'logout');?>">
				Logout
			</a>
		</li>
	</ul>
</li>