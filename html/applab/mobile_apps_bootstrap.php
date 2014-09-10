<?php
/**
 * Created by PhpStorm.
 * User: jtq6
 * Date: 3/26/14
 * Time: 5:14 PM
 */

# server setting
#$server = 'edemo';
define('SERVER_DOMAIN','phiresearchlab.org');
#define('SERVER','www'.'.'.SERVER_DOMAIN);  # live
define('SERVER',''.'172.16.4.156:8082');  # live
define('DOWNLOADS_PATH_ROOT','/applab/downloads/');

abstract class BaseApp {
    public $version;
    public $release_date;
    public $size;

    function __construct($ver, $rel, $size) {
        $this->version = $ver;
        $this->release_date = $rel;
        $this->size = $size;
    }

}

class IosApp extends BaseApp {
    public $manifest_link;
    public $itunes_link;
    public $ipa_file;
    public $ios_dir;
    public $ipa_path;
    public $bundle_id;

    # common iOS settings
    const MANIFEST_PREFIX = 'itms-services://?action=download-manifest&url=https://';
    const MANIFEST_FILE = 'manifest.plist';

    function __construct($ver, $rel, $size, $ipa_file, $itunes_link) {
        parent::__construct($ver, $rel, $size);
        $this->ipa_file = $ipa_file;
        $this->itunes_link = $itunes_link;
    }

    public function set_downloads($downloads_path) {

        $this->ios_dir = "$downloads_path/ios/$this->version/";
        $this->manifest_link = self::MANIFEST_PREFIX.SERVER.$this->ios_dir.self::MANIFEST_FILE;
        $this->ipa_path = SERVER.$this->ios_dir.$this->ipa_file;

    }

    public function manifest_exists() {
        if (file_exists($this->ios_dir.self::MANIFEST_FILE) )
            return true;
        else
            return false;
    }

    public function write_manifest($name, $app_title) {

        $manifest_path = "downloads/lydia/ios/0.1.3.3/manifest.plist";
        $manifest_file = fopen($manifest_path, "w") or die("Can't open file: $manifest_path");


        fwrite($manifest_file, '<?xml version="1.0" encoding="UTF-8"?>');
        fwrite($manifest_file, '<!DOCTYPE plist PUBLIC "-//Apple//DTD PLIST 1.0//EN" "http://www.apple.com/DTDs/PropertyList-1.0.dtd">');
        fwrite($manifest_file,  '<plist version="1.0">');
        fwrite($manifest_file,  '    <dict>');
        fwrite($manifest_file,  '        <key>items</key>');
        fwrite($manifest_file,  '        <array>');
        fwrite($manifest_file,  '            <dict>');
        fwrite($manifest_file,  '                <key>assets</key>');
        fwrite($manifest_file,  '                <array>');
        fwrite($manifest_file,  '                    <dict>');
        fwrite($manifest_file,  '                        <key>kind</key>');
        fwrite($manifest_file,  '                <string>software-package</string>');
        fwrite($manifest_file,  '                <key>url</key>');
        fwrite($manifest_file,  '                <string>');
        fwrite($manifest_file, $this->manifest_link);
        fwrite($manifest_file, '                </string>');
        fwrite($manifest_file,  '            </dict>');
        fwrite($manifest_file,  '        </array>');
        fwrite($manifest_file,  '        <key>metadata</key>');
        fwrite($manifest_file,  '        <dict>');
        fwrite($manifest_file,  '            <key>bundle-identifier</key>');
        fwrite($manifest_file,  '            <string>');
        fwrite($manifest_file, $this->bundle_id);
        fwrite($manifest_file, '             </string>');
        fwrite($manifest_file,  '            <key>bundle-version</key>');
        fwrite($manifest_file,  '            <string>');
        fwrite($manifest_file, $this->version);
        fwrite($manifest_file, '            </string>');
        fwrite($manifest_file,  '            <key>kind</key>');
        fwrite($manifest_file,  '            <string>software</string>');
        fwrite($manifest_file,  '            <key>title</key>');
        fwrite($manifest_file,  '            <string>');
        fwrite($manifest_file, $app_title);
        fwrite($manifest_file, ' </string></dict></dict></array></dict></plist>');

        fclose($manifest_file);

    }


