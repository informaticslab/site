<?php
/**
 * Created by PhpStorm.
 * User: jtq6
 * Date: 3/26/14
 * Time: 5:14 PM
 */

# server setting
#$server = 'edemo';
define('SERVER','www');  # live
define('SERVER_DOMAIN', SERVER.'.phiresearchlab.org');
define('DOWNLOADS_PATH_ROOT','applab/downloads/');

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
        $this->manifest_link = self::MANIFEST_PREFIX.SERVER_DOMAIN.$this->ios_dir.self::MANIFEST_FILE;

    }

    public function write_download_buttons() {

        if($this->itunes_link) {
            echo '<a href="';
            echo $this->itunes_link;
            echo '" class="btn btn-info">iTunes Download</a>';
        }
        if($this->manifest_link) {
            echo '<a href="';
            echo $this->manifest_link;
            echo '" class="btn btn-info">iOS Download</a>';
        }

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

        if($this->google_play_link) {
            echo '<a href="';
            echo $this->$google_play_link;
            echo '" class="btn btn-success">Google Play Link</a>';
        }
        if($this->apk_path) {
            echo '<a href="';
            echo $this->apk_path;
            echo '" class="btn btn-success">Android Download</a>';
        }
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
        $this->long_description = $long_desc;
        $this->icon = $icon;
        $this->download_path = DOWNLOADS_PATH_ROOT.$name;


    }

    public function write_download_buttons() {

        echo '<!-- start output from php project->write_download_buttons() function -->';

        echo '<div class="btn-toolbar">';
        if ($this->ios_app) {
            $this->ios_app->write_download_buttons();
        }
        if ($this->android_app) {
            $this->android_app->write_download_buttons();
        }

        echo '</div>';

        echo '<!-- end output from php project->write_download_buttons() function -->';

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
        echo '</div></div></div>';
        echo '<!-- end output from php project->write_panel_body() function -->';


    }

    public function write_panel_footer() {
        echo '<!-- start output from php project->write_panel_footer() function -->';
        echo '<div class="panel-footer">';
        $this->write_download_buttons();
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


}




# PTT Advisor App
$ptt_short_desc = 'Assists clinical providers in their evaluation of patients with an abnormal clinical laboratory blood test, specifically an abnormal PTT (Partial Thromboplastin Time).';
$ptt_project = new Project('ptt', 'PTT Advisor', $ptt_short_desc, 'images/ptt_icon.png');

$ptt_itunes_link = "https://itunes.apple.com/us/app/ptt-advisor/id537989131?mt=8&ls=1";
$ptt_ios_app = new IosApp('1.0.3', '7/6/12', '1.3MB', 'PTTAdvisor.ipa', $ptt_itunes_link);
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
$lydia_project->add_ios_app($lydia_ios_app);

$lydia_android_app = new AndroidApp('0.3.1','8/26/14', '732KB', 'lydia-release.apk', null);
$lydia_project->add_android_app($lydia_android_app);




# end of new PHP app classes conversion


# CLIP settings
$clip_version = '0.5.12.001';
$clip_release_date = '6/1/2012';
$clip_size = '1.9MB';
$clip_ipa = 'clipam.ipa';
$clip_app_path = "$downloads_path/clip/$clip_version";

$clip_manifest_link = "$ios_manifest_prefix$server_domain/$clip_app_path/manifest.plist";
$clip_ipa_path = "../$clip_app_path/$clip_ipa";

# Epi Info (Stat Calc) iPad App
$epi_info_version = '1.9';
$epi_info_release_date = '5/14/14';
$epi_info_size = '12.8MB';
$epi_info_ipa = 'EpiInfo.ipa';
$epi_info_app_path = "$downloads_path/epi/$epi_info_version";

$epi_info_manifest_link = "$ios_manifest_prefix$server_domain/$epi_info_app_path/manifest.plist";
$epi_info_ipa_path = "../$epi_info_app_path/$epi_info_ipa";


# NIOSH Mine Safety Sim App
$minesim_version = '0.7301.276';
$minesim_release_date = '6/19/2012';
$minesim_size = '38.8MB';
$minesim_ipa = 'mine_sim.ipa';
$minesim_app_path = "$downloads_path/minesim/$minesim_version";

$minesim_manifest_link = "$ios_manifest_prefix$server_domain/$minesim_app_path/manifest.plist";
$minesim_ipa_path = "../$minesim_app_path/$minesim_ipa";

# MMWR Map App
$mmwr_map_version = '1.3.4.1';
$mmwr_map_release_date = '5/5/14';
$mmwr_map_size = '328KB';
$mmwr_map_ipa = 'MapApp.ipa';
$mmwr_map_app_path = "$downloads_path/mapapp/$mmwr_map_version";

