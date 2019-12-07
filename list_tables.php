<?php
/*————————————————————————————————————————————————————————————————————
 * 
	  DISPLAYS LIST OF TABLES
 *	     * 
  ————————————————————————————————————————————————————————————————————*/
?>
<?php 
include_once ('connexion.php');
include_once ('structure.php');


function select_table($cur_table_name) {
	global $_tables_, $cur_categ;		
				$select_table='<select class="form-control"  name="table">';
				
				foreach ($_tables_ as $table_name=>$table_array) {		
				$select_table.=' <option value="'.$table_name.'"';
				if ($table_name==$cur_table_name && !strpos( $cur_table_name, "_" )) $select_table.=' selected';
				$select_table.='>'.$table_name.'</option>\n';
				}
				
				$select_table.='</select>';
				echo $select_table;
}
select_table($cur_table_name);
?>