    public function set_bundle_id($bundle_id) {
        $this->bundle_id = $bundle_id;
    }

    public function write_download_buttons($app_name) {

        echo "iOS Version: $this->version<br />";
        echo "Released: $this->release_date<br />";
        echo "Size: $this->size<br />";

        echo '<div class="btn-toolbar">';

        // detect iOS devices
        $iPod    = stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
        $iPhone  = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
        $iPad    = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");

        if ($iPhone | $iPad | $iPod)
            $ios_device = true;

        else
            $ios_device = false;


        // manifest links only work for iOS devices and IPA can only be open on desktop
        if ($ios_device) {
            if($this->manifest_link) {
                echo '<a href="';

                // new dynamic manifest link
                echo "manifest_loader.php?app=$app_name";
                // old hard coded manifest link
                //echo $this->manifest_link;
                echo '" class="btn btn-sm btn-info">iOS Beta Download</a>';
            }
        } else if ($this->ipa_path) {
            echo '<a href="';
            echo $this->ipa_path;
            echo '" class="btn btn-sm btn-info">iOS Beta Download</a>';
        }

        if($this->itunes_link) {
            echo '<a href="';
            echo $this->itunes_link;
            echo '" class="btn btn-sm btn-info">iOS Release Download</a>';
        }

        echo '</div>';

    }

    public function write_platform_label() {
        echo '<span class="label label-info" style="margin-left:2px; margin-top:5px; display: inline-block">iOS</span>';
    }
 }

class AndroidApp extends BaseApp {
    public $apk_file;
    public $apk_path;
    public $google_play_link;

    function __construct($ver, $rel, $size, $apk_file, $google_play_link) {
        parent::__construct($ver, $rel, $size);
        $this->apk_file = $apk_file;
        $this->google_play_link = $google_play_link;

    }

    public function set_downloads($downloads_path) {
        $this->apk_path = "$downloads_path/android/$this->version/$this->apk_file";

    }

    public function write_download_buttons() {

        echo '<!-- start write_download_buttons() for AndroidApp object  -->';
        echo "Android Version: $this->version<br />";
        echo "Released: $this->release_date<br />";
        echo "Size: $this->size<br />";


        echo '<div class="btn-toolbar">';

        if($this->google_play_link) {
            echo '<a href="';
            echo $this->google_play_link;
            echo '" class="btn btn-sm btn-success">Google Play Link</a>';
        }
        if($this->apk_path) {
            echo '<a href="';
            echo $this->apk_path;
            echo '" class="btn btn-sm btn-success">Android Download</a>';
        }

        echo '</div>';

    }

    public function write_platform_label() {
        echo '<span class="label label-success" style="margin-left:2px; display: inline-block">Android</span>';
    }

    public function find_manifest_file() {

    }

}

class Project {
    public $name;
    public $app_title;
    public $short_description;
    public $icon;
    public $ios_app;
    public $android_app;
    public $download_path;


    function __construct($name, $title, $short_desc, $icon) {
        $this->name = $name;
        $this->app_title = $title;
        $this->short_description = $short_desc;
        $this->icon = $icon;
        $this->download_path = DOWNLOADS_PATH_ROOT.$name;


    }

    public function get_ios_manifest_link() {

        // make sure manifest.plist file exists first
        if ($this->ios_app->manifest_exists == false) {

            // if it does not exist then create it
            $this->ios_app->write_manifest($this->name, $this->app_title);
        }

        $link = $this->ios_app->manifest_link;
        //die ("Error with manifest link: $link");
        return $link;
    }





    public function write_download_buttons() {

        echo '<!-- start output from php project->write_download_buttons() function -->';

        if ($this->ios_app) {
            $this->ios_app->write_download_buttons($this->name);
        }
        if ($this->android_app) {
            $this->android_app->write_download_buttons();
        }

        echo '<!-- end output from php project->write_download_buttons() function -->';

    }

    public function write_platform_labels() {

        echo '<div class="platform-labels">';

        echo '<span>Supported Platforms:</span>';
        if ($this->ios_app) {
            $this->ios_app->write_platform_label();
        }
        if ($this->android_app) {
            $this->android_app->write_platform_label();
        }

        echo '<!-- end output from php project->write_download_buttons() function -->';
        echo '</div>';

    }

