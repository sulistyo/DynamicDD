<?php
class DynamicDD {
    /**
     * Select prompt message.
     */
    private $prompt = 'Please select';

    /**
     * Array of dropdown key name. Index start from 1.
     */
    private $keys;

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
     * Custom html attributes in array associative.
     */
    private $custom;

    /**
     * Available options:
     * - group : String. Group name of several dynamic dropdown field.
     * - prompt : String. Select prompt message.
     * - on_parent_change : String. Available value: none, hide. Current field state on parent select change.
     * - select_enable : Boolean. Enable/disable select prompt.
     * - custom : Array. Custom html attributes in array associative.
     */
    public function __construct($options = [])
    {
        extract($options);

        if (isset($group)) $this->group = $group;
        if (isset($prompt)) $this->prompt = $prompt;
        if (isset($on_parent_change)) $this->on_parent_change = $on_parent_change;
        if (isset($custom)) $this->custom = $custom;
    }

    /**
     * Generate custom html attributes.
     *
     * @param $custom Array of String
     * @return String
     */
    protected function customAttributes($custom)
    {
        $attributes = '';
        if (!empty($custom)) {
            foreach ($custom as $key => $value) {
              $attributes .= $key . '="' . $value . '" ';
            };
        }

        return $attributes;
    }

    /**
     * Remove internal data attributes.
     *
     * @param &$custom Reference of custom html attributes.
     */
    protected function removeCustomDataAttributes(&$custom)
    {
        if (isset($custom['data-plugin'])) unset($custom['data-plugin']);
        if (isset($custom['data-group'])) unset($custom['data-group']);
        if (isset($custom['data-key'])) unset($custom['data-key']);
        if (isset($custom['data-child'])) unset($custom['data-child']);
        if (isset($custom['data-parent'])) unset($custom['data-parent']);
        if (isset($custom['data-prompt'])) unset($custom['data-prompt']);
        if (isset($custom['data-on-parent-change'])) unset($custom['data-on-parent-change']);
    }

    /**
     * Generate dynamic dropdown field.
     * TODO: Assign selected value.
     *
     * Available parameter for params
     * - prompt : String. Select prompt message.
     * - data : Array. Data for option.
     * - name : String. Name for select field. Required.
     * - id : String. Id for select field. Default to $group_$name.
     * - key : String. Key for select field. Required.
     *
     * @param $params Array.
     * @return String
     */
    public function dropdown($params = [])
    {
        // TODO: currently limit to only 3 level dropdown.
        if ($this->count <= 3) {
            extract($params);

            // Validate required parameters
            if (empty($name)) throw new Exception('Dropdown name is required.');
            if (empty($key)) throw new Exception('Dropdown key is required.');

            $this->count++;
            $this->keys[$this->count] = $key;

            // Default value
            if (empty($id)) $id = $this->group . '_' . str_replace(']', '', str_replace('[', '_', $name));
            if (empty($prompt)) $prompt = $this->prompt;

            $output = '';
            $output .= '<select name="' . $name . '" id="' . $id . '" ';

            // generate data-parent only to childrens
            if ($this->count > 1) $output .= ' data-parent="' . $this->keys[$this->count - 1] . '" ';

            // data attributes
            $output .= ' data-plugin="DynamicDD" data-group="' . $this->group . '" data-key="' . $key . '" data-on-parent-change="' . $this->on_parent_change . '" data-prompt="' . $prompt . '" ';

            // generate data-cache only to root
            if ($this->count == 1) $output .= " data-cache='" . json_encode($data) . "' ";

            // hide children dropdown if it's configured to do so
            if ($this->on_parent_change == "hide" && $this->count > 1) {
                if (isset($this->custom['style'])) {
                    $this->custom['style'] = 'display:none;' . $this->custom['style'];
                } else {
                    $this->custom['style'] = 'display:none;';
                }
            }

            // custom html attributes
            $this->removeCustomDataAttributes($this->custom);
            $output .= $this->customAttributes($this->custom) . ' >';

            $output .= '<option>' . $prompt . '</option>';
            if ($this->count == 1)
                foreach ($data[$key] as $row)
                    $output .= '<option value="' . $row['value'] . '">' . $row['title'] . '</option>';

            $output .= '</select>';

            if (!empty($data)) $this->data = $data;
            return $this->javascript() . $output;
        }
    }

    /**
     * Generate javascript for content binding.
     */
    protected function javascript()
    {
        // TODO: should be checking javascript_printed NOT count.
        if ($this->javascript_printed) return '';

        $data_name = "data_" . $this->group;
        $output = <<<"EOT"
        <script type="text/javascript">
        $(document).ready(function() {
            if (typeof value == 'undefined') var cache = [];
            cache['{$this->group}'] = $('[data-plugin=DynamicDD][data-group={$this->group}]').not('[data-parent]').data('cache');

            // generate data-child attribute on parent dropdown
            $.each($('[data-plugin=DynamicDD][data-group={$this->group}][data-parent]'), function(index, item) {
                var parent_key = $(item).attr('data-parent');
                var current_key = $(item).attr('data-key');

                $('[data-plugin=DynamicDD][data-group={$this->group}][data-key=' + parent_key + ']').attr('data-child', current_key);
            })

            $(document).on('change', '[data-plugin=DynamicDD][data-group={$this->group}]', function(){
                var current = $(this);
                if (!$(current).is('[data-child]')) return;

                var has_parent = ($(this).is('[data-parent]'))? true : false;
                if (has_parent) {
                    var parent_selector = '[data-plugin=DynamicDD][data-group={$this->group}][data-key=' + $(current).attr('data-parent') + ']';
                    var parent_index = $(parent_selector).get(0).selectedIndex;
                    var parent_key = $(parent_selector).attr('data-key');
                    var parent_data = cache['{$this->group}'][parent_key][parent_index];
                } else {
                    var parent_data = cache['{$this->group}'];
                }

                // TODO: refactor code below to a single event handler for all dynamic dropdown.
                var children = '[data-plugin=DynamicDD][data-group={$this->group}][data-key=' + $(current).attr('data-child') + ']';
                var index = $(current).get(0).selectedIndex;

                reset(children);
                $(children).trigger('change');

                if (index !== 0) {
                    var current_key = $(current).attr('data-key');
                    var child = $(current).attr('data-child');

                    var data = parent_data[current_key][index];
                    update(child, data);
                }
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
            function update(key, data, value, title) {
                value = typeof value !== 'undefined' ? value : 'value';
                title = typeof title !== 'undefined' ? title : 'title';

                var selector = '[data-plugin=DynamicDD][data-group={$this->group}][data-key=' +  key + ']';
                var options = '<option>' + $(selector).attr('data-prompt') + '</option>';

                $.each(data[key], function(index, option){
                    options += '<option value="' + option[value] + '" >' + option[title] + '</option>';
                });

                $(selector).html(options);
                $(selector + "[data-on-parent-change=hide]").show();
            }
        });
        </script>
EOT;

        $this->javascript_printed = true;
        return $output;
    }
}
