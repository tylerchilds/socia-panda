<!DOCTYPE html>
<html>
	<head>
            <title><?php echo $title ?></title>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <!-- Bootstrap -->
            <link href="/css/bootstrap.min.css" rel="stylesheet">
            <link href="/css/bootstrap-responsive.min.css" rel="stylesheet">
            <link href="/css/jquery.ias.css" rel="stylesheet">
            <link href="/css/custom.css" rel="stylesheet">
            <?php 
                if($this->session->userdata('logged_in') != TRUE):
                    echo $this->engage->script();
                endif;
            ?>
	</head>
	<body>
            <div class="navbar navbar-inverse header">
                <div class="navbar-inner">
                    <div class="container-fluid">
                        <h1 class="branding pull-left"><a href="/"><span class="socia">Socia</span><span class="panda">Panda</span></a></h1>
                        <form class="navbar-search pull-right" action="">
                          <input type="text" class="search-query span2" placeholder="Search">
                        </form>
                    </div>
                </div>
            </div>
            <div class="navbar">
                <div class="navbar-inner">
                    <div class="container-fluid">
                        <?php if($this->session->userdata('logged_in') == TRUE): ?>
                        
                        <a href="/user/profile/<?php echo $this->session->userdata('alias') ?>">
                            <img class="pull-left nav-thumb" src="/image.php/<?php echo $this->session->userdata('humanoid') ?>.jpg?width=32&amp;height=32amp;cropratio=1:1&amp;image=<?php echo $this->session->userdata('photo') ?>" alt="profile picture" />
                        </a>
                            
                        <ul class="nav hidden-phone">
                            <li><a href="/user/profile/<?php echo $this->session->userdata('alias') ?>">
                              <?php echo $this->session->userdata('alias') ?>
                            </a></li>
                            <li><a href="/messages/">Messages</a></li>
                            <li><a href="/user/account/">Account</a></li>
                            <li><a href="/logout">Sign Out</a></li>
                        </ul>
                        
                        <div class="btn-group visible-phone pull-left">
                            
                            <a class="btn btn-primary" href="/user/profile/<?php echo $this->session->userdata('alias') ?>">
                              <?php echo $this->session->userdata('alias') ?>
                            </a>
                            <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                              <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="/messages/">Messages</a></li>
                                <li><a href="/user/account/">Account</a></li>
                                <li><a href="/logout">Sign Out</a></li>
                            </ul>
                        </div> 

                        <?php else: ?>
                            <div class="nav">
                                <!--<a href="/auth/login" class="btn btn-primary">Login</a> 
                                <a href="/auth/register" class="btn btn-primary">Register</a>-->
                                <a class="rpxnow btn btn-primary" onclick="return false;" href="https://sociapanda.rpxnow.com/openid/v2/signin?token_url=http://www.sociapanda.com/auth/open_id/">Sign in</a>
                            </div>
                        <?php endif; ?>

                        
                                
                        <div class="btn-group pull-right">
                            <a class="btn btn-primary" href="/posts">Posts</a>
                            <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                <i class="icon-filter icon-white"></i>
                              <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a tabindex="-1" href="/posts/view/humor/">Humor</a></li>
                                <li><a tabindex="-1" href="/posts/view/movies/">Movies</a></li>
                                <li><a tabindex="-1" href="/posts/view/music/">Music</a></li>
                            </ul>
                        </div>        
                              
                    </div>
                </div>
            </div>
            <div class="container-fluid the-content">
                <div class="row-fluid">
