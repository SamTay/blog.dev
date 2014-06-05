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
							<li <?php if($section === 'home') echo('class="active"'); ?>>
								<a href="<?php echo(BASE_URL); ?>"><span class="glyphicon glyphicon-home"></span> Home</a>
							</li>
                            <li <?php if($section === 'list-popularity') echo('class="active"'); ?>>
								<a href="<?php echo(BASE_URL.DS.'list?sort=popularity'); ?>"><span class="glyphicon glyphicon-star"></span> Top Posts</a>
							</li>
                            <li class="dropdown <?php if($section === 'about' || $section === 'contact') echo('active'); ?>">
                                <a href="<?php echo(BASE_URL.DS.'about'.DS.'details'); ?>" class="dropdown-toggle"
                                data-toggle="dropdown"><span class="glyphicon glyphicon-info-sign"></span>  About Me<b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="<?php echo(BASE_URL.DS.'about'.DS.'details');?>">Details</a></li>
                                    <li><a href="<?php echo(BASE_URL.DS.'about'.DS.'contact');?>">Contact</a></li>
                                </ul>
                            </li>
                        </ul>


                        <form class="navbar-form navbar-right" role="search" method="post" action="<?php echo BASE_URL.DS.'list'.DS.'search'; ?>">
                            <div class="form-group">
                                <input type="text" class="form-control" name="needle" placeholder="Search">
                            </div>
							<input type="submit" value="Search">
                            <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>

                        </form>

						<ul class="nav navbar-nav navbar-right">
						<!---------------------------------------- ANONYMOUS -------------------------------------->
						<?php if (empty($_SESSION['user'])) { ?>

							<li class="dropdown">
								<a href="" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon
								glyphicon-user"></span> Login<b class="caret"></b></a>
								<form class="dropdown-menu" role="form" method="post" action="<?php
								echo (BASE_URL.DS.'user'.DS.'login'); ?>">
									<div class="form-group">
										<input type="text" class="form-control" id="username" name="username" placeholder="Username">
									</div>
									<div>
										<input type="password" class="form-control" id="password" name="password" placeholder="Password">
									</div>
									<input type="submit" value="Login" class="btn btn-success">
								</form>
							</li>

							<li <?php if($section === 'register') echo('class="active"'); ?>><a href="<?php echo(BASE_URL.DS.'user'.DS.'register');?>">
									<span class="glyphicon glyphicon-asterisk"></span>
									Register
								</a>
							</li>

						<?php } ?>

                        <!------------------------------------ ADMIN USER ---------------------------------------------------->
						<?php $config = Config::getConfig();
						$admin = $config->get('admin','username');
						if (SessionModel::get('user') == $admin) { ?>
							<li <?php if($section === 'create') echo('class="active"'); ?>><a href="<?php echo(BASE_URL.DS.'post'.DS.'create');?>">
									<span class="glyphicon glyphicon-asterisk"></span>
									New Post
							</a></li>
						<?php } ?>
						<!--------------------------------------------------------------------------------------------------->

						<!------------------------------------ REGULAR USER ---------------------------------------------------->
						<?php if (!empty(SessionModel::get('user')) && SessionModel::get('user') != $admin) {}

							/* Decide if regular users will have any extra action here */
						 ?>
						<!--------------------------------------------------------------------------------------------------->

						<!------------------------------------ ALL USERS SIGNED IN ---------------------------------------------------->
						<?php if (SessionModel::get('user')) { ?>
						<li class="dropdown">
								<a href="" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon
								glyphicon-off"></span> <?php echo($_SESSION['user']); ?><b class="caret"></b></a>
								<ul class="dropdown-menu">
									<li><a href="<?php echo(BASE_URL.DS.'user'.DS.'logout');?>">
											Logout
									</a></li>
								</ul>
						</li>

						<?php } ?>
						<!--------------------------------------------------------------------------------------------------->
						</ul>

                    </div>

                </div>
            </nav>
        <!-- div element closed in start of footer! -->

			<!-- If there is a message to user -->
			<?php if (!empty($_SESSION['msg'])) { ?>
				<div class="container-fluid">
						<div class="col-md-4 col-md-offset-4 alert alert-<?php echo !empty($_SESSION['msg-tone'])
							? $_SESSION['msg-tone'] : 'success';  ?> alert-dismissable">
							<button type="button" class="close" aria-hidden="true">&times;</button>
							<p><strong><?php echo $_SESSION['msg']; ?></strong></p>
						</div>
				</div>
			<?php }
				unset($_SESSION['msg']);
				unset($_SESSION['msg-tone']);
			?>
