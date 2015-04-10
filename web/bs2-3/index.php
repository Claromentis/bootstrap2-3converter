<?php

require_once __DIR__.'/../../vendor/autoload.php';

// default directory
$base = '/Users/simonwillan/Sites/cla/core/web';
$dir = '/interface_default';

if( $_POST )
{
    $dir = $_POST['src'];

    $converter = new \Converter\BootstrapConverter($dir);
    $converter->begin();
}


?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">

    <title>Claromentis - Bootstrap Converter</title>

    <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="/css/style.css"/>
</head>
<body>

    <div class="wrapper container">

        <div class="headbar">
            <h1>Claromentis</h1>
        </div>

        <div class="content container">

            <div class="col-md-12 page-header">
                <h1>Convert Bootstrap 2 to Bootstrap 3 <small></small></h1>
            </div>


            <div class="col-md-12">

                <form class="form-horizontal" method="post" action="">

                    <div class="form-group">
                        <label for="module_name" class="col-md-2 control-label">
                            Parent directory
                        </label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="dir_path" name="dir_path" value="<?php echo $base.$dir ?>" />
							<span class="help-block">
                                This will likely be your interface directory. Converter will migrate all HTML files found as children of this directory.
                                This needs to be the full system to path to the directory.
							</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-6">
                            <button id="convert" class="btn btn-primary">
                                <span id="loading" class="glyphicon glyphicon-refresh" style="margin-right:10px;"></span>
                                <span class="glyphicon glyphicon-transfer"></span> Convert
                            </button>
                        </div>
                    </div>

                </form>

            </div>

            <div class="row">
                <div class="col-md-offset-2 col-md-10">
                    <div class="alert alert-info">
                        <h4>Output</h4><hr />
                        <pre id="output" class="small text-info">...</pre>
                    </div>
                </div>
            </div>

        </div>

        <div class="modal-footer" style="margin-top:10px;">
            <div class="text-center text-muted small">&copy; 1998 - 2015 Claromentis Ltd</div>
        </div>

    </div>

    <script type="text/javascript" src="../js/jquery-2.1.3.min.js"></script>
    <script type="text/javascript" src="../js/app.js"></script>
</body>
</html>