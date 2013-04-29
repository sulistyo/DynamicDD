<?php
class DynamicDD {
    // CUSTOM FORM
    // These can all be set independently when constructing the object
    private $_formname         = 'ddform';
    private $_formaction       = '#';
    private $_select_message_1 = "Please select";
    private $_select_message_2 = "Please select";
    private $_select_message_3 = "Please select";
    private $_select_enable    = true;
		private $_select_attribute = "";
		private $_dropdown_level 	 = 3;

    // TABLE SETTINGS
    private $_tabledd          = 'siccode';
    private $_level1           = 'dropdown1_name';
    private $_level1value      = 'dropdown1_value';
    private $_level1default    = 'dropdown1_default';
    private $_level2           = 'dropdown2_name';
    private $_level2value      = 'dropdown2_value';
    private $_level2default    = 'dropdown2_default';
    private $_level3           = 'dropdown3_name';
    private $_level3value      = 'dropdown3_value';
    private $_level3default    = 'dropdown3_default';

    // DB SETTINGS
    private $con;
    private $db_default = array(
        'host' => 'localhost',
        'user' => 'edyli_siccode',
        'pass' => '12qwaszx',
        'db'   => 'edyli_db_siccode',
        );

    function __construct($options=array(), $db=null) {
        if(is_null($db)) {
            $db = $this->db_default;
        }
        foreach($options as $key => $value) {
            switch($key) {
                case "formname":
                $this->_formname = $value;
                break;
                case "formaction":
                $this->_formaction = $value;
                break;
                case "select_message_1":
                $this->_select_message_1 = $value;
                break;
                case "select_message_2":
                $this->_select_message_2 = $value;
                break;
                case "select_message_3":
                $this->_select_message_3 = $value;
                break;
                case "select_enable":
                $this->_select_enable = $value;
								break;
                case "dropdown_level":
                $this->_dropdown_level = $value;
								break;
                case "select_attribute":
                $this->_select_attribute = $value;
								break;
                default:
                break;
            }
        }
        $this->con  = mysql_connect($db['host'],$db['user'],$db['pass'],true) or die ('Error connecting to MySQL');
        mysql_select_db($db['db'],$this->con) or die('Database '.$db['db'].' does not exist!');
    }

    function __destruct() {
        mysql_close($this->con);
    }

