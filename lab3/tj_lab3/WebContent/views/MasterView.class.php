<?php
class MasterView {
	public static function showHeader($title) {
		if (is_null($title))
			$title = "";	
?>	 	
     <!DOCTYPE html>
     <html>
     <head>
     <title><?php echo $title; ?></title>
     </head>
     <body>
     <section>
<?php  
     }
     
     public static function showNav($nav) {
     	$base = (array_key_exists('base', $_SESSION))?$_SESSION['base']:"";
     	if (is_null($nav)){
	     	$nav = 	"<nav>
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
     	}
     	echo $nav;
?>
     </section>
<?php
     }
     public static function showFooter($footer) {
		if (!is_null($footer))
			echo $footer;
?>	 	
    </body>
    </html>
<?php  
     }
}
?>