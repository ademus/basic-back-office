<table width="90%" border="0" cellpadding="5" cellspacing="0" bordercolor="#FF0000" class="cadre">
   <tr> 
      <td colspan="2">&nbsp;&nbsp;&nbsp;
         <H3><?= $cur_table_name ?></H3></td>
   </tr>

   <tr> 
      <td>
         <!-- ————————————————————————————————————————————
                               ADD NEW ROW
         ————————————————————————————————————————————— -->
         <span class="cadre"><a href="index.php?action=Ajouter<?= "&table=$cur_table_name&cur_categ=$cur_categ" ?>">Add new row?</a> </span>
         <!-- —————————— END ADD NEW ROW ————————————————————— -->
      </td>
   </tr>

   <tr> 
      <td>   
         <!-- ————————————————————————————————————————————
                                 IMPORT CSV
           —————————————————————————————————————————————— -->
         <span class="cadre"><a id="button_csv_import" onclick="toggle_csv_import()">Import Csv?</a> </span>
         <div class="fieldset cadre " id="imp_csv_popup" style="display:none;">
            <form action="index.php?action=csv&<?= "table=$cur_table_name&cur_categ=$cur_categ" ?>" method="post" enctype="multipart/form-data">
               <label for="csv_labels_checkb">labels on 1st row
                  <input type="checkbox" id="csv_labels_checkb" name="csv_labels_checkb"
                         onclick="toggle_1st_row_txt()"></label>
                  <?php
                  $fields_str = "";
                  $coma = "";
                  foreach ($_tables_[$cur_table_name] as
                         $var_ar)
                     {
                     if ($var_ar["var"] != $_pKey_label_)
                        {
                        $fields_str.= $coma . $var_ar["var"];
                        $coma = " | ";
                        }
                     }
                  $fields_str = "Fields must be the same than table : $fields_str<br/> separated with ',' ";
                  ?>

               <div class="labels_1st_row_div small" style="display:none;">
                  Labels on 1st row.<br/>
<?= $fields_str ?>
               </div>
               <div class="no_labels_1st_row_div small">No labels on 1st row. <br/>
<?= $fields_str ?>
               </div>

               <input class="button" type='file' id='csvToUpload[]'name='csvToUpload[]' style="display: inline-block;"/>
               <input  class="button"  type="submit" value="import CSV" style="display: inline-block;" />
            </form>
         </div>
         <!-- —————————— END IMPORT CSV ————————————————————— -->
      </td>
   </tr>
</table>

<script>
   function toggle_csv_import()
      {
         var x = document.getElementById("imp_csv_popup");
         if (x.style.display === "none")
            {
               x.style.display = "block";
            } else
            {
               x.style.display = "none";
            }
      }

function toggle_1st_row_txt()
      {
         var rows = document.getElementsByClassName("labels_1st_row_div")[0];
         var no_rows = document.getElementsByClassName("no_labels_1st_row_div")[0];
         if (rows.style.display === "none")
            {
               rows.style.display = "block";
               no_rows.style.display = "none";
            } else
            {
               rows.style.display = "none";
               no_rows.style.display = "block";
            }
      }


</script>