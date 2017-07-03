<?php
	require("../library/config.php");
?>
	 <table align="center" border="1">
		 <tr>
		   <td style="width:200px;" align="center">Id</td>
		   <td style="width:200px;" align="center">Font Name</td>
		   <td style="width:200px;" align="center">Actions</td>
		</tr>
     	<tr>
<?php	
$loca_query = "SELECT * FROM font_file";
	$loca_res = mysql_query($loca_query);
		if (mysql_num_rows($loca_res)){
			while ($row = mysql_fetch_assoc($loca_res)){
					$new_resaddim = str_replace("_"," ",$row['ff_name']);

?>
		   <td align="center"><?php echo $row['id']; ?></td>
		   <td align="center" value="<?php if(isset($row['id'])) { echo $row['id']; } ?>"> <?php if(isset($new_resaddim)) { echo $new_resaddim; } ?></td>
		   <td align="center">
				<span>
				<button id=<?php echo $row['id']; ?> onclick="del_locat(<?php echo $row['id']; ?>);"><i class="fa fa-trash-o"></i></button>
				</span>
			</td>
		</tr>
<?php 
			}
		} else {
?> 
		   <td align="center" colspan="3" style="text-align: center;">No Font Files</td>
		</tr>  
<?php
		} 
?>
	 </table>
