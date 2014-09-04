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

    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
    <!-- Bootstrap core JavaScript ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
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
                <li class="active"><a href="#active_projects">Acknowledgment</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</div>


<div class="container">
        <br/><br/>
        <br/>
        <br/><ul class="list-group">
            <li class="list-group-item list-group-item-warning text-center">To use the Informatics R&D Lab's app lab, you must agree with the following statements:</li>
            <li class="list-group-item">I acknowledge that I am a member of the <strong>CDC developer and/or testing community</strong>.</li>
            <li class="list-group-item">I understand that this app lab is meant for CDC staff, authorized agents of CDC (e.g., contractors), or CDC's community partners <strong>only</strong>.</li>
            <li class="list-group-item">I understand that this app lab does NOT contain production apps, but only <strong>prototype and/or proof-of-concept apps</strong> for collaboration and/or testing purposes.
            </li></ul>
    <p class="text-center">If you agree with these statements, you may proceed by entering your passcode:</p>


        <?php
        if(isset($_GET["wrong"])){
            echo('<div class="alert alert-danger" role="alert">Your passcode is incorrect. Please try again.</div>');
        }
        ?>

        <form class="form-signin" role="form" action="login/login2.php" method="post" name="login_form">
            <input type="password" class="form-control" placeholder="Passcode" name="password" required>
            <button class="btn btn-lg btn-primary btn-block" type="submit" name="login">Sign in</button>
        </form>

        <p class="text-center">To request a passcode, please e-mail: <a href="mailto:informaticslab@cdc.gov">informaticslab@cdc.gov</a></p>

    </div><!--end of form_controls-->


</body>
</html>
