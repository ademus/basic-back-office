<?php 
//$files = array_filter($_FILES['upload']['name']); //something like that to be used before processing files.
//$cur_label="file_name";

$fichier = fopen('valeurIdCommande.txt','a+'); 
fputs($fichier,"label=".$label."\r\n"); 
fputs($fichier,print_r($_FILES,true)."\r\n"); 

//echo"<br>file_upload.php => ".$cur_label;
if(!isset($label))$label="files";

$slug="";
if(isset($_REQUEST['slug']) ) $slug=$_REQUEST['slug'];
if(!empty($_FILES)){ 
    // Count # of uploaded files in array
    $total = count($_FILES[$label.'ToUpload']['name']);
    fputs($fichier,print_r("total=".$total,true)."\r\n"); 
    include_once("connexion.php");
    $_connexion_ = connexion(serveur, user, passe, base);
   
    
    // Loop through each file
for( $i=0 ; $i < $total ; $i++ ) {
    
    //Get the temp file path
    $tmpFilePath = $_FILES[$label.'ToUpload']['tmp_name'][$i];
    
   //Make sure we have a file path
    if ($tmpFilePath != ""){
    //Setup our new file path
    $fileName =  $_FILES[$label.'ToUpload']['name'][$i];
    $fileName = str_replace(" ", "_", $fileName);
    fputs($fichier,print_r("fileName=".$fileName,true)."\r\n"); 
    $newFilePath = "../"._upload_dir_ . $fileName;

    //Upload the file into the temp dir
    if(move_uploaded_file($tmpFilePath, $newFilePath)) {
        //insert file information into db table
	//print_r($_REQUEST);
	if(isset($_REQUEST['slug']) && $_REQUEST['action']!='Modifier2')
	    {
	$mysql_insert = "INSERT INTO images (image, upload_time, slug)VALUES('".$fileName."','".date("Y-m-d H:i:s")."', '".$slug."')";
	fputs($fichier,print_r($mysql_insert,true)."\r\n"); 
	query($mysql_insert);
	    }
    } 
    }
} // end for
}

 fclose($fichier);