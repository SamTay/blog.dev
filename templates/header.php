<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo($title); ?></title>

        <!-- Bootstrap -->
        <link href="<?php echo(BASE_URL.DS.'assets'.DS.'css'.DS.'bootstrap.css'); ?>" rel="stylesheet"
              media="screen">
		<link rel="shortcut icon" href="<?php echo (BASE_URL.DS.'assets'.DS.'img'.DS); ?>favicon.ico">
    </head>
    <body>
        <div class="page-wrap">
            <nav class="navbar-wrapper navbar-default navbar-fixed-top" role="navigation">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="<?php echo(BASE_URL); ?>">Coding Blog</a>
                    </div>

                    <div class="collapse navbar-collapse navbar-ex1-collapse">
                        <ul class="nav navbar-nav">
							<li <?php if($section === 'home') echo('class="active"'); ?>><a href="<?php echo(BASE_URL); ?>"><span class="glyphicon glyphicon-home"></span> Home</a></li>
                            <li <?php if($section === 'topposts') echo('class="active"'); ?>><a href="#"><span class="glyphicon glyphicon-star"></span> Top Posts</a></li>
                            <li class="dropdown <?php if($section === 'about' || $section === 'contact') echo('active'); ?>">
                                <a href="<?php echo(BASE_URL.DS.'about'.DS.'details'); ?>" class="dropdown-toggle"
                                data-toggle="dropdown"><span class="glyphicon glyphicon-info-sign"></span>  About Me<b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="<?php echo(BASE_URL.DS.'about'.DS.'details');?>">Details</a></li>
                                    <li><a href="<?php echo(BASE_URL.DS.'about'.DS.'contact');?>">Contact</a></li>
                                </ul>
                            </li>
                        </ul>


                        <form class="navbar-form navbar-right" role="search">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Search">
                            </div>
                            <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
                        </form>

						<!---------------------------------------- ANONYMOUS -------------------------------------->
						<?php if ('$session' == '$session') { ?>
							<ul class="nav navbar-nav navbar-right">

								<li class="dropdown">
									<a href="" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon
									glyphicon-user"></span> Login<b class="caret"></b></a>
									<form class="dropdown-menu" role="form" method="post" action="<?php
									echo (BASE_URL.DS.'user'.DS.'login'); ?>">
										<div class="form-group">
											<label for="username"> Username </label>
											<input type="text" class="form-control" id="username" name="username">
										</div>
										<div>
											<label for="password"> Password </label>
											<input type="text" class="form-control" id="password" name="password">
										</div>
										<input type="submit" value="Login" class="btn btn-success">
									</form>
								</li>

								<li <?php if($section === 'register') echo('class="active"'); ?>><a href="<?php echo(BASE_URL.DS.'user'.DS.'register');?>">
										<span class="glyphicon glyphicon-asterisk"></span>
										Register
									</a>
								</li>

							</ul>
						<?php } ?>

                        <!------------------------------------ ADMIN ---------------------------------------------------->
						<?php if ('$session' == 'admin') { ?>
							<ul class="nav navbar-nav navbar-right">
								<li <?php if($section === 'create') echo('class="active"'); ?>><a href="<?php echo(BASE_URL.DS.'post'.DS.'create');?>">
										<span class="glyphicon glyphicon-asterisk"></span>
										New Post
								</a></li>

								<?php if ($section == 'postview') { ?>
									<li class="dropdown">
										<a href="" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon
										glyphicon-edit"></span> Edit Post<b class="caret"></b></a>
										<ul class="dropdown-menu">
											<li>
												<a href="<?php echo(BASE_URL.DS.'post'.DS.'update');
													if (isset($this->data['id'])) echo '?id='.$this->data['id'];
												?>">Update</a>
											</li>
											<li>
												<a href="<?php echo(BASE_URL.DS.'post'.DS.'delete');
													if (isset($this->data['id'])) echo '?id='.$this->data['id'];
												?>" onClick="return confirm('Are you sure you want to delete this post?')">Delete</a>
											</li>
										</ul>
									</li>
								<?php } ?>
							</ul>
						<?php } ?>
						<!--------------------------------------------------------------------------------------------------->

                    </div>

                </div>
            </nav>
        <!-- div element closed in start of footer! -->

			<!-- If there is a message to user -->
			<?php $registry = Registry::getInstance();
			if (!is_null($registry->get('msg'))) { ?>
				<div class="container-fluid">
<!--					<div class="row">-->
						<div class="col-md-4 col-md-offset-4 alert alert-success alert-dismissable">
							<button type="button" class="close" aria-hidden="true">&times;</button>
							<p><strong><?php echo $registry->get('msg'); ?></strong></p>
						</div>
<!--					</div>-->
				</div>
			<?php } ?>
