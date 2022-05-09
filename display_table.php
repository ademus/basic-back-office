<?php
/*————————————————————————————————————————————————————————————————————
	    THIS FILE DISPLAYS 1 SINGLE TABLE USER REQUESTED TO SEE
  ————————————————————————————————————————————————————————————————————*/
?>
<script language="Javascript">
    function confirmation(url)
    {
        if (confirm('Do you really want to delete ?'))
            document.location.href = url
    }
</script>

<?php
//echo"<br>cur_table_name=".$cur_table_name;

if ($cur_table_name == "")  exit();

    $requete = "select * from `" . $cur_table_name . "`";

//echo $requete;

    if (isset($_GET['ord'])) $ord = $_GET['ord'];
    else $ord = $_pKey_label_;
    $requete.=" order by `" . $ord . "`;";
//echo $requete;
    $_connexion_ = connexion(serveur, user, passe, base);
    $resultats = query($requete, $_connexion_);
if ($resultats != true)
    {
    echo ("<span class=\"footer\">No rows in $cur_table_name!</span>");
    exit();
    }
    

//En-tete de la table
?>
<table class='table table-bordered table-striped'>
    <tr align="center"><td><b>ACTIONS</b></td>
	<?php
	//print_r($liste_champs);	


	foreach ($cur_table as $cur_field)
	    {
	    $table_field = $cur_field['var'];
	    $table_field_maj = strtoupper($table_field);
	    echo'<td><a href="' . basename($_SERVER["PHP_SELF"]) . '?table=' . $cur_table_name . '&action=Afficher&ord=' . $table_field . '">' . $table_field_maj . '</a></td>';
	    //.basename ($_SERVER["PHP_SELF"]).									
	    }
	?>
    </tr>
    <?php
    while ($res = mysqli_fetch_array($resultats))
	{
	
	echo '<tr><td align="center"><a title="modify" href="' . basename($_SERVER["PHP_SELF"]) . '?pKey=' . $res[$_pKey_label_] . '&action=Modifier&table=' . $cur_table_name .
	'"><span class="glyphicon glyphicon-pencil"></span></a> - <a title="delete" href="javascript:confirmation(\'' . basename($_SERVER["PHP_SELF"]) . '?table=' . $cur_table_name. '&action=Supprimer&'.$_pKey_label_.'=' . $res[$_pKey_label_] .
	'\');"><span class="glyphicon glyphicon-trash"></span><a></td>';

	foreach ($cur_table as $cur_field)
	    {
	    $table_field = $cur_field['var'];
	    $type = $cur_field['type'];
	    echo '<td>';

	    switch ($type)
		{
		case 'text':
		   echo '<div style="max-width:800px; height:200px; overflow:hidden">'.$res["$table_field"]. '&nbsp;'.'</div>';   
//		   echo substr($res["$table_field"],0,500). '&nbsp;';   
		break;
		case "file":
		case "files":
		case "drag":

		    
		       if($cur_field['label']=="image")
			{
			$src="../"._upload_dir_.$res['image'];
			echo '<div style="min-width:100px;min-height:50px; width:100%; height:auto; 	background: url('.$src.') no-repeat center center; background-size: contain; "></div>';   
			break;
			}
			
		default:
		    echo $res["$table_field"] . '&nbsp;';
		    break;
		   
		}
	    echo '</td>';
	    }
	echo '</tr>';
	}
    ?>
</table>