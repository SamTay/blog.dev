<?php if (isset($this->data['Error'])) { ?>
	<div class="container-fluid">
		<div class="col-md-4 col-md-offset-4 alert alert-danger alert-dismissable">
			<button type="button" class="close" aria-hidden="true">&times;</button>
			<p><strong><?php echo $this->data['Error']; ?></strong></p>
		</div>
	</div>
<?php } ?>

<div class="container">
	<div class="row">

		<div class="col-md-4 col-md-offset-4">
			<br>
			<form role="form" class="myform" method="post" action="<?php
			echo BASE_URL.DS.'user'.DS.$this->section;?>">

				<div class="form-group">
					<label for="username">Username</label>
					<input type="text" class="form-control" id="username" name="username" value="<?php
					if (isset($this->data['username'])) echo htmlspecialchars($this->data['username']); ?>">
				</div>

				<div class="form-group">
					<label for="password">Password</label>
					<input type="text" class="form-control" id="password" name="password">
				</div>

				<!-- TO PREVENT BOTS! HIDDEN INPUT! -->
				<div style="display: none;">
					<label for="address">Address</label>
					<input type="text" id="address" name="address">
					<p>Humans, please leave this field blank!</p>
				</div>

				<input type="submit" value="<?php echo ucwords($this->section); ?>" class="btn btn-success">

			</form>
		</div>
	</div>
</div>