    public function write_panel_heading() {
        echo '<!-- start output from php project->write_panel_heading() function -->';
        echo '<div class="panel-heading"><h3 class="panel-title right-block">';
        echo $this->app_title;
        echo '</h3></div>';
        echo '<!-- end output from php project->write_panel_heading() function -->';

    }

    public function write_panel_body() {

        $title = $this->title;

        echo '<!-- start output from php project->write_panel_body() function -->';
        echo '<div class="panel-body"><div class="media"><a class="pull-left" href="#">';
        echo '<img class="pull-left" src="';
        echo $this->icon;
        echo '" title="'; echo $title; echo '" alt="'; echo $title; echo '" /></a>';
        echo '<div class="media-body">';
        echo '<p>';echo $this->short_description;echo '</p>';
        $this->write_platform_labels();

        echo '</div><br />';

        $this->write_inner_panels();

        echo '</div></div>';
        echo '<!-- end output from php project->write_panel_body() function -->';



    }

    public function write_panel_footer() {
        echo '<!-- start output from php project->write_panel_footer() function -->';
        echo '<div class="panel-footer">';
        //$this->write_download_buttons();
        //$this->write_platform_labels();

        echo '</div>';
        echo '<!-- end output from php project->write_panel_footer() function -->';

    }

    public function write_panel() {
        $this->write_panel_heading();
        $this->write_panel_body();
        $this->write_panel_footer();

    }

    public function add_android_app($droid_app) {
        $droid_app->set_downloads($this->download_path);
        $this->android_app = $droid_app;

    }

    public function add_ios_app($ios_app) {
        $ios_app->set_downloads($this->download_path);
        $this->ios_app = $ios_app;

    }

    public function write_inner_panels() {

        $detailPanelId = $this->name.'detailPanel';
        $downloadPanelId = $this->name.'downloadPanel';

        echo '<div class="panel-group" id="accordion">';

        // Detailed Information panel
//        echo '<div class="panel panel-default">';
//        echo '<div class="panel-heading">';
//
//        echo '<h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#';
//        echo $detailPanelId;
//        echo '">Detailed Information</a></h4></div><div id="';
//        echo $detailPanelId;
//        echo '" class="panel-collapse collapse">';
//        echo '<div class="panel-body">Detailed Information goes here.</div></div></div>';

        // Downloads  panel
        echo '<div class="panel panel-default">';
        echo '<div class="panel-heading">';

        echo '<h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#';
        echo $downloadPanelId;

        echo '">Downloads</a></h4></div><div id="';
        echo $downloadPanelId;
        echo'" class="panel-collapse collapse">';
        echo '<div class="panel-body">';

        $this->write_download_buttons();

        echo '</div></div></div>';


        echo'</div>';

    }


}

# PTT Advisor App
$ptt_short_desc = 'Assists clinical providers in their evaluation of patients with an abnormal clinical laboratory blood test, specifically an abnormal PTT (Partial Thromboplastin Time).';
$ptt_project = new Project('ptt-advisor', 'PTT Advisor', $ptt_short_desc, 'images/ptt_icon.png');

$ptt_itunes_link = "https://itunes.apple.com/us/app/ptt-advisor/id537989131?mt=8&ls=1";
$ptt_ios_app = new IosApp('1.0.3.001', '7/6/12', '1.3MB', 'PTTAdvisor.ipa', $ptt_itunes_link);
$ptt_project->add_ios_app($ptt_ios_app);

# Photon (MMWR Express) App  settings
$photon_short_desc = 'Provides fast access to the blue summary boxes in MMWR\'s weekly report. Summaries are searchable by specific article, or by specific subject (e.g., salmonella). For iOS devices.';
$photon_project = new Project('photon', 'MMWR Express', $photon_short_desc, 'images/mmwr_express_icon.png');

$photon_itunes_link = "https://itunes.apple.com/us/app/mmwr-express/id868245971?mt=8";
$photon_ios_app = new IosApp('1.0.0','5/6/14', '3.2MB', 'photon.ipa', $photon_itunes_link);
$photon_project->add_ios_app($photon_ios_app);

