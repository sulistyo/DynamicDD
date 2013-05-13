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
    // Preset action on changed to dropdown children.
    // Possible values: none, hide.
    private $_on_select_change = "hide";
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

        extract($options);
        if (isset($formname)) $this->_formname = $formname;
        if (isset($formaction)) $this->_formaction = $formaction;
        if (isset($select_message_1)) $this->_select_message_1 = $select_message_1;
        if (isset($select_message_2)) $this->_select_message_2 = $select_message_2;
        if (isset($select_message_3)) $this->_select_message_3 = $select_message_3;
        if (isset($select_enable)) $this->_select_enable = $select_enable;
        if (isset($dropdown_level)) $this->_dropdown_level = $dropdown_level;
        if (isset($select_attribute)) $this->_select_attribute = $select_attribute;

        // assign on select change if option exist
        if (isset($options['on_select_change'])) $this->_on_select_change = $options['on_select_change'];

        $this->con  = mysql_connect($db['host'],$db['user'],$db['pass'],true) or die ('Error connecting to MySQL');
        mysql_select_db($db['db'],$this->con) or die('Database '.$db['db'].' does not exist!');
    }

    function __destruct() {
        mysql_close($this->con);
    }

    public function setSelectMessage($which, $select_message){
        // valid value only 1 to 3
        if ($which > 3 || $which < 1) return;

        $var = '_select_message_' . $which;
        $this->$var = $select_message;
    }
    public function disableSelectMessage() {
        $this->_select_enable = false;
    }
    public function generateDD($value1 = "", $value2 = "", $value3 = ""){
        $output = '';

        if ($this->_dropdown_level >= 1){
            $output .= '<select name="' . $this->_formname . '_level1DD" id="' . $this->_formname . '_level1DD" ' . $this->_select_attribute . '><option>' . $this->_select_message_1 . '</option>';

            $q = "SELECT  DISTINCT `". $this->_level1 ."`, `". $this->_level1value ."` FROM `".$this->_tabledd."` ORDER BY 2";
            $sql = mysql_query($q);

            while ($row = mysql_fetch_array($sql)){
                $sel = ($row[$this->_level1value] == $value1)?"selected":"";
                $output .= '<option value="' . $row[$this->_level1value] . '" ' . $sel . '>' . $row[$this->_level1] . '</option>';
            }

            $output .= '</select>';
        }

        if ($this->_dropdown_level >= 2){
            $output .= '<select name="' . $this->_formname . '_level2DD" id="' . $this->_formname . '_level2DD" ' . $this->_select_attribute . '><option>' . $this->_select_message_2 '</option>';

            $q = "SELECT  DISTINCT `". $this->_level2 ."`, `". $this->_level2value ."` FROM `". $this->_tabledd ."` WHERE `".$this->_level1value."` = '".$value1."' ORDER BY 2";
            $sql = mysql_query($q);

            while ($row = mysql_fetch_array($sql)){
                $sel = ($this->$row[$this->_level2value] == $value2)?"selected":"";
                $output .= '<option value="' . $row[$this->_level2value] . '" ' . $sel . '>' . $row[$this->_level2] . '</option>';
            }

            $output .= '</select>';
        }

		if ($this->_dropdown_level >= 3){
            $output .= '<select name="' . $this->_formname . '_level3DD" id="' . $this->_formname . '_level3DD" ' . $this->_select_attribute . '><option>' . $this->_select_message_3 '</option>';

		    $q = "SELECT  DISTINCT `". $this->_level3 ."`, `". $this->_level3value ."` FROM `". $this->_tabledd ."` WHERE `".$this->_level2value."` = '".$value2."' ORDER BY 2";
    		$sql = mysql_query($q);

            while ($row = mysql_fetch_array($sql)){
	            $sel = ($row[$this->_level3value] == $value3)?"selected":"";
                $output .= '<option value="' . $row[$this->_level3value] . '" ' . $sel . '>' . $row[$this->_level3] . '</option>';
    		}

            $output .= '</select>';
        }

        return $output;
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

            // generate initial display
            generateLevel(1);

            <?php if ($this->_on_select_change == "hide") { ?>
                // hide level 2 & 3 on initial display.
                $("select#<?php echo $this->_formname;?>_level2DD").hide();
                $("select#<?php echo $this->_formname;?>_level3DD").hide();
            <?php }; ?>

            $("select#<?php echo $this->_formname;?>_level1DD").on("change",function(){
                generateLevel(2);

                // reset level 3 dropdown
                generateLevel(3);
            });
            $("select#<?php echo $this->_formname;?>_level2DD").on("change",function(){
                generateLevel(3);
            });
            function generateLevel(level){
                var index = $("select#<?php echo $this->_formname;?>_level1DD").get(0).selectedIndex;
                var index2 = $("select#<?php echo $this->_formname;?>_level2DD").get(0).selectedIndex;

                var genNext = 0;
                if (level == 1){
                    <?php $select_message = ($this->_select_enable)? $this->_select_message_2 : '' ?>
                    var options = '<option value=""><?= $select_message ?><\/option>';

                    $.each(data<?php echo "_",$this->_formname;?>.level1, function(i,j){
                        var sel = "";
                        if(j.default > 0) {
                            genNext = 1;
                        }
                        options += '<option value="' + j.value + '" >' + j.title + '<\/option>';
                    });
                    $("select#<?php echo $this->_formname;?>_level1DD").html(options);

                    <?php if ($this->_on_select_change == "hide") { ?>
                        // hide level 2 & 3 on level 1 changed.
                        $("select#<?php echo $this->_formname;?>_level2DD").hide();
                        $("select#<?php echo $this->_formname;?>_level3DD").hide();
                    <?php }; ?>
                }
                if (level == 2){
                    <?php $select_message = ($this->_select_enable)? $this->_select_message_2 : '' ?>
                    var options = '<option value=""><?= $select_message ?><\/option>';

                    if (index !== 0){
                        var d = data<?php echo "_",$this->_formname;?>.level1[index];
                        if (index > 0) {
                            $.each(d.level2, function(i,j){
                                if(j.default > 0) {
                                    genNext = 1;
                                }
                                options += '<option value="' + j.value + '" >' + j.title + '<\/option>';
                            });
                        }
                    }
                    $("select#<?php echo $this->_formname;?>_level2DD").html(options);

                    <?php if ($this->_on_select_change == "hide") { ?>
                        // show level 2 on level 1 changed.
                        $("select#<?php echo $this->_formname;?>_level2DD").show();

                        // hide level 3 on level 1 changed.
                        $("select#<?php echo $this->_formname;?>_level3DD").hide();
                    <?php }; ?>
                }
                if (level == 3){
                    <?php $select_message = ($this->_select_enable)? $this->_select_message_3 : '' ?>
                    var options = '<option value=""><?= $select_message ?><\/option>';

                    if (index2 !== 0){
                        var d = data<?php echo "_",$this->_formname;?>.level1[index].level2[index2];
                        if (index2 > 0) {
                            $.each(d.level3, function(i,j){
                                if(j.default > 0) {
                                    genNext = 1;
                                }
                                options += '<option value="' + j.value + '" >' + j.title + '<\/option>';
                            });
                        }
                    }
                    $("select#<?php echo $this->_formname;?>_level3DD").html(options);

                    <?php if ($this->_on_select_change == "hide") { ?>
                        // show level 3 on level 2 changed.
                        $("select#<?php echo $this->_formname;?>_level3DD").show();
                    <?php }; ?>
                }
                return genNext;
            }
        });
        </script>
<?php
    }
}
?>
