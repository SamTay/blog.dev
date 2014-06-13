
    </div> <!-- closes the page-wrap div -->

        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-xs-6 col-xs-offset-3 myfooter">
                        <ul class="nav nav-pills">
                            <li <?php if($section === 'about') echo('class="active"'); ?>>
								<a href="<?php echo (BASE_URL.DS.'about'.DS.'details');?>">About</a>
							</li>
                            <li <?php if($section === 'home') echo('class="active"'); ?>>
								<a href="<?php echo(BASE_URL);?>">Home</a>
							</li>
                            <li <?php if($section === 'contact') echo('class="active"'); ?>>
								<a href="<?php echo(BASE_URL.DS.'about'.DS.'contact');?>">Contact</a>
							</li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>

		<link rel="stylesheet" type="text/css" href="<?php echo(BASE_URL.DS.'assets'.DS.'css'.DS.'bootstrap-wysihtml5.css'); ?>" />
		<script src="//code.jquery.com/jquery.js"></script>
		<script src="<?php echo(BASE_URL.DS.'assets'.DS.'js'.DS.'wysihtml5-0.3.0.js');?>" type="text/javascript"></script>
		<script src="<?php echo(BASE_URL.DS.'assets'.DS.'js'.DS.'bootstrap.min.js'); ?>"></script>
		<script src="<?php echo(BASE_URL.DS.'assets'.DS.'js'.DS.'bootstrap3-wysihtml5.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo(BASE_URL.DS.'assets'.DS.'js'.DS.'settings.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo(BASE_URL.DS.'assets'.DS.'js'.DS.'message-management.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo(BASE_URL.DS.'assets'.DS.'js'.DS.'access-management.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo(BASE_URL.DS.'assets'.DS.'js'.DS.'ajax-user-management.js'); ?>" type="text/javascript"></script>
	</body>
</html>

