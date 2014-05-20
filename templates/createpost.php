<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<form role="form" class="myform" method="post" action="<?php echo BASE_URL.DS.'post'.DS.'create'; ?>">

				<?php if (isset($this->data))
					echo $this->data['postError'];
				?>

				<div>
					<label class="form-group" for="postTitle">Title</label>
					<input type="text" class="form-control" id="postTitle" name="postTitle" value="<?php
					if (isset($this->data['postTitle'])) echo htmlspecialchars($this->data['postTitle']); ?>">
				</div>

				<div>
					<label class="form-group" for="postBody">Body</label>
					<textarea class="form-control" rows="15" id="postBody" name="postBody"><?php
						if (isset($this->data)) echo htmlspecialchars($this->data['postBody']);
					?></textarea>
				</div>

				<!-- TO PREVENT BOTS! HIDDEN INPUT! -->
				<div style="display: none;">
						<label for="address">Address</label>
						<input type="text" id="address" name="address">
						<p>Humans, please leave this field blank!</p>
				</div>

				<input type="submit" value="Post" class="btn btn-success">

			</form>
		</div>
	</div>
</div>