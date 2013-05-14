<?php
class DynamicDD {
    // CUSTOM FORM
    // These can all be set independently when constructing the object
    private $_select_enable    = true;
	private $_select_attribute = "";

    /**
     * Select prompt message.
     */
    private $prompt = 'Please select';

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

    /**
     * Available options:
     * - group : String. Group name of several dynamic dropdown field.
     * - prompt : String. Select prompt message.
     * - select_attribute : String. HTML attributes for dropdown field. e.g. 'class="shinny" style="z-index:1"'
     * - on_parent_change : String. Available value: none, hide. Current field state on parent select change.
     * - select_enable : Boolean. Enable/disable select prompt.
     */
    public function __construct($options = [])
    {
        extract($options);

        if (isset($group)) $this->group = $group;
        if (isset($prompt)) $this->prompt = $prompt;
        if (isset($select_attribute)) $this->_select_attribute = $select_attribute;
        if (isset($on_parent_change)) $this->on_parent_change = $on_parent_change;
        if (isset($select_enable)) {
            $this->_select_enable = $select_enable;
            if (!$this->_select_enable) $this->prompt = '';
        }
    }

    public function disableSelectMessage()
    {
        $this->_select_enable = false;
    }

    /**
     * Generate dynamic dropdown field.
     * TODO: Assign selected value.
     *
     * Available parameter for params
     * - prompt : String. Select prompt message.
     * - data : Array. Data for option.
     *
     * @param $params Array.
     * @return String
     */
    public function dropdown($params = [])
    {
        // TODO: currently limit to only 3 level dropdown.
        if ($this->count <= 3) {
            extract($params);
            $this->count++;

            if (empty($prompt)) $prompt = $this->prompt;

            $output = '';
            $output .= '<select name="' . $this->group . '_level' . $this->count . 'DD" id="' . $this->group . '_level' . $this->count . 'DD" ' . $this->_select_attribute . ' data-on-parent-change="' . $this->on_parent_change . '" data-prompt="' . $prompt . '" >';

            $output .= '<option>' . $prompt . '</option>';
            if ($this->count == 1)
                foreach ($data['level1'] as $row)
                    $output .= '<option value="' . $row['value'] . '">' . $row['title'] . '</option>';

            $output .= '</select>';

            if (!empty($data)) $this->data = $data;
            return $output . $this->javascript();
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
