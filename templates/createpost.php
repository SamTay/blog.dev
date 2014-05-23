<?php if (isset($this->data['postError'])) { ?>
	<div class="container-fluid">
		<div class="col-md-4 col-md-offset-4 alert alert-danger alert-dismissable">
			<button type="button" class="close" aria-hidden="true">&times;</button>
			<p><strong><?php echo $this->data['postError']; ?></strong></p>
		</div>
	</div>
<?php } ?>

<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<form role="form" class="myform" method="post" action="<?php
				echo BASE_URL.DS.'post'.DS.$this->section;
				if (isset($this->data['id'])) echo '?id=' . $this->data['id'];
			?>">

				<div class="form-group">
					<label for="postTitle">Title</label>
					<input type="text" class="form-control" id="postTitle" name="postTitle" value="<?php
					if (isset($this->data['postTitle'])) echo htmlspecialchars($this->data['postTitle']); ?>">
				</div>

				<div class="form-group">
					<label for="postBody">Body</label>
					<textarea class="form-control" rows="15" id="postBody" name="postBody"><?php /* NOTE THAT htmlspecialchars() WOULD NOT ALLOW BODY TO SHOW! */
						if (isset($this->data['postBody'])) echo $this->data['postBody'];
					?></textarea>
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