<!DOCTYPE html>

<?php
$sessionMsg = SessionModel::get('msg');
$sessionMsgTone = SessionModel::get('msg-tone');
unset($_SESSION['msg']);
unset($_SESSION['msg-tone']);

$user = SessionModel::get('user');


?>
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


                        <form id="search" class="navbar-form navbar-right" role="search" method="post" action="<?php echo BASE_URL.DS.'list'.DS.'search'; ?>">
                            <div class="form-group">
                                <input type="text" class="form-control" name="needle" placeholder="Search">
                            </div>
							<input style="display: none" type="submit" value="Search">
                            <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>

                        </form>

							<ul id="user-specific-header" class="nav navbar-nav navbar-right">
							<!---------------------------------------- ANONYMOUS -------------------------------------->
							<?php if (empty($user)) {
								include_once(ROOT.DS.'templates'.DS.'header'.DS.'anonymousOptions.php');
							} ?>

							<!------------------------------------ ADMIN USER ---------------------------------------------------->
							<?php $config = Config::getConfig();
							$admin = $config->get('admin','username');
							if ($user == $admin) {
								include_once(ROOT.DS.'templates'.DS.'header'.DS.'adminOptions.php');
							} ?>
							<!--------------------------------------------------------------------------------------------------->

							<!------------------------------------ REGULAR USER ---------------------------------------------------->
							<?php if ($user && $user != $admin) {}

								/* Decide if regular users will have any extra action here */
							 ?>
							<!--------------------------------------------------------------------------------------------------->

							<!------------------------------------ ALL USERS SIGNED IN ---------------------------------------------------->
							<?php if ($user) {
								include_once(ROOT.DS.'templates'.DS.'header'.DS.'userOptions.php');
							} ?>
							<!--------------------------------------------------------------------------------------------------->
						</ul>
                    </div>

                </div>

			<!-- </nav> element closed within sessionMessage template -->
			<?php include_once(ROOT.DS.'templates'.DS.'header'.DS.'sessionMessage.php'); ?>

		<!-- </div> element closed in start of footer! -->