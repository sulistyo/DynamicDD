<?php
require_once '../DynamicDD.php';
require_once 'data/seed.php';
?>
<!doctype html>
<html>
    <head>
        <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="//twitter.github.com/bootstrap/assets/js/google-code-prettify/prettify.css" rel="stylesheet" media="screen">
        <style type="text/css">section{padding-top:30px;}</style>
        <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    </head>
    <body style="padding-top:40px" id="top" data-spy="scroll" data-target="#sidebar">
        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <a class="brand" href="//github.com/sulistyo/DynamicDD" style="margin-left:0">DynamicDD</a>
                <ul class="nav">
                    <li class="active"><a href="#top">Documentation</a></li>
                    <li class=""><a href="//github.com/sulistyo/DynamicDD">Github</a></li>
                </ul>
          </div>
        </div>
        <div class="container-fluid">
            <div class="row-fluid" style="padding-top:20px;">
                <div class="span3" id="sidebar">
                    <ul class="nav nav-list affix well" style="width:280px">
                        <li class="nav-header">Documentation</li>
                        <li><a href="#how-it-works">How it works</a></li>
                        <li><a href="#data-source">Data source</a></li>
                        <li><a href="#configurations">Configuration</a></li>
                        <li><a href="#parameters">Parameters</a></li>
                        <li class="nav-header">Example</li>
                        <li><a href="#simple">Simple</a></li>
                        <li><a href="#custom">Custom</a></li>
                        <li><a href="#multiple">Multiple</a></li>
                    </ul>
                </div>
                <div class="span9">
                    <header class="hero-unit">
                        <h1>DynamicDD <small>Multiple Dynamic Dropdown</small></h1>
                        <p>Multiple dependencies up to 3-level dynamic dropdown generation made easy.</p>
                    </header>
                    <section id="how-it-works">
                        <div class="page-header">
                            <h2>How it works</h2>
                        </div>
                        <p>Include jquery <em>(if you haven't done it)</em>.</p>
<pre class="prettyprint linenums pre-scrollable">
<?= htmlentities('<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>') ?>
</pre>
                        <p>Require it once wherever you want, usually where your app starts.</p>
<pre class="prettyprint linenums pre-scrollable">
require_once 'DynamicDD.php';
</pre>
                        <p>Prepare your data somewhere in your app in array associative format.</p>
<pre class="prettyprint linenums pre-scrollable">
$data = [
    'category' => [
        1 => [
            'value' => 'AG',
            'title' => 'AGRICULTURE, FORESTRY AND FISHING'
        ]
    ]
];
</pre>
                        <p>In your page, initialize it and run the <code>dropdown()</code> function with the required parameters.</p>
<pre class="prettyprint linenums pre-scrollable">
$dd = new DynamicDD();
echo $dd->dropdown(['data' => $data, 'name' => 'company[category]', 'key' => 'category']);
</pre>
                        <div class="well">
                            <legend>HTML rendered as follows:</legend>
                            <?php $dd_01 = new DynamicDD(); ?>
                            <?= $dd_01->dropdown(['data' => $data, 'name' => 'company[category]', 'key' => 'category']); ?>
                        </div>
                    </section>
                    <section id="data-source">
                        <div class="page-header">
                            <h2>Data source</h2>
                        </div>
                        <p>This class requires the data in array associative form with predefined structure as follows.</p>
<pre class="prettyprint linenums pre-scrollable">
$data = [
    'key' => [
        index => [
            'value' => 'ID',
            'title' => 'TEXT'
        ]
    ]
];
</pre>
                        <p>In the above example, we have 4 keys that need to be set properly</p>
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Key name</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>key</td>
                                    <td>This should be the object name that represents the dropdown field.</td>
                                </tr>
                                <tr>
                                    <td>index</td>
                                    <td>The numeric index of the data</td>
                                </tr>
                                <tr>
                                    <td>value</td>
                                    <td>This is the option value</td>
                                </tr>
                                <tr>
                                    <td>title</td>
                                    <td>This is the option text</td>
                                </tr>
                            </tbody>
                        </table>
                        <p>Following is another example of the data source used for 3 level dropdown. This is also the data source we are going to use for the rest of this documentation.</p>
<pre class="prettyprint linenums pre-scrollable">
$data = [
    'category' => [
        1 => [
            'value' => 'AG',
            'title' => 'AGRICULTURE, FORESTRY AND FISHING',
            'sub_category' => [
                1 => [
                    'value' => 'FRS',
                    'title' => 'Forestry and logging',
                    'type' => [
                        1 => [
                            'value' => 'SILV',
                            'title' => 'Silviculture and other forestry activities'
                        ],
                        2 => [
                            'value' => 'MINI',
                            'title' => 'Mining of hard coal'
                        ]
                    ]
                ],
                2 => [
                    'value' => 'MNG',
                    'title' => 'Mining of coal and lignite'
                ]
            ]
        ],
        2 => [
            'value' => 'MI',
            'title' => 'MINING AND QUARRYING'
        ]
    ]
];
</pre>
                        <p>There's also an alternate for data seed for different level of dropdown that we are going to use for example with multiple instance in a single form.</p>
<pre class="prettyprint linenums pre-scrollable">
$data_alt_01 = [
    'country' => [
        1 => ['value' => 'US', 'title' => 'United States'],
        2 => ['value' => 'UK', 'title' => 'United Kingdom']
    ]
];

$data_alt_02 = [
    'category' => [
        1 => [
            'value' => 'PAR',
            'title' => 'Partnerships',
            'type' => [
                1 => [
                    'value' => 'LLP',
                    'title' => 'Limited liability partnership'
                ],
                2 => [
                    'value' => 'LP',
                    'title' => 'Limited partnership'
                ]
            ]
        ],
        2 => [
            'value' => 'COM',
            'title' => 'Companies',
            'type' => [
                1 => [
                    'value' => 'LTD',
                    'title' => 'Private company limited'
                ],
                2 => [
                    'value' => 'PLC',
                    'title' => 'Public limited company'
                ]
            ]
        ]
    ]
];
</pre>
                    </section>
                    <section id="configurations">
                        <div class="page-header">
                            <h2>Configuration</h2>
                        </div>
                        <p>There are several configuration can be setup on class initialization. Following are the available options.</p>
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Parameters</th>
                                    <th>Data Type</th>
                                    <th>Default</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>group</td>
                                    <td>String</td>
                                    <td>dd</td>
                                    <td>Group name of a set of dyamic dropdown. Should be unique per instance.</td>
                                </tr>
                                <tr>
                                    <td>prompt</td>
                                    <td>String</td>
                                    <td>Please select</td>
                                    <td>Select prompt text for dropdown.</td>
                                </tr>
                                <tr>
                                    <td>custom</td>
                                    <td>Array of string</td>
                                    <td>null</td>
                                    <td>Custom html attributes. Any internal data attributes are removed from this array.</td>
                                </tr>
                                <tr>
                                    <td>on_parent_change</td>
                                    <td>String</td>
                                    <td>hide</td>
                                    <td>Option: hide or none. Dopdown state when parent's dropdown selected option is changed.</td>
                                </tr>
                            </tbody>
                        </table>
                        <p>Let's create another example with a more complete set of dynamic dropdown using the data seed.</p>
<pre class="prettyprint linenums pre-scrollable">
$dd = new DynamicDD([
    'group' => '02_1',
    'prompt' => 'Select an option',
    'custom' => ['class' => 'span3'],
    'on_parent_change' => 'none'
]);

echo $dd->dropdown(['data' => $data, 'name' => 'company[category]', 'key' => 'category']);
echo $dd->dropdown(['name' => 'company[sub_category]', 'key' => 'sub_category']);
echo $dd->dropdown(['name' => 'company[type]', 'key' => 'type']);
</pre>
                        <div class="well">
                            <legend>HTML rendered as follows:</legend>
                            <?php $dd_02_1 = new DynamicDD([
                                'group' => '02_1',
                                'prompt' => 'Select an option',
                                'custom' => ['class' => 'span4'],
                                'on_parent_change' => 'none'
                            ]); ?>
                            <?= $dd_02_1->dropdown(['data' => $data, 'name' => 'company[category]', 'key' => 'category']); ?>
                            <?= $dd_02_1->dropdown(['name' => 'company[sub_category]', 'key' => 'sub_category']); ?>
                            <?= $dd_02_1->dropdown(['name' => 'company[type]', 'key' => 'type']); ?>
                        </div>
                        <p>If you omit <code>on_parent_change</code> parameter, it will be rendered using it's default option, which is <code>hide</code>.</p>
<pre class="prettyprint linenums pre-scrollable">
$dd = new DynamicDD([
    'group' => '02_2',
    'prompt' => 'Select an option',
    'custom' => ['class' => 'span4']
]);

echo $dd->dropdown(['data' => $data, 'name' => 'company[category]', 'key' => 'category']);
echo $dd->dropdown(['name' => 'company[sub_category]', 'key' => 'sub_category']);
echo $dd->dropdown(['name' => 'company[type]', 'key' => 'type']);
</pre>
                        <div class="well">
                            <legend>HTML rendered as follows:</legend>
                            <?php $dd_02_2 = new DynamicDD([
                                'group' => '02_2',
                                'prompt' => 'Select an option',
                                'custom' => ['class' => 'span4']
                            ]); ?>
                            <?= $dd_02_2->dropdown(['data' => $data, 'name' => 'company[category]', 'key' => 'category']); ?>
                            <?= $dd_02_2->dropdown(['name' => 'company[sub_category]', 'key' => 'sub_category']); ?>
                            <?= $dd_02_2->dropdown(['name' => 'company[type]', 'key' => 'type']); ?>
                        </div>
                    </section>
                    <section id="parameters">
                        <div class="page-header">
                            <h2>Parameters</h2>
                        </div>
                        <p>The <code>dropdown</code> function accept several parameters, some of them we have used previously. Following are the accepted parameters.</p>
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Parameters</th>
                                    <th>Data Type</th>
                                    <th>Default</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>data</td>
                                    <td>Array</td>
                                    <td>null</td>
                                    <td>Data for select options.</td>
                                </tr>
                                <tr>
                                    <td>prompt</td>
                                    <td>String</td>
                                    <td>Please select</td>
                                    <td>Select prompt message for dropdown.</td>
                                </tr>
                                <tr>
                                    <td>name</td>
                                    <td>String</td>
                                    <td><b>Required</b></td>
                                    <td>HTML attribute name for dropdown.</td>
                                </tr>
                                <tr>
                                    <td>id</td>
                                    <td>String</td>
                                    <td><b>{$group}_{$name}</b></td>
                                    <td>HTML attribute id for dropdown.</td>
                                </tr>
                                <tr>
                                    <td>key</td>
                                    <td>String</td>
                                    <td><b>Required</b></td>
                                    <td>Key used to access data array.</td>
                                </tr>
                            </tbody>
                        </table>
                        <p>So far we have used 3 of all parameters, let's try the rest of it.</p>
<pre class="prettyprint linenums pre-scrollable">
$dd = new DynamicDD(['group' => 'example_prompt']);

echo $dd->dropdown([
    'data' => $data,
    'name' => 'company[category]',
    'id' => 'example_prompt_category',
    'key' => 'category',
    'prompt' => 'Select a category'
]);
echo $dd->dropdown([
    'name' => 'company[sub_category]',
    'id' => 'example_prompt_sub_category',
    'key' => 'sub_category',
    'prompt' => 'Select a sub category'
]);
echo $dd->dropdown([
    'name' => 'company[type]',
    'id' => 'example_prompt_type',
    'key' => 'type',
    'prompt' => 'Select a type'
]);
</pre>
                        <div class="well">
                            <legend>HTML rendered as follows:</legend>
                            <?php $dd_prompt = new DynamicDD(['group' => 'example_prompt']); ?>
                            <?= $dd_prompt->dropdown([
                                'data' => $data,
                                'name' => 'company[category]',
                                'id' => 'example_prompt_category',
                                'key' => 'category',
                                'prompt' => 'Select a category'
                            ]); ?>
                            <?= $dd_prompt->dropdown([
                                'name' => 'company[sub_category]',
                                'id' => 'example_prompt_sub_category',
                                'key' => 'sub_category',
                                'prompt' => 'Select a sub category'
                            ]); ?>
                            <?= $dd_prompt->dropdown([
                                'name' => 'company[type]',
                                'id' => 'example_prompt_type',
                                'key' => 'type',
                                'prompt' => 'Select a type'
                            ]); ?>
                        </div>
                    </section>
                    <section id="simple">
                        <div class="page-header">
                            <h2>Simple</h2>
                        </div>
                        <p>Following is an example of how it can be implemented in a simple form with single instance.</p>
<?php $script = <<<'EOT'
<form class="form-horizontal">
    <?php $dd_simple = new DynamicDD(['group' => 'example_simple']) ?>
    <div class="control-group">
        <label class="control-label">Category</label>
        <div class="controls">
            <?= $dd_simple->dropdown(['data' => $data, 'name' => 'company[category]', 'key' => 'category']) ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Sub category</label>
        <div class="controls">
            <?= $dd_simple->dropdown(['name' => 'company[sub_category]', 'key' => 'sub_category']) ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Type</label>
        <div class="controls">
            <?= $dd_simple->dropdown(['name' => 'company[type]', 'key' => 'type']) ?>
        </div>
    </div>
    <div class="control-group">
        <div class="controls">
            <button type="button" class="btn">Submit</button>
        </div>
    </div>
</form>
EOT;
?>
<pre class="prettyprint linenums pre-scrollable">
<?= htmlentities($script); ?>
</pre>
                        <div class="well">
                            <legend>HTML rendered as follows:</legend>
                            <form class="form-horizontal">
                                <?php $dd_simple = new DynamicDD(['group' => 'example_simple']) ?>
                                <div class="control-group">
                                    <label class="control-label">Category</label>
                                    <div class="controls">
                                        <?= $dd_simple->dropdown(['data' => $data, 'name' => 'company[category]', 'key' => 'category']) ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Sub category</label>
                                    <div class="controls">
                                        <?= $dd_simple->dropdown(['name' => 'company[sub_category]', 'key' => 'sub_category']) ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Type</label>
                                    <div class="controls">
                                        <?= $dd_simple->dropdown(['name' => 'company[type]', 'key' => 'type']) ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <div class="controls">
                                        <button type="button" class="btn">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </section>
                    <section id="custom">
                        <div class="page-header">
                            <h2>Custom</h2>
                        </div>
                        <p>Sometimes you need to configure as much as you want so that your application requirement for the dropdown fullfiled. Following are the case where you need to configure the select prompt, on parent change behavior to not hide children dropdown, set predefined value for each dropdown and dropdown level to only reach 2 level.</p>
<?php $script = <<<'EOT'
<form class="form-horizontal">
    <?php $dd_custom = new DynamicDD([
        'group' => 'example_custom',
        'prompt' => 'Select an option',
        'custom' => [
            'class' => 'span6',
            'data-toggle' => 'tooltip',
            'data-delay' => '500',
            'data-title' => 'Select an option.'
        ],
        'on_parent_change' => 'none'
    ]) ?>
    <div class="control-group">
        <label class="control-label">Category</label>
        <div class="controls">
            <?= $dd_custom->dropdown([
                'data' => $data,
                'prompt' => 'Select a category',
                'name' => 'company[category]',
                'id' => 'example_custom_category',
                'key' => 'category',
                'value' => 'AG'
            ]) ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Sub category</label>
        <div class="controls">
            <?= $dd_custom->dropdown([
                'prompt' => 'Select a sub category',
                'name' => 'company[sub_category]',
                'id' => 'example_custom_sub_category',
                'key' => 'sub_category',
                'value' => 'FRS'
            ]) ?>
        </div>
    </div>
    <div class="control-group">
        <div class="controls">
            <button type="button" class="btn">Submit</button>
        </div>
    </div>
</form>
EOT;
?>
<pre class="prettyprint linenums pre-scrollable">
<?= htmlentities($script); ?>
</pre>
                        <div class="well">
                            <legend>HTML rendered as follows:</legend>
                            <form class="form-horizontal">
                                <?php $dd_custom = new DynamicDD([
                                    'group' => 'example_custom',
                                    'prompt' => 'Select an option',
                                    'custom' => [
                                        'class' => 'span6',
                                        'data-toggle' => 'tooltip',
                                        'data-delay' => '500',
                                        'data-title' => 'Select an option.'
                                    ],
                                    'on_parent_change' => 'none'
                                ]) ?>
                                <div class="control-group">
                                    <label class="control-label">Category</label>
                                    <div class="controls">
                                        <?= $dd_custom->dropdown([
                                            'data' => $data,
                                            'prompt' => 'Select a category',
                                            'name' => 'company[category]',
                                            'id' => 'example_custom_category',
                                            'key' => 'category',
                                            'value' => 'AG'
                                        ]) ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Sub category</label>
                                    <div class="controls">
                                        <?= $dd_custom->dropdown([
                                            'prompt' => 'Select a sub category',
                                            'name' => 'company[sub_category]',
                                            'id' => 'example_custom_sub_category',
                                            'key' => 'sub_category',
                                            'value' => 'FRS'
                                        ]) ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <div class="controls">
                                        <button type="button" class="btn">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </section>
                    <section id="multiple">
                        <div class="page-header">
                            <h2>Multiple</h2>
                        </div>
                        <p>In this example we are going to use several set/group of dynamic dropdown within a single form with a different level of dependencies on each group. This can also be applied to multiple form on multiple instance on the same page.</p>
<?php $script = <<<'EOT'
<form class="form-horizontal">
    <?php $dd_multiple_country = new DynamicDD(['group' => 'example_multiple_country']) ?>
    <div class="control-group">
        <label class="control-label">Country</label>
        <div class="controls">
            <?= $dd_multiple_country->dropdown([
                'data' => $data_alt_01,
                'name' => 'company[country]',
                'prompt' => 'Select a country',
                'key' => 'country'
            ]) ?>
        </div>
    </div>
    <hr />
    <?php $dd_multiple_entity = new DynamicDD(['group' => 'example_multiple_entity']) ?>
    <div class="control-group">
        <label class="control-label">Entity category</label>
        <div class="controls">
            <?= $dd_multiple_entity->dropdown([
                'data' => $data_alt_02,
                'name' => 'company[entity_category]',
                'prompt' => 'Select a category',
                'key' => 'category'
            ]) ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Entity type</label>
        <div class="controls">
            <?= $dd_multiple_entity->dropdown([
                'data' => $data_alt_02,
                'name' => 'company[entity_type]',
                'prompt' => 'Select a type',
                'key' => 'type'
            ]) ?>
        </div>
    </div>
    <hr />
    <?php $dd_multiple_business = new DynamicDD(['group' => 'example_multiple_business']) ?>
    <div class="control-group">
        <label class="control-label">Business category</label>
        <div class="controls">
            <?= $dd_multiple_business->dropdown([
                'data' => $data,
                'name' => 'company[business_category]',
                'prompt' => 'Select a category',
                'key' => 'category'
            ]) ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Business sub category</label>
        <div class="controls">
            <?= $dd_multiple_business->dropdown([
                'data' => $data,
                'name' => 'company[business_sub_category]',
                'prompt' => 'Select a sub category',
                'key' => 'sub_category'
            ]) ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Business type</label>
        <div class="controls">
            <?= $dd_multiple_business->dropdown([
                'data' => $data,
                'name' => 'company[business_type]',
                'prompt' => 'Select a type',
                'key' => 'type'
            ]) ?>
        </div>
    </div>
    <div class="control-group">
        <div class="controls">
            <button type="button" class="btn">Submit</button>
        </div>
    </div>
</form>
EOT;
?>
<pre class="prettyprint linenums pre-scrollable">
<?= htmlentities($script) ?>
</pre>
                        <div class="well">
                            <legend>HTML rendered as follows:</legend>
                            <form class="form-horizontal">
                                <?php $dd_multiple_country = new DynamicDD(['group' => 'example_multiple_country']) ?>
                                <div class="control-group">
                                    <label class="control-label">Country</label>
                                    <div class="controls">
                                        <?= $dd_multiple_country->dropdown([
                                            'data' => $data_alt_01,
                                            'name' => 'company[country]',
                                            'prompt' => 'Select a country',
                                            'key' => 'country'
                                        ]) ?>
                                    </div>
                                </div>
                                <hr />
                                <?php $dd_multiple_entity = new DynamicDD(['group' => 'example_multiple_entity']) ?>
                                <div class="control-group">
                                    <label class="control-label">Entity category</label>
                                    <div class="controls">
                                        <?= $dd_multiple_entity->dropdown([
                                            'data' => $data_alt_02,
                                            'name' => 'company[entity_category]',
                                            'prompt' => 'Select a category',
                                            'key' => 'category'
                                        ]) ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Entity type</label>
                                    <div class="controls">
                                        <?= $dd_multiple_entity->dropdown([
                                            'data' => $data_alt_02,
                                            'name' => 'company[entity_type]',
                                            'prompt' => 'Select a type',
                                            'key' => 'type'
                                        ]) ?>
                                    </div>
                                </div>
                                <hr />
                                <?php $dd_multiple_business = new DynamicDD(['group' => 'example_multiple_business']) ?>
                                <div class="control-group">
                                    <label class="control-label">Business category</label>
                                    <div class="controls">
                                        <?= $dd_multiple_business->dropdown([
                                            'data' => $data,
                                            'name' => 'company[business_category]',
                                            'prompt' => 'Select a category',
                                            'key' => 'category'
                                        ]) ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Business sub category</label>
                                    <div class="controls">
                                        <?= $dd_multiple_business->dropdown([
                                            'data' => $data,
                                            'name' => 'company[business_sub_category]',
                                            'prompt' => 'Select a sub category',
                                            'key' => 'sub_category'
                                        ]) ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Business type</label>
                                    <div class="controls">
                                        <?= $dd_multiple_business->dropdown([
                                            'data' => $data,
                                            'name' => 'company[business_type]',
                                            'prompt' => 'Select a type',
                                            'key' => 'type'
                                        ]) ?>
                                    </div>
                                </div>
                                <hr />
                                <div class="control-group">
                                    <div class="controls">
                                        <button type="button" class="btn">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <!-- twitter bootstrap -->
        <script src="js/bootstrap.min.js"></script>
        <!-- prettify -->
        <script src="//twitter.github.com/bootstrap/assets/js/google-code-prettify/prettify.js" type="text/javascript"></script>
        <script>
            // make code pretty
            window.prettyPrint && prettyPrint();
            $(document).tooltip({
                selector: "[data-toggle=tooltip]"
            })
        </script>
    </body>
</html>
