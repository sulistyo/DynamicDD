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
    </head>
    <body style="padding:40px">
        <div class="container">
            <div class="navbar navbar-fixed-top">
                <div class="navbar-inner">
                    <a class="brand" href="//github.com/sulistyo/DynamicDD">DynamicDD</a>
                    <ul class="nav">
                        <li class="active"><a href="#">Examples</a></li>
                        <li class=""><a href="//github.com/sulistyo/DynamicDD">Github</a></li>
                    </ul>
              </div>
            </div>
            <div class="page-header">
                <h1>DynamicDD <small>Multiple Dynamic Dropdown</small></h1>
            </div>
            <section>
                <h3>#01. Let's see how it really works.</h3>
                <p>Include jquery to the bottom of the page, just before <code>&lt;/body&gt;</code> <em>(if you haven't done it)</em>.</p>
                <pre class="brush: html">
                    <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
                </pre>
                <p>Require it once in wherever you want, usually where your app starts.</p>
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
