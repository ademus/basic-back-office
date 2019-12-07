<?php
/*————————————————————————————————————————————————————————————————————
 * 
	  MAIN FILE
 *	  CONTROL ALL ACTIONS
 *	    
 * 
  ————————————————————————————————————————————————————————————————————*/
?>
<?php
// UNCOMMENT FOLLOWING LINES TO DISPLAY PHP ERRORS MESSAGES
//error_reporting(E_ALL);
// ini_set('display_errors', 1);

 
include_once ('connexion.php');
include_once ('structure.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
	<title>BackOffice</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link href="assets/styles.css" rel="stylesheet" type="text/css" />

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css"></link>
	<link href="../css/style.css" rel="stylesheet"> 
    </head>

    <body leftmargin="10" topmargin="10" marginwidth="10" marginheight="10">
	<?php
//=============================
//	fonctions
//=============================


	function _set()
	    {

	    global $_tables_;
	    global $cur_table_name;
	    global $cur_table;
	    global $_pKey_label_;
	    global $_connexion_;

	    $_set = "";
	    $comma = "";
	    $table=$cur_table;
	    foreach ($cur_table as $cur_field)
		{

		$label = $cur_field['var'];
		if ($label == $_pKey_label_) continue;
	//	echo"<br>$label   ";
		
		// MULTIFILE UPLOAD, requiert un traitement à part
		if (in_array($cur_field['type'], [ "files", "drag"]))
		    {
		    $cur_label = $label;
		    include "file_upload.php";
		    }
		//  (CLASSIC) SINGLE FILE UPLOAD,   
		else if (in_array($cur_field['type'], [ "file"]))
		    {
		    $fileName = "";
		    
		    $cur_label = $label;
		    include "file_upload.php";
		    if ($fileName != "")
			{
			$_set.=$comma . " `" . $label . "`='" . $fileName . "'"; // NO ESCAPE CHARS BECAUSE WE'RE IN A BACKOFFICE WITH GRANTED ACCESS AND AUTHORIZD USERS WHO KNOW WHAT THEY WRITE
			$comma = ",";
			}
		    }
		else
		    {
		    if (!isset($_POST["$label"])) continue;
		    
		    if($cur_field['type']=="text")
			$_POST["$label"] = mysql_escape( $_POST["$label"]);
			$_POST["$label"] = str_replace("'","&#39;",$_POST["$label"]); // ESCAPING ' because COLLISION WITH QUILLJS TEXTEDITOR
		    
		    $_set.=$comma . " `" . $label . "`='" . $_POST["$label"] . "'"; // NO ESCAPE CHARS BECAUSE WE'RE IN A BACKOFFICE WITH GRANTED ACCESS AND AUTHORIZD USERS WHO KNOW WHAT THEY WRITE
		    $comma = ",";
		    }
		}

	    return $_set;
	    }

//=============================
	$action = "";
	$pKey = "";
	$cur_categ = "";
	$cur_table_name = "";
	if (isset($_REQUEST['table'])) $cur_table_name = $_REQUEST['table'];
	if (isset($_REQUEST['action'])) $action = $_REQUEST['action'];
	if (isset($_REQUEST['pKey'])) $pKey = $_REQUEST['pKey'];
	if (isset($_REQUEST['cur_categ'])) $cur_categ = $_REQUEST['cur_categ'];


	$cur_table = array();
	if ($cur_table_name != "") $cur_table = $_tables_[$cur_table_name];

	$message = "";
	$notDisplayListing = false;
	?>

	<p class="input">&nbsp;</p>
	<table class="col-md-4" border="0" cellspacing="0" cellpadding="0">
	    <tr> 
		<td class="col-md-2"> 
		    <form name="form1" id="form1" method="post" action="index.php">
			Choose table to manage<br/>
		    <?php include("list_tables.php"); ?></td>
		<td class="col-md-2" style="vertical-align: bottom;"><input name="action" type="submit" id="action" class="btn btn-success " value="Afficher" />
		    </form></td>
	    </tr>
	</table>
	<?php
	if (isset($cur_table_name))
	    {
	    include("title.php");
	    }
	?>
	<?php
	$_connexion_ = connexion(serveur, user, passe, base);

	switch ($action)
	    {

	    case "Supprimer";
		$files_to_delete = [];
		$requete_img = "";
	
		// IF 1 IMAGE    
		if ($cur_table_name == 'images')
			$requete_img = "SELECT * from `images`  where pKey='$pKey' ";

		// DELETE IMAGES
		if ($requete_img != "")
		    {
	
		    $resultats = query($requete_img);
		    while ($res = mysqli_fetch_array($resultats))
			{
			$file = "../"._upload_dir_ . $res['file_name'];
		//	echo"<br>delete ".$file;
			unlink($file);
			$requete = "delete from `images`  where pKey='" . $res['pKey'] . "'";
		//	echo"<br>".$requete;
			$delete = query($requete);
			}
		    }

		// NORMAL
		$requete = "delete from `" . $cur_table_name . "`  where pKey='" . $pKey . "'";
		//echo"<br>".$requete;
		$delete = query($requete);
		if ($delete == TRUE)
			$message = "Data has been properly erased.<br>";
		else $message = "Error while deleting data<br>";


		break;


	    case "Ajouter2"; //print_r($HTTP_POST_FILES);	
		$requete = "insert into `" . $cur_table_name . "` set " . _set();
		//echo $requete;
		$results = query($requete);
		if ($results){
			$message = "Data has been correctly added<br>";
			if($cur_table_name=="categories")
			$message .="<script>window.location.replace('".$_SERVER['PHP_SELF']."')</script>";
		}
		else $message = "Error while adding data<br>";
		$pKey = mysqli_insert_id($_connexion_);

		break;


	    case "Modifier2";
		$requete = "update `" . $cur_table_name . "` set " . _set($pKey) . " where pKey='$pKey'";
		//echo $requete; 		exit;
		$results = query($requete);
		//$pKey = mysql_insert_id($_connexion_);

		if ($results == true)
			$message = "Data has been properly updated.<br>";
		else $message = "Error while updating data<br>";

		$message = "";
		//envoi_image($pKey);

		break;


	    case "Modifier";
		$requete = "select * from `" . $cur_table_name . "`  where pKey='$pKey'";
		//echo $requete;
		$results = query($requete);
		$res = mysqli_fetch_object($results);

	    case "Ajouter";
		include('form.php');
		$notDisplayListing = true;

		break;
	    }

	echo "<br><span class=\"footer\">$message</span>";
	if (!$notDisplayListing and isset($cur_table_name))
		include ('display_table.php');
	?>
    </body>
</html>
