<?php
class MasterView {
	public static function showHeader() {
?>	 	
     <!DOCTYPE html>
     <html>
     <head>
     <meta charset="utf-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
     <?php 
	     $styles = (array_key_exists('styles', $_SESSION))? $_SESSION['styles']: array();
	     $base = (array_key_exists('base', $_SESSION))? $_SESSION['base']: "";
	     foreach ($styles as $style )
	     	echo '<link href="/'.$base.'/css/'.$style. '" rel="stylesheet">';
	     $title = (array_key_exists('headertitle', $_SESSION))? $_SESSION['headertitle']: "";
     ?>
     <title><?php echo $title; ?></title>
     </head>
     <body>
<?php  
     }
     
     public static function showNav() {
     	$base = (array_key_exists('base', $_SESSION))?$_SESSION['base']:"";
     	$authenticatedUser = (array_key_exists('authenticatedUser', $_SESSION))?$_SESSION['authenticatedUser']:null;
     	$user = (array_key_exists('user', $_SESSION))?$_SESSION['user']:null;
     	echo '<nav class="navbar navbar-inverse navbar-fixed-top">';
     	echo '<div class="container-fluid">';
     	echo '<div class="navbar-header">';
     	echo '<button type="button" class="navbar-toggle collapsed"';
     	echo 'data-toggle="collapse" data-target="#navbar"';
     	echo 'aria-expanded="false" aria-controls="navbar">';
     	echo '<span class="icon-bar"></span>';
     	echo '<span class="icon-bar"></span>';
     	echo '<span class="icon-bar"></span>';
     	echo '</button>';
     	echo '<a class="navbar-brand" href="/'.$base.'/">HockLeague</a>';
     	echo '</div>';
     	echo '<div id="navbar" class="navbar-collapse collapse">';
     	echo '<ul class="nav navbar-nav">';
     	if (!is_null($authenticatedUser))
     		echo '<li class="active"><a href="/'.$base.'/user/show/' . $authenticatedUser->getUserName().'">Profile</a></li>';
     	echo '<li><a href="/'.$base.'/user/leaderboard">Leaderboard</a></li>';
     	echo '<li><a href="/'.$base.'/bet">Betting</a></li>';
     	echo '<li><a href="/'.$base.'/game/all">All Games</a></li>';
     	echo '</ul>';
     	if (!is_null($authenticatedUser)) {
     		echo '<form class="navbar-form navbar-right"
    			    method="post" action="/'.$base.'/logout">';
     		echo '<div class="form-group">';
     		echo '<span class="label label-default">Hi '.
     				$authenticatedUser->getUserName().'</span>&nbsp; &nbsp;';
     		echo '</div>';
     		echo '<button type="submit" class="btn btn-success">Sign out</button>';
     		echo '</form>';
     	} else {
     		echo '<form class="navbar-form navbar-right"
	    			    method="post" action="/'.$base.'/login">';
     		echo '<div class="form-group">';
     		echo '<input type="text" placeholder="User name" class="form-control" name ="userName" ';
     		if (!is_null($user))
     			echo 'value = "'. $user->getUserName();
     		echo 'required></div>';
     		echo '<div class="form-group">';
     		echo '<input type="password" placeholder="Password"
	    			      class="form-control" name ="password">';
     		echo '</div>';
     		echo '<button type="submit" class="btn btn-success">Sign in</button>';
     		echo '<a class="btn btn-primary" href="/'.$base.'/signup" role="button">Register</a></p>';
     		echo '</form>';
     	}
     	
     	echo '</div>';
     	echo '</div>';
     	echo '</nav>';
     	
     	/*$nav = 	"<nav>
		<a href='/".$base."/signup'>Register</a> |
		<a href='/".$base."/login'>Login</a> |
		<a href='/".$base."/user/leaderboard'>Leaderboard</a> |
		<a href='/".$base."/bet'>Betting</a> |
		<a href='/".$base."/games.html'>Recent Games</a> |
		<a href='/".$base."/tests.html'>Tests</a> |
		<a href='/".$base."/validation.html'>Validation</a>
		</nav>
  		<section>
		<a href='/".$base."/home'><img src='/".$base."/resources/Drawing.png' alt='Home'></a>
		</section>";
     	echo $nav;*/
?>


<?php
     }
     public static function showFooter() {
		$footer = (array_key_exists('footertitle', $_SESSION))?
		           $_SESSION['footertitle']: "";
		echo '<footer>'.$footer.'</footer>';	
     }
     
     public static function showHomeFooter() {
     	echo '<footer>';
     	echo '<p>&copy; Joshua Trivette, UTSA 2015</p>';
     	echo '<p>Contact Information: <a href="mailto:joshuatrivette@gmail.com">joshuatrivette@gmail.com</a>';
     	echo '</footer>';
     }
     
     public static function showPageEnd() {
     	echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>';
     	echo '<script src="../../dist/js/bootstrap.min.js"></script>';
     	echo '<script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>';
     	echo '</body></html>';
     }
}
?>