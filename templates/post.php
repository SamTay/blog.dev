<!-- NEED TO MODIFY HTML formatting ! -->
<?php
$id = $this->data['post']->id;
$title = $this->data['post']->title;
$body = $this->data['post']->body;
$created = $this->data['post']->created;
$modified = $this->data['post']->modified;

$config = Config::getConfig();
$admin = $config->get('admin','username');
$user = SessionModel::get('user');

?>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

			<div class="panel panel-success">
				<div class="panel-heading">
					<h2 class="text-center panel-title"><?php echo $title; ?></h2>
				</div>
				<div class="panel-body">
					<?php echo $body; ?>
					<br><br>
					<p class = "date">
						Created: <?php echo $created; ?> <br>
						<?php if ( ($created != $modified)
							&& ($modified != false))
								echo 'Modified: ' . $modified; ?>
					</p>
				</div>
			</div>

			<!-- Only non-intrusive place for the comments anchor tag -->
			<a id="comments"></a>

			<!-- Include appropriate buttons -->
			<?php include(ROOT.DS.'templates'.DS.'userSpecificButtons.php'); ?>

		</div>
	</div>
</div>
<br>