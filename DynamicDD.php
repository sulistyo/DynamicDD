<?php

class DynamicDD {

	public function generateDD($value1 = "", $value2 = "", $value3 = ""){
		if ($_REQUEST["level1DD"]){
			$value1 = $_REQUEST["level1DD"];
			}
			if ($_REQUEST["level2DD"]){
				$value2 = $_REQUEST["level2DD"];
			}
			if ($_REQUEST["level3DD"]){
				$value3 = $_REQUEST["level3DD"];
			}
			if ($value1 == ""){
				echo "<select name=\"level1DD\" id=\"level1DD\"><option value=\"\">Please select</option></select>";
			} else {
				echo "<select name=\"level1DD\" id=\"level1DD\"><option value=\"\">Please select</option>";
				$q = "SELECT  DISTINCT `". LEVEL1 ."`, `". LEVEL1VALUE ."` FROM `". TABLEDD ."` ORDER BY 2";
				$sql = mysql_query($q);
				while ($row = mysql_fetch_array($sql)){
					$sel = ($row[LEVEL1VALUE] == $value1)?"selected":"";
					echo "<option value =\"".$row[LEVEL1VALUE]."\" ".$sel.">".$row[LEVEL1]."</option>";
					}
					echo "</select>";
			}
			if ($value2 == ""){
				echo "<select name=\"level2DD\" id=\"level2DD\"><option value=\"\">Please select</option></select>";
			} else {
				echo "<select name=\"level2DD\" id=\"level2DD\"><option value=\"\">Please select</option>";
				$q = "SELECT  DISTINCT `". LEVEL2 ."`, `". LEVEL2VALUE ."` FROM `". TABLEDD ."` WHERE `".LEVEL1VALUE."` = '".$value1."' ORDER BY 2";
				$sql = mysql_query($q);
				while ($row = mysql_fetch_array($sql)){
					$sel = ($row[LEVEL2VALUE] == $value2)?"selected":"";
					echo "<option value =\"".$row[LEVEL2VALUE]."\" ".$sel.">".$row[LEVEL2]."</option>";
					}
					echo "</select>";
			}

			if ($value3 == ""){
				echo "<select name=\"level3DD\" id=\"level3DD\"><option value=\"\">Please select</option></select>";
			} else {
				echo "<select name=\"level3DD\" id=\"level3DD\"><option value=\"\">Please select</option>";
				$q = "SELECT  DISTINCT `". LEVEL3 ."`, `". LEVEL3VALUE ."` FROM `". TABLEDD ."` WHERE `".LEVEL2VALUE."` = '".$value2."' ORDER BY 2";
				$sql = mysql_query($q);
				while ($row = mysql_fetch_array($sql)){
					$sel = ($row[LEVEL3VALUE] == $value3)?"selected":"";
					echo "<option value=\"".$row[LEVEL3VALUE]."\" ".$sel.">".$row[LEVEL3]."</option>";
					}
					echo "</select>";
			}
	}	 

	public function generateJS(){
		$q = "SELECT `". LEVEL1 ."`, `". LEVEL1VALUE ."`, `". LEVEL1DEFAULT ."`, `". LEVEL2 ."`, `". LEVEL2VALUE ."`, `". LEVEL2DEFAULT ."`, `". LEVEL3 ."`, `". LEVEL3VALUE ."`, `". LEVEL3DEFAULT ."` FROM `". TABLEDD ."` ORDER BY 2,5,8";
		$sql = mysql_query($q);
		$main = array();
		$prev1 = $prev2 = "";
		$index1 = $index2 = $index3 = 0;
		while ($row = mysql_fetch_array($sql)){
			if ($prev1 != $row[LEVEL1VALUE]){
				$index1++;
				$index2 = 0;
				$main["level1"][$index1]["title"] = $row[LEVEL1];
				$main["level1"][$index1]["value"] = $row[LEVEL1VALUE];
				$main["level1"][$index1]["default"] = $row[LEVEL1DEFAULT];
					}

					if ($prev2 != $row[LEVEL2VALUE]){
						$index2++;
						$index3 = 0;
						$main["level1"][$index1]["level2"][$index2]["title"] = $row[LEVEL2];
						$main["level1"][$index1]["level2"][$index2]["value"] = $row[LEVEL2VALUE];
						$main["level1"][$index1]["level2"][$index2]["default"] = $row[LEVEL2DEFAULT];
					}

					if ($row[LEVEL2DEFAULT] == 1){
						$main["level1"][$index1]["level2"][$index2]["default"] = $row[LEVEL2DEFAULT];
					} 

					if ($row[LEVEL1DEFAULT] == 1){
						$main["level1"][$index1]["default"] = $row[LEVEL1DEFAULT];
					} 

					$index3++;
					$main["level1"][$index1]["level2"][$index2]["level3"][$index3]["title"] = $row[LEVEL3];
					$main["level1"][$index1]["level2"][$index2]["level3"][$index3]["value"] = $row[LEVEL3VALUE];
					$main["level1"][$index1]["level2"][$index2]["level3"][$index3]["default"] = $row[LEVEL3DEFAULT];

					$prev1 = $row[LEVEL1VALUE];
					$prev2 = $row[LEVEL2VALUE];
			}

?>
	<script type="text/javascript">
$(document).ready(function() {
	var data = <?php echo json_encode($main); ?>;
	var next = 0;
	if ($("select#level1DD > option").length <= 1){
		generateLevel(1);
		}				
		if ($("select#level2DD > option").length <= 1){
			generateLevel(2);
		}				
		if ($("select#level3DD > option").length <= 1){
			generateLevel(3);
		}				

		$("form#dynamicDD").on("change","select#level1DD",function(){ 
			generateLevel(2);
			generateLevel(3);
		});
		$("form#dynamicDD").on("change","select#level2DD",function(){ 
			generateLevel(3);
		}); 	

		function generateLevel(level){
			var index = $("select#level1DD").get(0).selectedIndex;
			var index2 = $("select#level2DD").get(0).selectedIndex;
			var genNext = 0;
			if (level == 1){
				var options = '<option value="">Please select<\/option>';
				$.each(data.level1, function(i,j){
					var sel = "";
					if(j.default > 0) {
						genNext = 1;
						sel ="selected";  
								} 
								options += '<option value="' + j.value + '" '+sel+'>' + j.title + '<\/option>';
						});
						$("select#level1DD").html(options);
				}
				if (level == 2){
					var options = '<option value="">Please select<\/option>';
					if (index !== 0){
						var d = data.level1[index];
						if (index > 0) {
							$.each(d.level2, function(i,j){	
								var sel = "";
								if(j.default > 0) {
									genNext = 1;
									sel ="selected";  
												} 
											options += '<option value="' + j.value + '" '+sel+'>' + j.title + '<\/option>';
										});
								} 
						}
						$("select#level2DD").html(options);
				}
				if (level == 3){
					var options = '<option value="">Please select<\/option>';
					if (index2 !== 0){
						var d = data.level1[index].level2[index2]; 
						if (index2 > 0) {
							$.each(d.level3, function(i,j){	
								var sel = "";
								if(j.default > 0) {
									genNext = 1;
									sel ="selected";  
												} 
												options += '<option value="' + j.value + '" '+sel+'>' + j.title + '<\/option>';
										});
								} 
						}
						$("select#level3DD").html(options);
				}
				return genNext;
		}
});
</script>
<?php
	}
}

?>