    public function setSelectMessage($which, $select_message) {
        switch($which) {
            case "1":
            $this->_select_message_1 = $select_message;
            break;
            case "2":
            $this->_select_message_2 = $select_message;
            break;
            case "3":
            $this->_select_message_3 = $select_message;
            break;
        }
    }
    public function disableSelectMessage() {
        $this->_select_enable = false;
    }
    public function generateDD($value1 = "", $value2 = "", $value3 = ""){
        $this->echoln('<form id="'.$this->_formname.'" method="post" action="'.$this->_formaction.'">');
        if (!empty($_REQUEST[$this->_formname+"_level1DD"])) {
            $value1 = $_REQUEST[$this->_formname+"_level1DD"];
        }
        if (!empty($_REQUEST[$this->_formname+"_level2DD"])){
            $value2 = $_REQUEST[$this->_formname+"_level2DD"];
        }
        if (!empty($_REQUEST[$this->_formname+"_level3DD"])){
            $value3 = $_REQUEST[$this->_formname+"_level3DD"];
        }
        if (empty($value1)){
            $this->echoln("  <select name=\"".$this->_formname."_level1DD\" id=\"".$this->_formname."_level1DD\" ".$this->_select_attribute."><option value=\"\">$this->_select_message_1</option></select>");

        } else {
            $this->echoln("  <select name=\"".$this->_formname."_level1DD\" id=\"".$this->_formname."_level1DD\" ".$this->_select_attribute."><option value=\"\">$this->SELECT</option>");
            $q = "SELECT  DISTINCT `". $this->_level1 ."`, `". $this->_level1value ."` FROM `".$this->_tabledd."` ORDER BY 2";
            $sql = mysql_query($q);
            while ($row = mysql_fetch_array($sql)){
                $sel = ($row[$this->_level1value] == $value1)?"selected":"";
                $this->echoln("<option value =\"".$row[$this->_level1value]."\" ".$sel.">".$row[$this->_level1]."</option>");
            }
            $this->echoln("</select>");
        }

        if (empty($value2)){
            $this->echoln("  <select name=\"".$this->_formname."_level2DD\" id=\"".$this->_formname."_level2DD\" ".$this->_select_attribute."><option value=\"\">$this->_select_message_2</option></select>");
        } else {
            $this->echoln("  <select name=\"".$this->_formname."_level2DD\" id=\"".$this->_formname."_level2DD\" ".$this->_select_attribute."><option value=\"\">$this->SELECT</option>");
            $q = "SELECT  DISTINCT `". $this->_level2 ."`, `". $this->_level2value ."` FROM `". $this->_tabledd ."` WHERE `".$this->_level1value."` = '".$value1."' ORDER BY 2";
            $sql = mysql_query($q);
            while ($row = mysql_fetch_array($sql)){
                $sel = ($this->$row[$this->_level2value] == $value2)?"selected":"";
                $this->echoln("  <option value =\"".$row[$this->_level2value]."\" ".$sel.">".$row[$this->_level2]."x</option>");
            }
            $this->echoln("</select>");
        }
				if ($this->_dropdown_level == 3){
		        if (empty($value3)){
    		        $this->echoln("  <select name=\"".$this->_formname."_level3DD\" id=\"".$this->_formname."_level3DD\" ".$this->_select_attribute."><option value=\"\">$this->_select_message_3</option></select>");
		        } else {
    		        $this->echoln("  <select name=\"".$this->_formname."_level3DD\" id=\"".$this->_formname."_level3DD\" ".$this->_select_attribute."><option value=\"\">$this->SELECT</option>");
        		    $q = "SELECT  DISTINCT `". $this->_level3 ."`, `". $this->_level3value ."` FROM `". $this->_tabledd ."` WHERE `".$this->_level2value."` = '".$value2."' ORDER BY 2";
            		$sql = mysql_query($q);
		            while ($row = mysql_fetch_array($sql)){
    		            $sel = ($row[$this->_level3value] == $value3)?"selected":"";
        		        echo "  <option value=\"".$row[$this->_level3value]."\" ".$sel.">".$row[$this->_level3]."</option>";
            		}
		            $this->echoln("</select>");
						}
        }
        $this->echoln('  <input type="submit" value="Send" name="submit" />');

        $this->echoln('</form>');
    }

