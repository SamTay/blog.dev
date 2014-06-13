<li class="anonymousOptions options dropdown<?php if (!empty($user)) echo ' hidden'; ?>">
	<a id="login-dropdown" href="" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon
									glyphicon-user"></span> Login<b class="caret"></b></a>
	<form id="login" class="dropdown-menu" role="form" method="post" action="<?php
	echo (BASE_URL.DS.'user'.DS.'login'); ?>">
		<div class="form-group">
			<input type="text" class="form-control" id="username" name="username" placeholder="Username">
		</div>
		<div>
			<input type="password" class="form-control" id="password" name="password" placeholder="Password">
		</div>
		<input type="hidden" id="ajax" name="ajax" value="true">
		<input type="submit" value="Login" class="btn btn-success">
	</form>
</li>

<li class="anonymousOptions options<?php
	if(!empty($user)) echo ' hidden';
	if(!empty($section) && $section === 'register') echo(' active');?>">
	<a href="<?php echo(BASE_URL.DS.'user'.DS.'register');?>">
		<span class="glyphicon glyphicon-asterisk"></span> Register
	</a>
</li>