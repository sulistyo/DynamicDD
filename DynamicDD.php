<?php
class DynamicDD {
    // CUSTOM FORM
    // These can all be set independently when constructing the object
    private $_select_message_1 = "Please select";
    private $_select_message_2 = "Please select";
    private $_select_message_3 = "Please select";
    private $_select_enable    = true;
	private $_select_attribute = "";

    /**
     * Data for select options.
     */
    private $data;

    /**
     * Count of dynamic dropdown generated.
     */
	private $count = 0;

    /**
     * Dynamic dropdown group name.
     * This will be used as identifier beetween several dynamic dropdown.
     */
    private $group = 'dd';

    /**
     * State of current field on parent change.
     *
     * Possible values: none, hide.
     * Default: hide.
     */
    private $on_parent_change = "hide";

    /**
     * Boolean value of whether the javascript has already been printed.
     */
    private $javascript_printed = false;

    function __construct($options=array())
    {
        extract($options);

        if (isset($group)) $this->group = $group;
        if (isset($formaction)) $this->_formaction = $formaction;
        if (isset($select_message_1)) $this->_select_message_1 = $select_message_1;
        if (isset($select_message_2)) $this->_select_message_2 = $select_message_2;
        if (isset($select_message_3)) $this->_select_message_3 = $select_message_3;
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
     * TODO: Assign selected value.
     *
     * @param $data Array Data for options.
     * @return String
     */
    public function dropdown($data = [])
    {
        // TODO: currently limit to only 3 level dropdown.
        if ($this->count <= 3) {
            $this->count++;
            $message_var = '_select_message_' . $this->count;
            $prompt = $this->$message_var;

            $output = '';
            $output .= '<select name="' . $this->group . '_level' . $this->count . 'DD" id="' . $this->group . '_level' . $this->count . 'DD" ' . $this->_select_attribute . ' data-on-parent-change="' . $this->on_parent_change . '" data-prompt="' . $prompt . '" >';

            $output .= '<option>' . $prompt . '</option>';
            if ($this->count == 1) foreach ($data['level1'] as $row) $output .= '<option value="' . $row['value'] . '">' . $row['title'] . '</option>';

            $output .= '</select>';

            if (!empty($data)) $this->data = $data;
            $javascript = $this->javascript();

            return $output . $javascript;
        }
    }

    /**
     * Generate javascript for content binding.
     */
    protected function javascript()
    {
        // TODO: should be checking javascript_printed NOT count.
        if ($this->count < 3) return '';
        $data = $this->data;

        $data_name = "data_" . $this->group;
        $json = json_encode($data);

        $output = <<<"EOT"
        <script type="text/javascript">
        $(document).ready(function() {
            var {$data_name} = {$json};
            var next = 0;

            var id_1 = "#{$this->group}_level1DD";
            var id_2 = "#{$this->group}_level2DD";
            var id_3 = "#{$this->group}_level3DD";

            reset(id_2);
            reset(id_3);

            $(document).on("change", id_1, function(){
                var index = $(id_1).get(0).selectedIndex;
                var data = {$data_name}.level1[index];

                reset(id_2);
                reset(id_3);

                if (index !== 0) update(id_2, data, "level2");
            });

            $(document).on("change", id_2, function(){
                var index = $(id_1).get(0).selectedIndex;
                var index2 = $(id_2).get(0).selectedIndex;
                var data = {$data_name}.level1[index].level2[index2];

                reset(id_3);

                if (index2 !== 0) update(id_3, data, "level3");
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
             * key : data index e.g. data[key]
             * value : value index name e.g. data[key][value]
             * title : title index name e.g. data[key][title]
             */
            function update(current, data, key, value, title) {
                value = typeof value !== 'undefined' ? value : 'value';
                title = typeof title !== 'undefined' ? title : 'title';

                var options = '<option>' + $(current).attr('data-prompt') + '</option>';

                $.each(data[key], function(i,j){
                    options += '<option value="' + j[value] + '" >' + j[title] + '</option>';
                });

                $(current).html(options);
                $(current + "[data-on-parent-change=hide]").show();
            }
        });
        </script>
EOT;

        $this->javascript_printed = true;
        return $output;
    }
}
