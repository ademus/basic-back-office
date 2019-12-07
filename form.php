<?php
/*————————————————————————————————————————————————————————————————————
	    THIS FILE DISPLAYS A FORM TO INSERT OR MODIFY A ROW IN A TABLE 
  ————————————————————————————————————————————————————————————————————*/
?>
<link href="../css/style.css" rel="stylesheet"> 
<form id="main_form" action="index.php" method="post" enctype="multipart/form-data">
    <?php

    function objet_form($var, $type, $value="", $pKey)
	{
	global $_tables_;
	global $cur_table_name;
	global $cur_categ;
	global $action;
	
	//if($var=='slug')return;
	
	    echo '<tr><td>' . $var.'</td><td >';
	    switch ($type)
		{
		case "text";
		    include("form.quilljs_txt_edit.inc.php");
		    break;
	    case "file";
	    case "files";
		?>
		    <input type="file" name="<?php echo $var; ?>ToUpload[]" multiple> <?php echo $value; ?>
		<?php		
		 break;
	    case "drag";
		if($action!="Modifier")
		    {
		?>
		   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
		   <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		   <link rel="stylesheet" type="text/css" href="dropzone/dropzone.css" />
		   <script type="text/javascript" src="dropzone/dropzone.js.php5?paramName=<?php echo $var."&slug=".$cur_categ; ?>"></script>
		   <form action="" class=""></form>	
			<div class="container">
				<div class="file_upload">
					<form action="file_upload.php" class="dropzone">
						<div class="dz-message needsclick">
							<strong>Drop files here or click to upload.</strong><br />
						</div>
					</form>		
				</div>		
			</div>

		    <?php	}
		    else{
			echo $value;
			}
		 break;
		default;
		    echo '<input type="text" name="' . $var . '" value="' . $value . '" >';
		    break;
		}
	    echo '</td></tr>' . chr(13) . chr(10);

	}

// 

    ?>


    <table  class='table table-bordered table-striped'>
	<?php
	//print_r($res);

	 foreach ($cur_table as $cur_field)
	    {
		$table_field = $cur_field['var'];
		if($table_field==$_pKey_label_) continue;
		$field_value="";
		if(isset($res))
		    {
			
			$field_value = $res->$table_field;
		    }
	if($table_field=='slug' && $cur_table_name=="images" && !empty($cur_categ))
	    {}else
		objet_form($table_field,$cur_field['type'], $field_value, $pKey);
	    
	    }
	if(!empty($cur_categ)) echo '<input type="hidden" name="slug" value="' . $cur_categ . '">';
	echo '<input type="hidden" name="action" value="' . $action . '2">';
	echo '<input type="hidden" name="pKey" value="' . $pKey . '">';
	echo '<input type="hidden" name="table" value="' . $cur_table_name . '">';
	?>

    </table> 
		   <?php if($cur_field['type']!="drag" || $action=="Modifier"){ ?>
		   <input class="btn btn-primary" type="submit" name="Submit" value="Enregistrement">
		   <?php } ?>
</form>