# Lydia settings
$lydia_short_desc = 'Provides fast access to the blue summary boxes in MMWR\'s weekly report. Summaries are searchable by specific article, or by specific subject (e.g., salmonella). For iOS devices.';
$lydia_project = new Project('lydia', 'STD Tx Guide 2014', $lydia_short_desc, 'images/std1_icon.png');
$lydia_ios_app = new IosApp('0.1.3.3', '8/26/14', '417KB', 'StdTxGuide.ipa', null);
$lydia_ios_app->set_bundle_id('gov.cdc.StdTxGuide');
$lydia_project->add_ios_app($lydia_ios_app);
$lydia_android_app = new AndroidApp('0.3.1','8/26/14', '732KB', 'lydia-release.apk', null);
$lydia_project->add_android_app($lydia_android_app);

# CLIP settings
$clip_short_desc = 'Created in collaboration with National Healthcare Safety Network (NHSN), this app brings the Central Line Insertion Practices Adherence Monitoring form to the iPad.';
$clip_project = new Project('clip', 'NHSN CLIP', $clip_short_desc, 'images/clip_icon.png');
$clip_ios_app = new IosApp('0.5.12.001', '6/1/2012', '1.9MB', 'clipam.ipa', null);
$clip_project->add_ios_app($clip_ios_app);


# Epi Info (Stat Calc) iPad App
$epi_short_desc = 'Created by CDC\'s Epi InfoTM team, this app adapts the StatCalc statistical calculators, a feature of Epi Info desktop software, for the iPad and iPhone.';
$epi_project = new Project('epi', 'Epi Info', $epi_short_desc, 'images/epi_icon.png');
$epi_ios_app = new IosApp('2.0', '9/5/14', '15.7MB', 'EpiInfo.ipa', null);
$epi_project->add_ios_app($epi_ios_app);


# NIOSH Mine Safety Sim App
$minesim_short_desc = 'Designed in collaboration with NIOSH (CDC\'s National Institute for Occupational Safety and Health), this proof-of-concept prototype trains mine workers on safety issues.';
$minesim_project = new Project('minesim', 'NIOSH Mine Safety Training', $minesim_short_desc, 'images/mine_safety_icon.png');
$minesim_ios_app = new IosApp('0.7301.276', '6/19/2012', '38.8MB', 'mine_sim.ipa', null);
$minesim_project->add_ios_app($minesim_ios_app);

# MMWR Map App
$mmwr_map_short_desc = 'The MMWR brought to the iPad via a map-based navigation interface. The geographic areas relating to MMWR articles are indicated. There are a variety of filtering options.';
$mmwr_map_project = new Project('mapapp', 'MMWR Map Navigator', $mmwr_map_short_desc, 'images/mmwr_map_icon.png');
$mmwr_map_ios_app = new IosApp('1.3.4.1', '5/5/14', '328KB', 'MapApp.ipa', null);
$mmwr_map_project->add_ios_app($mmwr_map_ios_app);

# MMWR Navigator App
$mmwr_nav_short_desc = 'Utilizes the iPad\'s split screen interface to display MMWR content in a user-friendly way. Articles are organized into intuitive categories, making them easy to find.';
$mmwr_nav_project = new Project('mmwr-navigator', 'MMWR Navigator', $mmwr_nav_short_desc, 'images/mmwr_nav_icon.png');
$mmwr_nav_ios_app = new IosApp('0.8.11.1', '5/5/14', '10.9MB', 'mmwr-navigator.ipa', null);
$mmwr_nav_project->add_ios_app($mmwr_nav_ios_app);


# Pedigree (Family History )iPhone App settings
$pedigree_short_desc = 'Allows users to record their family health history in one easy-to-reference, centralized place. This app makes it easy to share one\'s family health history with a clinician. For iPhone.';
$pedigree_project = new Project('pedigree', 'Family Heath History', $pedigree_short_desc, 'images/family_hx_icon.png');
$pedigree_ios_app = new IosApp('0.4.10.1', '4/15/14', '925KB', 'FamilyHistory.ipa', null);
$photon_ios_app->set_bundle_id('gov.cdc.FamilyHistory');
$pedigree_project->add_ios_app($pedigree_ios_app);