    public function generateJS(){
        $q = "SELECT `". $this->_level1 ."`, `". $this->_level1value ."`, `". $this->_level1default ."`, `". $this->_level2 ."`, `". $this->_level2value ."`, `". $this->_level2default ."`, `". $this->_level3 ."`, `". $this->_level3value ."`, `". $this->_level3default ."` FROM `". $this->_tabledd ."` ORDER BY 2,5,8";
        $sql = mysql_query($q);
        // error checking query
        if (!$sql) {
            die('Query error:'.mysql_error());
        }
        $main = array();
        $prev1 = $prev2 = "";
        $index1 = $index2 = $index3 = 0;
        while ($row = mysql_fetch_array($sql)){
            if ($prev1 != $row[$this->_level1value]){
                $index1++;
                $index2 = 0;
                $main["level1"][$index1]["title"] = $row[$this->_level1];
                $main["level1"][$index1]["value"] = $row[$this->_level1value];
                $main["level1"][$index1]["default"] = $row[$this->_level1default];
            }
            if ($prev2 != $row[$this->_level2value]){
                $index2++;
                $index3 = 0;
                $main["level1"][$index1]["level2"][$index2]["title"] = $row[$this->_level2];
                $main["level1"][$index1]["level2"][$index2]["value"] = $row[$this->_level2value];
                $main["level1"][$index1]["level2"][$index2]["default"] = $row[$this->_level2default];
            }
            if ($row[$this->_level2default] == 1){
                $main["level1"][$index1]["level2"][$index2]["default"] = $row[$this->_level2default];
            }
            if ($row[$this->_level1default] == 1){
                $main["level1"][$index1]["default"] = $row[level1default];
            }
            $index3++;
            $main["level1"][$index1]["level2"][$index2]["level3"][$index3]["title"] = $row[$this->_level3];
            $main["level1"][$index1]["level2"][$index2]["level3"][$index3]["value"] = $row[$this->_level3value];
            $main["level1"][$index1]["level2"][$index2]["level3"][$index3]["default"] = $row[$this->_level3default];
            $prev1 = $row[$this->_level1value];
            $prev2 = $row[$this->_level2value];
        }
        ?>
        <script type="text/javascript">
        $(document).ready(function() {
            var data<?php echo "_",$this->_formname;?> = <?php echo json_encode($main); ?>;
            var next = 0;
            if ($("select#<?php echo $this->_formname;?>_level1DD > option").length <= 1){
                generateLevel(1);
            }
            if ($("select#<?php echo $this->_formname;?>_level2DD > option").length <= 1){
                generateLevel(2);
            }
            if ($("select#<?php echo $this->_formname;?>_level3DD > option").length <= 1){
                generateLevel(3);
            }

            $("form#<?php echo $this->_formname;?>").on("change","select#<?php echo $this->_formname;?>_level1DD",function(){
                generateLevel(2);
                generateLevel(3);
            });
            $("form#<?php echo $this->_formname;?>").on("change","select#<?php echo $this->_formname;?>_level2DD",function(){
                generateLevel(3);
            });
            function generateLevel(level){
                var index = $("select#<?php echo $this->_formname;?>_level1DD").get(0).selectedIndex;
                var index2 = $("select#<?php echo $this->_formname;?>_level2DD").get(0).selectedIndex;

                var genNext = 0;
                if (level == 1){
                <?php if($this->_select_enable) { ?>
                var options = '<option value=""><?php echo $this->_select_message_1;?><\/option>';
                <?php } else { ?>
                var options = '<option value="">&nbsp;<\/option>';
                <?php } ?>
                $.each(data<?php echo "_",$this->_formname;?>.level1, function(i,j){
                        var sel = "";
                        if(j.default > 0) {
                            genNext = 1;
                            sel ="selected";
                        }
                        options += '<option value="' + j.value + '" '+sel+'>' + j.title + '<\/option>';
                    });
                    $("select#<?php echo $this->_formname;?>_level1DD").html(options);
                }
                if (level == 2){
                    <?php if($this->_select_enable) { ?>
                    var options = '<option value=""><?php echo $this->_select_message_2;?><\/option>';
                    <?php } else { ?>
                    var options = '<option value="">&nbsp;<\/option>';
                    <?php } ?>
                    if (index !== 0){
                        var d = data<?php echo "_",$this->_formname;?>.level1[index];
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
                    $("select#<?php echo $this->_formname;?>_level2DD").html(options);
                }
                if (level == 3){
                    <?php if($this->_select_enable) { ?>
                    var options = '<option value=""><?php echo $this->_select_message_3;?><\/option>';
                    <?php } else { ?>
                    var options = '<option value="">&nbsp;<\/option>';
                    <?php } ?>
                    if (index2 !== 0){
                        var d = data<?php echo "_",$this->_formname;?>.level1[index].level2[index2];
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
                    $("select#<?php echo $this->_formname;?>_level3DD").html(options);
                }
                return genNext;
            }
        });
        </script>
<?php
    }

    private function echoln($text) {
        echo "\n",$text;
    }

}
?>
