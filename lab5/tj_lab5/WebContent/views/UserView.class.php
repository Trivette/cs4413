<?php  
class UserView {

	public static function showAll() {
		// Show a table of users with links
		$_SESSION['headertitle'] = "Leaderboard";
		$_SESSION['styles'] = array('jumbotron.css', 'leaderboard.css');
		MasterView::showHeader();
		MasterView::showNav();
		//if (array_key_exists('headertitle', $_SESSION)) {
		//	MasterView::showHeader();
		//	MasterView::showNav();
		//}
		UserView::showLeaderboard();
		if (array_key_exists('footertitle', $_SESSION))
			MasterView::showFooter();
		MasterView::showPageEnd();
	}
	
	public static function showLeaderboard() {
		$users = (array_key_exists('users', $_SESSION))?$_SESSION['users']:array();
		$base = (array_key_exists('base', $_SESSION))?$_SESSION['base']:"";
		echo '<script src="/'.$base.'/js/sorttable.js"></script>';
		echo '<div class="container">';
		echo "<h1>Hock League Ranks</h1>";
		echo '<div class="table-responsive">';
		echo '<table class="table" border="1">';
		echo "<thead>";
		echo "<tr><TH>Rank</th><th>Name</th><th>Skill</th><th>Wins</th><th>Losses</th><th>Total Games</th><th>Goals</th><th>Assists</th><th>Own Goals</th><th>GPG</th><th>APG</th><th>OGPG</th><TH>Bads</th><TH>Streak</th><th>Alias</th></tr>";
		echo "</thead>";
		echo "<tbody>";
		$ct = 0;
		foreach($users as $user) {
			$wins = $user->getWins();
			$losses = $user->getLosses();
			$numgames = $wins + $losses;
			//In the future these people will be left off the leaderboard
			if($numgames == 0)
				$numgames = 1;
			
			
			$ct += 1;
			$bgcolor = '';
			$colorstyle = '';
			if($user->getStreak() >= 5)
				$bgcolor = "hot";
			elseif($user->getStreak() <= -5)
				$bgcolor = "cold";
			if(strcmp($user->getHome(), 'east') == 0)
				$colorstyle = '"east"';
			elseif(strcmp($user->getHome(), 'uk') == 0)
				$colorstyle = '"uk"';
			elseif(strcmp($user->getHome(), 'mw') == 0)
				$colorstyle = '"mw"';
			elseif(strcmp($user->getHome(), 'west') == 0)
				$colorstyle = '"west"';
			
			echo '<tr class="' . $bgcolor . '">';
			echo '<td class=' . $colorstyle . '> '. $ct .'</td>';
			echo '<td><a href="/' . $base . '/user/show/' . $user->getUserName() . '">' . $user->getUserName() . '</td>';
			echo '<td>'.$user->getSkill().'</td>';
			echo '<td>'.$wins.'</td>';
			echo '<td>'.$losses.'</td>';
			echo '<td>'.($wins + $losses).'</td>';
			echo '<td>'.$user->getGoals().'</td>';
			echo '<td>'.$user->getAssists().'</td>';
			echo '<td>'.$user->getOwnGoals().'</td>';
			echo '<td>'.round($user->getGoals()*1.0 / $numgames, 2).'</td>';
			echo '<td>'.round($user->getAssists()*1.0 / $numgames, 2).'</td>';
			echo '<td>'.round($user->getOwnGoals()*1.0 / $numgames, 2).'</td>';
			echo '<td>'.$user->getBads().'</td>';
			echo '<td>'.$user->getStreak().'</td>';
			echo '<td>'.$user->getAlias().'</td>';
			echo '</tr>';
		}
		echo "</tbody>";
		echo "</table>";
		echo "</div>";
		echo "</div>";
	}
	
	public static function showUpdate() {
		$_SESSION['headertitle'] = "Update user";
		$_SESSION['styles'] = array('Jumbotron.css');
		MasterView::showHeader();
		MasterView::showNav();
		self::showUpdateDetails();
		$_SESSION['footertitle'] = "The user update footer";
		MasterView::showFooter();
	}
	
	public static function showUpdateDetails() {
		$webuser = (array_key_exists('webuser', $_SESSION))?$_SESSION['webuser']:null;
		$base = (array_key_exists('base', $_SESSION))?$_SESSION['base']:"";
		
		echo '<div class="container-fluid">';
	    echo '<div class="row">';
	    echo '<div class="col-md-3 col-sm-2 col-xs-1"></div>';
	    echo '<div class="col-md-6 col-sm-8 col-xs-10">';
	    echo '<h1>'.$_SESSION['headertitle'].'</h1>';
   	    if (is_null($webuser)) {
	       echo '<section>User does not exist</section>';
		   return;
	    }
	    
	    echo '<form role="form" method="Post" action ="/'.$base. '/user/update/'.$webuser->getUserName().'">';
	    
	    // Error at the top of the form
	    if (!is_null($webuser) && !empty($webuser->getError('userName'))) {
	    	echo  '<div class="form-group">';
	    	echo  '<label><span class="label label-danger">';
	    	echo  $webuser->getError('userName');
	    	echo '</span></label></div>';
	    }
	    
	    echo '<div class="form-group">'; // User name
	    echo '<label for="userName">New User name:';
	    echo '<span class="label label-danger">';
	    if (!is_null($webuser))
	    	echo $webuser->getError('userName');
	    echo '</span></label>';
	    echo '<input type="text" class="form-control" id = "userName" name="userName"';
	    if (!is_null($webuser))
	    	echo 'value = "'. $webuser->getUserName() .'"';
	    echo 'required>';
	    echo '</div>';
	    
	    echo '<div class="form-group">'; // Email
	    echo '<label for="email">New email:';
	    echo '<span class="label label-danger">';
	    if (!is_null($webuser))
	    	echo $webuser->getError('email');
	    echo '</span></label>';
	    echo '<input type="email" class="form-control" id = "email" name="email"';
	    echo '>';
	    echo '</div>';
	    
	    echo '<div class="form-group">'; // URL
	    echo '<label for="url">New URL:';
	    echo '<span class="label label-danger">';
	    if (!is_null($webuser))
	    	echo $webuser->getError('url');
	    echo '</span></label>';
	    echo '<input type="url" class="form-control" id = "url" name="url"';
	    echo '>';
	    echo '</div>';
	    
	    echo '<div class="form-group">'; // New Password
	    echo '<label for="password">New Password:';
	    echo '<span class="label label-danger">';
	    if (!is_null($webuser))
	    	echo $webuser->getError('password');
	    echo '</span></label>';
	    echo '<input type="password" class="form-control" id = "password" name="password"';
	    echo '>';
	    echo '</div>';
	    
	    echo '<div class="form-group">'; // Confirm New Password
	    echo '<label for="confirmedpw">Confirm new password:';
	    echo '<span class="label label-danger">';
	    if (!is_null($webuser))
	    	echo $webuser->getError('confirmedpw');
	    echo '</span></label>';
	    echo '<input type="password" class="form-control" id = "confirmedpw" name="confirmedpw"';
	    echo '>';
	    echo '</div>';
	    //submit button
	    echo '<button type="submit" class="btn btn-default">Submit</button>';
	    echo '</form>';
	    echo '</div>';
	    echo '<div class="col-md-3 col-sm-2 col-xs-1"></div>';
	    echo '</div>';
	    echo '</div>';
	}
}
?>	