$mmwr_map_manifest_link = "$ios_manifest_prefix$server_domain/$mmwr_map_app_path/manifest.plist";
$mmwr_map_ipa_path = "../$mmwr_map_app_path/$mmwr_map_ipa";

# MMWR Navigator App
$mmwr_nav_version = '0.8.11.1';
$mmwr_nav_release_date = '5/5/14';
$mmwr_nav_size = '10.9MB';
$mmwr_nav_ipa = 'mmwr-navigator.ipa';
$mmwr_nav_app_path = "$downloads_path/mmwr-navigator/$mmwr_nav_version";

$mmwr_nav_manifest_link = "$ios_manifest_prefix$server_domain/$mmwr_nav_app_path/manifest.plist";
$mmwr_nav_ipa_path = "../$mmwr_nav_app_path/$mmwr_nav_ipa";

# Pedigree (Family History )iPhone App settings
$pedigree_version = '0.4.10.1';
$pedigree_release_date = '04/15/14';
$pedigree_size = '';
$pedigree_ipa = 'FamilyHistory.ipa';
$pedigree_app_path = "$downloads_path/pedigree/$pedigree_version";

$pedigree_manifest_link = "$ios_manifest_prefix$server_domain/$pedigree_app_path/manifest.plist";
$pedigree_ipa_path = "../$pedigree_app_path/$pedigree_ipa";

# NIOSH Respirator App
$respguide_version = '1.2.8.001';
$respguide_release_date = '6/4/2012';
$respguide_size = '321KB';
$respguide_ipa = 'Respirator%20Guide.ipa';
$respguide_app_path = "$downloads_path/respguide/$respguide_version";

$respguide_manifest_link = "$ios_manifest_prefix$server_domain/$respguide_app_path/manifest.plist";
$respguide_ipa_path = "../$respguide_app_path/$respguide_ipa";


# Retro iPad App
$retro_version = '0.2.1.1';
$retro_release_date = '5/5/14';
$retro_size = '957KB';
$retro_ipa = 'retro.ipa';
$retro_app_path = "$downloads_path/retro/$retro_version";

$retro_manifest_link = "$ios_manifest_prefix$server_domain/$retro_app_path/manifest.plist";
$retro_ipa_path = "../$retro_app_path/$retro_ipa";

# STD 1 settings
$std1_version = '0.4.4.001';
$std1_release_date = '6/4/2012';
$std1_size = '1.73MB';
$std1_ipa = 'Std-Guide.ipa';
$std1_app_path = "$downloads_path/stdguide/$std1_version";

$std1_manifest_link = "$ios_manifest_prefix$server_domain/$std1_app_path/manifest.plist";
$std1_ipa_path = "../$std1_app_path/$std1_ipa";

# STD 2 settings
$std2_version = '0.9.3.001';
$std2_release_date = '6/4/2012';
$std2_size = '2.36MB';
$std2_ipa = 'STD%20Guide%202.ipa';
$std2_app_path = "$downloads_path/std2/$std2_version";

$std2_manifest_link = "$ios_manifest_prefix$server_domain/$std2_app_path/manifest.plist";
$std2_ipa_path = "../$std2_app_path/$std2_ipa";

# STD 3 settings
$std3_version = '1.0.9';
$std3_release_date = '6/5/2013';
$std3_size = '8.1MB';
$std3_ipa = '';
$std3_app_path = "$downloads_path/std3/$std3_version";

$std3_itunes_link = "https://itunes.apple.com/us/app/std-tx-guide/id655206856?mt=8";
$std3_google_play_link = "https://play.google.com/store/apps/details?id=gov.cdc.oid.nchhstp.stdguide";
$std3_ipa_path = "../$std3_app_path/$std3_ipa";


# Tox Guide iPhone App
$tox_guide_version = '0.6.2.001';
$tox_guide_release_date = '6/1/2012';
$tox_guide_size = '254KB';
$tox_guide_ipa = 'mToxGuide.ipa';
$tox_guide_app_path = "$downloads_path/toxguide/$tox_guide_version";

$tox_guide_manifest_link = "$ios_manifest_prefix$server_domain/$tox_guide_app_path/manifest.plist";
$tox_guide_ipa_path = "../$tox_guide_app_path/$tox_guide_ipa";

# Wisqars App
$wisqars_version = '0.2.7';
$wisqars_release_date = '9/13/13';
$wisqars_size = '18.5MB';
$wisqars_ipa = 'WisqarsMobile.ipa';
$wisqars_app_path = "$downloads_path/wisqars";

$wisqars_manifest_link = "$ios_manifest_prefix$server_domain/$wisqars_app_path/manifest.plist";
$wisqars_ipa_path = "../$wisqars_app_path/$wisqars_ipa";

#
?>
