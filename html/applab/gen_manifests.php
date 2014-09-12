<?php

require("mobile_apps_bootstrap.php");


foreach ($ios_projects as $project) {


//    echo 'Manifest link = '.$project->ios_app->manifest_link."\n";
//    echo 'iTunes link = '.$project->ios_app->itunes_link."\n";
//    echo 'IPA file = '.$project->ios_app->ipa_file."\n";
//    echo 'iOS dir = '.$project->ios_app->ios_dir."\n";
//    echo 'IPA path = '.$project->ios_app->ipa_path."\n";
//    echo 'Bundle ID = '.$project->ios_app->bundle_id."\n";

    $project->write_ios_manifest_file();
}



