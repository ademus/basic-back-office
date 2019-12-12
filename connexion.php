<?php


//		Fonction Connexion

define("serveur", "localhost");
define("base", "");
define("user", "root");
define("passe", "");


//$afficher_res_connexion_db=true;
FUNCTION connexion($serveur, $user, $passe, $base)
    {
    global $_connexion_;
    if(isset($_connexion_)) return $_connexion_;
    global $afficher_res_connexion_db;
    $_connexion_ = mysqli_connect($serveur, $user, $passe, $base);
   
    return $_connexion_;
    }

//
//   Function query 
//
function query($requete)
    {
    global $_connexion_;
   
    $r = array();
    $r = mysqli_query($_connexion_ ,$requete ) or die (mysqli_error($_connexion_));
    return $r;
}


function mysql_escape( $var, $xss=true){
		//if(_debug_) echo"<br>escape "; var_dump($var);;
		global $_connexion_;
		
		$var1= $var;
		//if($xss)
		//$var = str_replace( '<' , '&lt;' , $var ); // vs XSS injection
		$escaped = mysqli_real_escape_string($_connexion_, $var); // VS SQL injection
		//if(_debug_) echo"<br>escape ".$var1."=>".$escaped;
		return $escaped;
		}


define("largeur_image", "160");
define("mail", "sungets@tiscali.fr");
define("_upload_dir_", "images/folio/");
