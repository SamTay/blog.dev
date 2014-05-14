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
    </head>
    <body>
        <nav class="navbar-wrapper navbar-default navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Coding Blog</a>
                </div>

                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="#"><span class="glyphicon glyphicon-home"></span> Home</a></li>
                        <li><a href="#"><span class="glyphicon glyphicon-star"></span> Top Posts</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> About Me<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Details</a></li>
                                <li><a href="#">Contact</a></li>
                            </ul>
                        </li>
                    </ul>
                    <form class="navbar-form navbar-right" role="search">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Search">
                        </div>
                        <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
                    </form>

                    <!-- NOTE that this section should only be visible to the admin -->
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#"><span class="glyphicon glyphicon-asterisk"></span> New Post</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon
                            glyphicon-edit"></span> Edit Post<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Delete</a></li>
                                <li><a href="#">Update</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>

            </div>
        </nav>
