<?php //require("login/login3.php"); ?><!-- -->
<?php //require("bsniff.php"); ?>
<?php require("mobile_apps_bootstrap.php"); ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<title>Public Health Prototypes | IIU App Lab</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">


</head>

<body>


<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">IIU App Lab</a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#iphone_apps">iPhone Apps</a></li>
                <li><a href="#ipad_apps">iPad Apps</a></li>

            </ul>
        </div><!--/.nav-collapse -->
    </div>
</div>



<!-- Apps displayed in bootstrap panels-->
<div class="container">
    <h1>Mobile Projects and Prototypes</h1>
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-primary">
                <?php $ptt_project->write_panel(); ?>
            </div>
        </div><!-- /.col-sm-4 -->
        <div class="col-sm-6">
            <div class="panel panel-danger">
                <?php $photon_project->write_panel(); ?>
            </div>
        </div><!-- /.col-sm-4 -->
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-primary">
                <?php $lydia_project->write_panel(); ?>
            </div>
        </div><!-- /.col-sm-4 -->
        <div class="col-sm-6">
            <div class="panel panel-danger">
                <?php $clip_project->write_panel(); ?>
            </div>
        </div><!-- /.col-sm-4 -->
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-primary">
                <?php $epi_project->write_panel(); ?>
            </div>
        </div><!-- /.col-sm-4 -->
        <div class="col-sm-6">
            <div class="panel panel-danger">
                <?php $minesim_project->write_panel(); ?>
            </div>
        </div><!-- /.col-sm-4 -->
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-primary">
                <?php $mmwr_map_project->write_panel(); ?>
            </div>
        </div><!-- /.col-sm-4 -->
        <div class="col-sm-6">
            <div class="panel panel-danger">
                <?php $mmwr_nav_project->write_panel(); ?>
            </div>
        </div><!-- /.col-sm-4 -->
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-primary">
                <?php $pedigree_project->write_panel(); ?>
            </div>
        </div><!-- /.col-sm-4 -->
        <div class="col-sm-6">
            <div class="panel panel-danger">
                <?php $respguide_project->write_panel(); ?>
            </div>
        </div><!-- /.col-sm-4 -->
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-primary">
                <?php $retro_project->write_panel(); ?>
            </div>
        </div><!-- /.col-sm-4 -->
        <div class="col-sm-6">
            <div class="panel panel-danger">
                <?php $std1_project->write_panel(); ?>
            </div>
        </div><!-- /.col-sm-4 -->
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-primary">
                <?php $std2_project->write_panel(); ?>
            </div>
        </div><!-- /.col-sm-4 -->
        <div class="col-sm-6">
            <div class="panel panel-danger">
                <?php $std3_project->write_panel(); ?>
            </div>
        </div><!-- /.col-sm-4 -->
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-primary">
                <?php $tox_guide_project->write_panel(); ?>
            </div>
        </div><!-- /.col-sm-4 -->
        <div class="col-sm-6">
            <div class="panel panel-danger">
                <?php $wisqars_project->write_panel(); ?>
            </div>
        </div><!-- /.col-sm-4 -->
    </div>

</div>


<div id="bottom_line"></div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>



</body>
</html>
