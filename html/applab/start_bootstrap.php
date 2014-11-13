<?php

require("login/login3.php");
require("mobile_apps_bootstrap.php");

?>


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
    <!-- Bootstrap core JavaScript ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

    <style type="text/css">
        body { padding-top: 70px; }
    </style>

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
                <li class="active"><a href="#active_projects">Active Projects</a></li>
                <li><a href="#inactive_projects">Archived Projects</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</div>


<!-- Apps displayed in bootstrap panels-->
<div class="container">
    <div class="row-fluid" >
        <div class="span4">
            <div class="well well-sm" id="active_projects"><h4>Active Mobile Projects</h4></div>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-primary">
                <?php $retro_project->write_panel(); ?>
            </div>
        </div><!-- /.col-sm-4 -->
        <div class="col-sm-6">
            <div class="panel panel-primary">
                <?php $bluebird_project->write_panel(); ?>
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
            <div class="panel panel-primary">
                <?php $everydose_project->write_panel(); ?>
            </div>
        </div><!-- /.col-sm-4 -->
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-primary">
                <?php $photon_project->write_panel(); ?>
            </div>
        </div><!-- /.col-sm-4 -->
        <div class="col-sm-6">
            <div class="panel panel-primary">
                <?php $mmwr_map_project->write_panel(); ?>
            </div>
        </div><!-- /.col-sm-4 -->
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-primary">
                <?php $mmwr_nav_project->write_panel(); ?>
            </div>
        </div><!-- /.col-sm-4 -->
        <div class="col-sm-6">
            <div class="panel panel-primary">
                <?php $minesim_project->write_panel(); ?>
            </div>
        </div><!-- /.col-sm-4 -->
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-primary">
                <?php $ptt_project->write_panel(); ?>
            </div>
        </div><!-- /.col-sm-4 -->
        <div class="col-sm-6">
            <div class="panel panel-primary">
                <?php $std3_project->write_panel(); ?>
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
            <div class="panel panel-primary">
                <?php $tempmon_project->write_panel(); ?>
            </div>
        </div><!-- /.col-sm-4 -->
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-primary">
                <?php $wisqars_project->write_panel(); ?>
            </div>
        </div><!-- /.col-sm-4 -->
    </div>
</div>

<div class="container">
    <div class="row-fluid" >
        <div class="span4">
            <div class="well well-sm" id="inactive_projects"><h4>Archived Mobile Projects</h4></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-default">
                <?php $tox_guide_project->write_panel(); ?>
            </div>
        </div><!-- /.col-sm-4 -->
        <div class="col-sm-6">
            <div class="panel panel-default">
                <?php $clip_project->write_panel(); ?>
            </div>
        </div><!-- /.col-sm-4 -->
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-default">
                <?php $pedigree_project->write_panel(); ?>
            </div>
        </div><!-- /.col-sm-4 -->
        <div class="col-sm-6">
            <div class="panel panel-default">
                <?php $respguide_project->write_panel(); ?>
            </div>
        </div><!-- /.col-sm-4 -->
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-default">
                <?php $std1_project->write_panel(); ?>
            </div>
        </div><!-- /.col-sm-4 -->
        <div class="col-sm-6">
            <div class="panel panel-default">
                <?php $std2_project->write_panel(); ?>
            </div>
        </div><!-- /.col-sm-4 -->
    </div>
</div>

</body>

<script type="text/javascript">

    $('.nav li a').on('click', function() {
        $(this).parent().parent().find('.active').removeClass('active');
        $(this).parent().addClass('active').css('font-weight', 'bold');
    });
</script>
<script type="text/javascript" src="common.js"></script>

</html>
