<?php
class DynamicDD {
    // CUSTOM FORM
    // These can all be set independently when constructing the object
    private $_formname         = 'ddform';
    private $_select_message_1 = "Please select";
    private $_select_message_2 = "Please select";
    private $_select_message_3 = "Please select";
    private $_select_enable    = true;
	private $_select_attribute = "";
	private $_dropdown_level   = 3;

    /**
     * State of current field on parent change.
     *
     * Possible values: none, hide.
     * Default: hide.
     */
    private $on_parent_change = "hide";

    // TABLE SETTINGS
    private $_tabledd          = 'siccode';
    private $_level1           = 'dropdown1_name';
    private $_level1value      = 'dropdown1_value';
    private $_level2           = 'dropdown2_name';
    private $_level2value      = 'dropdown2_value';
    private $_level3           = 'dropdown3_name';
    private $_level3value      = 'dropdown3_value';

    function __construct($options=array())
    {
        extract($options);

        if (isset($formname)) $this->_formname = $formname;
        if (isset($formaction)) $this->_formaction = $formaction;
        if (isset($select_message_1)) $this->_select_message_1 = $select_message_1;
        if (isset($select_message_2)) $this->_select_message_2 = $select_message_2;
        if (isset($select_message_3)) $this->_select_message_3 = $select_message_3;
        if (isset($dropdown_level)) $this->_dropdown_level = $dropdown_level;
        if (isset($select_attribute)) $this->_select_attribute = $select_attribute;
        if (isset($on_parent_change)) $this->on_parent_change = $on_parent_change;
        if (isset($select_enable)) {
            $this->_select_enable = $select_enable;
            if (!$this->_select_enable) $this->_select_message_1 = $this->_select_message_2 = $this->_select_message_3 = '';
        }
    }

    public function setSelectMessage($which, $select_message)
    {
        // valid value only 1 to 3
        if ($which > 3 || $which < 1) return;

        $var = '_select_message_' . $which;
        $this->$var = $select_message;
    }

    public function disableSelectMessage()
    {
        $this->_select_enable = false;
    }

    /**
     * Generate dynamic dropdown field.
     *
     * @param $data Array Data for options.
     * @param $value1 String Selected value for dropdown level 1.
     * @param $value2 String Selected value for dropdown level 2.
     * @param $value3 String Selected value for dropdown level 3.
     * @return String
     */
    public function generateDD($data = [], $value1 = "", $value2 = "", $value3 = "")
    {
        $output = '';

        if ($this->_dropdown_level >= 1){
            $output .= '<select name="' . $this->_formname . '_level1DD" id="' . $this->_formname . '_level1DD" ' . $this->_select_attribute . ' data-on-parent-change="' . $this->on_parent_change . '" data-prompt="' . $this->_select_message_1 . '" >';
            $output .= '<option>' . $this->_select_message_1 . '</option>';

            $index = 0;
            foreach ($data as $row) {
                $index++;

                $sel = ($row[$index]['value'] == $value1)?"selected":"";
                $output .= '<option value="' . $row[$index]['value'] . '" ' . $sel . '>' . $row[$index]['title'] . '</option>';
            }

            $output .= '</select>';
        }

        if ($this->_dropdown_level >= 2){
            $output .= '<select name="' . $this->_formname . '_level2DD" id="' . $this->_formname . '_level2DD" ' . $this->_select_attribute . ' data-on-parent-change="' . $this->on_parent_change . '" data-prompt="' . $this->_select_message_2 . '" >';
            $output .= '<option>' . $this->_select_message_2 . '</option>';
            $output .= '</select>';
        }

		if ($this->_dropdown_level >= 3){
            $output .= '<select name="' . $this->_formname . '_level3DD" id="' . $this->_formname . '_level3DD" ' . $this->_select_attribute . ' data-on-parent-change="' . $this->on_parent_change . '" data-prompt="' . $this->_select_message_3 . '" >';
            $output .= '<option>' . $this->_select_message_3 . '</option>';
            $output .= '</select>';
        }

        return $output . $this->generateJS($data);
    }

    /**
     * Generate javascript for content binding.
     *
     * @param $data Array Data for options.
     */
    protected function generateJS($data = [])
    {
        $data_name = "data_" . $this->_formname;
        $json = json_encode($data);

        $output = <<<"EOT"
        <script type="text/javascript">
        $(document).ready(function() {
            var {$data_name} = {$json};
            var next = 0;

            var id_1 = "#{$this->_formname}_level1DD";
            var id_2 = "#{$this->_formname}_level2DD";
            var id_3 = "#{$this->_formname}_level3DD";

            reset(id_2);
            reset(id_3);

            $(id_1).on("change",function(){
                var index = $(id_1).get(0).selectedIndex;
                var data = {$data_name}.level1[index];

                update(id_2, id_1, data, "level2");
                reset(id_3);
            });

            $(id_2).on("change",function(){
                var index = $(id_1).get(0).selectedIndex;
                var index2 = $(id_2).get(0).selectedIndex;
                var data = {$data_name}.level1[index].level2[index2];

                update(id_3, id_2, data, "level3");
            });

            function reset(selector) {
                $(selector).html('<option>' + $(selector).attr('data-prompt') + '</option>');
                $(selector + "[data-on-parent-change=hide]").hide();
            }

            /**
             * Update select option.
             *
             * current : jQuery selector
             * parent : jQuery selector
             * data : key value array
             * key : data index
             */
            function update(current, parent, data, key) {
                var index = $(parent).get(0).selectedIndex;
                var options = '<option>' + $(current).attr('data-prompt') + '</option>';

                reset(current);
                if (index !== 0){
                    $.each(data[key], function(i,j){
                        options += '<option value="' + j.value + '" >' + j.title + '</option>';
                    });
                }

                $(current).html(options);
                $(current + "[data-on-parent-change=hide]").show();
            }
        });
        </script>
EOT;

        return $output;
    }
}