# NIOSH Respirator App
$respguide_short_desc = 'Built in collaboration with The National Institute for Occupational Safety and Health (NIOSH). For quickly exploring the database of NIOSH-approved particulate filtering facepiece respirators.';
$respguide_project = new Project('respguide', 'NIOSH Facepiece Respirator Guide', $respguide_short_desc, 'images/niosh_face_icon.png');
$respguide_ios_app = new IosApp('1.2.8.001', '6/4/2012', '321KB', 'Respirator%20Guide.ipa', null);
$respguide_project->add_ios_app($respguide_ios_app);

# Retro iPad App
$retro_short_desc = 'Focuses on HIV Risk Assessment — specifically, Assessing your Risk of Contracting HIV (ARCH). This tool is the first in the ARCH suite to be delivered on a mobile platform.';
$retro_project = new Project('retro', 'ARCH-Couples', $retro_short_desc, 'images/retro_icon.png');
$retro_ios_app = new IosApp('0.2.1.1', '5/5/14', '957KB', 'retro.ipa', null);
$retro_project->add_ios_app($retro_ios_app);

# STD 1 settings
$std1_short_desc = 'Early mobile application prototype for CDC\'s 2010 STD Treatment Guidelines. A Reference for clinicians on the identification of and treatment regimen for STDs.';
$std1_project = new Project('stdguide', 'STD Guide, Version 1', $std1_short_desc, 'images/std1_icon.png');
$std1_ios_app = new IosApp('0.4.4.001', '6/4/2012', '1.73MB', 'Std-Guide.ipa', null);
$std1_project->add_ios_app($std1_ios_app);

# STD 2 settings
$std2_short_desc = 'Enhanced prototype for CDC\'s 2010 STD Treatment Guidelines. A Reference for clinicians on the identification of and treatment regimen for STDs. Version 2 has a more "portal" feel than v1.';
$std2_project = new Project('std2', 'STD Guide, Version 2', $std2_short_desc, 'images/std2_icon.png');
$std2_ios_app = new IosApp('0.9.3.001', '6/4/2012', '2.36MB', 'STD%20Guide%202.ipa', null);
$std2_project->add_ios_app($std2_ios_app);


# STD 3 settings
$std3_short_desc = 'The goal of this unique prototype has been to collaborate with CDC\'s STD team to design mobile apps for the iOS and Android operating systems based on the 2010 STD Treatment Guidelines.';
$std3_project = new Project('std3', 'STD Guide, Version 3', $std3_short_desc, 'images/std3_icon.png');
$std3_ios_app = new IosApp('1.0.9', '6/5/2013', '8.1MB', 'StdGuide3.ipa', 'https://itunes.apple.com/us/app/std-tx-guide/id655206856?mt=8');
$std3_project->add_ios_app($std3_ios_app);
$std3_android_app = new AndroidApp('0.3.1','8/26/14', '732KB', 'StdGuide.apk', 'https://play.google.com/store/apps/details?id=gov.cdc.oid.nchhstp.stdguide');
$std3_project->add_android_app($std3_android_app);

# Tox Guide iPhone App
$tox_guide_short_desc = 'Quick reference guide provides information such as chemical and physical properties, sources of exposure, minimal risk levels, children\'s health, and health effects.';
$tox_guide_project = new Project('toxguide', 'ATSDR ToxGuide', $tox_guide_short_desc, 'images/tox_icon.png');
$tox_guide_ios_app = new IosApp('0.6.2.001', '6/1/2012', '254KB', 'mToxGuide.ipa', null);
$tox_guide_project->add_ios_app($tox_guide_ios_app);

# Wisqars App
$wisqars_short_desc = 'Allows for sharing injury-related information on a tablet. It dynamically displays selected leading causes of injury death data using maps and charts of national and state-level death counts and rates.';
$wisqars_project = new Project('wisqars', 'WISQARS Mobile', $wisqars_short_desc, 'images/WISQARSMobileApp72.png');
$wisqars_ios_app = new IosApp('0.2.7', '9/13/13', '18.5MB', 'WisqarsMobile.ipa', null);
$wisqars_project->add_ios_app($wisqars_ios_app);

$ios_projects = array (
    $lydia_project->name => $lydia_project,
    $pedigree_project->name => $pedigree_project
);