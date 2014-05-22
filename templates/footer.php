
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

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="//code.jquery.com/jquery.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="<?php echo(BASE_URL.DS.'assets'.DS.'js'.DS.'bootstrap.min.js'); ?>"></script>
		<script>
			$(".alert button.close").click(function (e) {
				$(this).parent().slideUp(300);
			});
		</script>
	</body>
</html>

