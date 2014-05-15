
    </div> <!-- closes the page-wrap div -->

        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-md-4">&copy; 2014</div>
                    <div class="col-md-4">
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
                    <div class="col-md-4">
                        <h3 class="text-right">Coding Blog</h3>
                    </div>
                </div>
            </div>
        </footer>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="//code.jquery.com/jquery.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="<?php echo(BASE_URL.DS.'assets'.DS.'js'.DS.'bootstrap.min.js'); ?>"></script>
    </body>
</html>