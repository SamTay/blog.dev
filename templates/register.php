<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-2">
			<h3>Congratulations!</h3>
			<p>This is the only site on the entire internet that doesn't require an email! That means
			no spam, no marketing, none of those bullshit emails!</p>
			<p>I hope you enjoy being able to comment on meaningless blog posts!</p>

		</div>
		<div class="col-md-6">
			<br>
			<form role="form" class="myform" method="post" action="<?php
			echo BASE_URL.DS.'user'.DS.$this->section;?>">

				<div class="form-group row">
					<div class="col-md-7">
						<label for="username">Choose your username</label>
						<input type="text" class="form-control" id="username" name="username" value="<?php
						if (isset($this->data['username'])) echo htmlspecialchars($this->data['username']); ?>">
					</div>
					<span id="usernameFieldMessage" class="col-md-5 hidden"></span>
				</div>

				<div class="form-group row">
					<div class="col-md-7">
						<label for="password">Create a password</label>
						<input type="password" class="form-control" id="password" name="password">
					</div>
					<span id="passwordFieldMessage" class="col-md-5 hidden"></span>
				</div>

				<div class="form-group row">
					<div class="col-md-7">
						<label for="passwordCheck">Confirm your password</label>
						<input type="password" class="form-control" id="passwordCheck" name="passwordCheck">
					</div>
					<span id="passwordCheckFieldMessage" class="col-md-5 hidden"></span>
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