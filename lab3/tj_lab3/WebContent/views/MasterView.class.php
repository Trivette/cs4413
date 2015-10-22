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
     	if (is_null($nav))
     		$nav = '';
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