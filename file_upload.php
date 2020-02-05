<?php
/*————————————————————————————————————————————————————————————————————
	  USED BY SYSTEM TO UPLOAD (MULTI)-FILES 
  ————————————————————————————————————————————————————————————————————*/
?>
<?php 
$log_uploads=false; // SET TO TRUE TO WRITE UPLOADS IN A LOG

if($log_uploads)
{   
$fichier = fopen('log_uploads.txt','a+'); 
fputs($fichier,"label=".$label."\r\n"); 
fputs($fichier,print_r($_FILES,true)."\r\n"); 
}
if(!isset($label))$label="files";

if(!empty($_FILES)){ 
    // Count # of uploaded files in array
    $total = count($_FILES[$label.'ToUpload']['name']);
    if($log_uploads)
    fputs($fichier,print_r("total files=".$total,true)."\r\n"); 
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
    if($log_uploads)
    fputs($fichier,print_r("fileName=".$fileName,true)."\r\n"); 
    $newFilePath = _upload_dir_ . $fileName;

    //Upload the file into the temp dir
    if(move_uploaded_file($tmpFilePath, $newFilePath)) {
        //insert file information into db table
	if(isset($_REQUEST['slug']) && $_REQUEST['action']!='Modifier2')
	    {
	
	    $mysql_insert = "INSERT INTO images (file_name, upload_time, slug)VALUES('".$fileName."','".date("Y-m-d H:i:s")."', '".$slug."')";
	if($log_uploads)
	fputs($fichier,print_r($mysql_insert,true)."\r\n"); 
	query($mysql_insert);
	    }
    } 
    }
} // end for
}
if($log_uploads)
 fclose($fichier);