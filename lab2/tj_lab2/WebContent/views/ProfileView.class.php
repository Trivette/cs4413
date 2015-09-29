<?php  
class ProfileView {
	
  public static function show($user) {  	
?> 
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?php if (!is_null($user)) {echo $user->getUserName() . ' ';}?>Profile Page</title>
</head>
<body>
<section>
<h2><?php if (!is_null($user)) {echo $user->getUserName();}?>'s Profile</h2>
<img src="./resources/userpic.png" alt="User Picture Here">
</section>
<section>
<h4>Stats</h4>
<p>
Wins: 5 Losses: 10 Streak: -3 Skill: 1450
</p>
</section>
<section>
<h4>Recent Games</h4>
<p>
Game: (29507)  fakeuser		Thurgood	Prowler		(4572) +10		Ferocious	brood  	fiend 		(4579) -10	21m 18s<br>
Game: (29504)  Ferocious  	Prowler  	fakeuser 	(4630) +8		Q8ball  	Bandit  fiend 		(4522) -8	31m 21s<br>
Game: (29501)  fakeuser 	Bandit  	LogiTech=) 	(4589) +10		Q8ball  	turtle  Gamer 		(4584) -10	21m 32s<br>
Game: (29498)  fakeuser  	Bandit  	turtle 		(4502) +12		Gamer  		fiend  	Thurgood 	(4553) -12	29m 37s<br>
Game: (29497)  fakeuser  	Bandit  	jamez 		(4518) +11		LogiTech=)  turtle  Q8ball 		(4549) -11	17m 57s<br>
</p>
</section>
<section>
<h4>Contact information</h4>
<ul>
	<li><b>Email:</b> <?php if (!is_null($user)) {echo $user->getEmail();}?></li>
	<li><b>URL:</b> <a href="<?php if (!is_null($user)) {echo $user->getURL();}?>"><?php if (!is_null($user)) {echo $user->getURL();}?></a></li>
</ul>
</section>
<section>
<h4>Profile Stuff</h4>
<table class="table">
<tr><th>Question</th> <th>Answer</th></tr>
<tr><td>Favorite Color: </td><td bgcolor="FFCCDD"></td>
<tr><td>Birthday: </td><td><?php if (!is_null($user)) {echo $user->getDOB();}?></td>
<tr><td>Gender: </td><td><?php if (!is_null($user)) {echo $user->getGender();}?></td>
</table>
</section>
</body>
</html>

<?php 
  }
}
?>