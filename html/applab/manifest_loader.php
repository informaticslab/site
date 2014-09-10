<?php require_once("mobile_apps_bootstrap.php");

$app = $_GET['app'];

// find iOS app
$project = $ios_projects[$app];
$manifest_link = $project->get_ios_manifest_link();

// redirect to manifest link
header($project->ios_app->manifest_link);

exit;

