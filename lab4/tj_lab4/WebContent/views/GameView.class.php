<?php
class GameView {
	public static function showAll() {
		$_SESSION['headertitle'] = "Games";
		$_SESSION['styles'] = array('jumbotron.css');
		MasterView::showHeader();
		MasterView::showNav();
		GameView::showAllDetails();
		MasterView::showFooter(null);
	}
		
	public static function showAllDetails() {
		$base = $_SESSION['base'];
		echo '<div class="container">';
		echo '<h1>All Season Games</h1>';

		
		echo '<div class="container">';
		echo '<div class="row">';
		echo '<div class="col-md-1">GameID</div>';
		echo '<div class="col-md-2">User1</div>';
		echo '<div class="col-md-3">User2</div>';
		echo '<div class="col-md-4">User3</div>';
		echo '<div class="col-md-5">TeamSkill</div>';
		echo '<div class="col-md-6">+/-</div>';
		echo '<div class="col-md-7">User4</div>';
		echo '<div class="col-md-8">User5</div>';
		echo '<div class="col-md-9">User6</div>';
		echo '<div class="col-md-10">TeamSkill</div>';
		echo '<div class="col-md-11">+/-</div>';
		echo '<div class="col-md-12">Game Length</div>';
		echo '</div>'; //end row
		//iterate through all games
		echo '</div>'; //end container
	}
}
?>