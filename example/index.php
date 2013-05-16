<?php
require_once '../DynamicDD.php';
require_once 'data/seed.php';
?>
<!doctype html>
<html>
    <head>
        <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="css/shCore.css" rel="stylesheet" type="text/css" />
        <link href="css/shThemeDefault.css" rel="stylesheet" type="text/css" />
        <style type="text/css">section{padding-top:30px;}</style>
    </head>
    <body style="padding-top:40px" data-spy="scroll" data-target="#sidebar" data-offset="200" id="top">
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
            <div class="row-fluid">
                <div class="span3" style="padding-top:20px;" id="sidebar">
                    <ul class="nav nav-list affix">
                        <li class="nav-header">How it works</li>
                        <li><a href="#how-it-works">Let's see how it really works</a></li>
                        <li><a href="#configurations">Let's configure the class</a></li>
                    </ul>
                </div>
                <div class="span9" style="padding-top:20px;">
                    <header class="hero-unit">
                        <h1>DynamicDD <small>Multiple Dynamic Dropdown</small></h1>
                    </header>
                    <section id="how-it-works">
                        <div class="page-header">
                            <h2><small>#01.</small> Let's see how it really works.</h2>
                        </div>
                        <p>Include jquery to the bottom of the page, just before <code>&lt;/body&gt;</code> <em>(if you haven't done it)</em>.</p>
                        <pre class="brush: html">
                            <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
                        </pre>
                        <p>Require it once wherever you want, usually where your app starts.</p>
                        <pre class="brush: php">
                            require_once 'DynamicDD.php';
                        </pre>
                        <p>Prepare your data somewhere in your app in array associative format.</p>
                        <pre class="brush: php">
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
                        <pre class="brush: php">
                            $dd = new DynamicDD();
                            echo $dd->dropdown(['data' => $data, 'name' => 'company[category]', 'key' => 'category']);
                        </pre>
                        <div class="well">
                            <legend>HTML rendered as follows:</legend>
                            <?php $dd_01 = new DynamicDD(); ?>
                            <?= $dd_01->dropdown(['data' => $data, 'name' => 'company[category]', 'key' => 'level1']); ?>
                        </div>
                    </section>
                    <section id="configurations">
                        <div class="page-header">
                            <h2><small>#02.</small> Let's configure the class.</h2>
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
                        <pre class="brush: php">
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
                            <?= $dd_02_1->dropdown(['data' => $data, 'name' => 'company[category]', 'key' => 'level1']); ?>
                            <?= $dd_02_1->dropdown(['name' => 'company[sub_category]', 'key' => 'level2']); ?>
                            <?= $dd_02_1->dropdown(['name' => 'company[type]', 'key' => 'level3']); ?>
                        </div>
                        <p>If you omit <code>on_parent_change</code> parameter, it will be rendered using it's default option, which is <code>hide</code>.</p>
                        <pre class="brush: php">
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
                            <?= $dd_02_2->dropdown(['data' => $data, 'name' => 'company[category]', 'key' => 'level1']); ?>
                            <?= $dd_02_2->dropdown(['name' => 'company[sub_category]', 'key' => 'level2']); ?>
                            <?= $dd_02_2->dropdown(['name' => 'company[type]', 'key' => 'level3']); ?>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
        <!-- twitter bootstrap -->
        <script src="js/bootstrap.min.js"></script>
        <!-- syntax highlight -->
        <script type="text/javascript" src="js/shCore.js"></script>
        <script src="js/shBrushPhp.js" type="text/javascript"></script>
        <script src="js/shBrushXml.js" type="text/javascript"></script>
        <script>$(document).ready(function(e){SyntaxHighlighter.all()})</script>
    </body>
</html>
