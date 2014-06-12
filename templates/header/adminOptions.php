<?php $config = Config::getConfig();
$admin = $config->get('admin','username');
?>

<li class="adminOptions options<?php
	if ($user != $admin) echo ' hidden';
	if(!empty($section) && $section === 'create') echo(' active');
?>">
	<a href="<?php echo(BASE_URL.DS.'post'.DS.'create');?>">
		<span class="glyphicon glyphicon-asterisk"></span>
		New Post
	</a>
</li>