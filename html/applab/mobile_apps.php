<?php
/**
 * Created by PhpStorm.
 * User: jtq6
 * Date: 3/26/14
 * Time: 5:14 PM
 */

# server setting
#$server = 'edemo';
$server = 'www';  # live

$manifest_file = "manifest.plist";
$server_domain = "$server.phiresearchlab.org";

# common iOS settings
$ios_manifest_prefix = 'itms-services://?action=download-manifest&url=https://';

# CLIP settings
$clip_version = '0.5.12.001';
$clip_release_date = '6/1/2012';
$clip_size = '1.9MB';
$clip_ipa = 'clipam.ipa';
$clip_app_path = "applab/downloads/clip/$clip_version";

$clip_manifest_link = "$ios_manifest_prefix$server_domain/$clip_app_path/manifest.plist";
$clip_ipa_path = "../$clip_app_path/$clip_ipa";

# Epi Info (Stat Calc) iPad App
$epi_info_version = '0.9';
$epi_info_release_date = '';
$epi_info_size = '';
$epi_info_ipa = 'EpiInfo.ipa';
$epi_info_app_path = "applab/downloads/betas/epi/$epi_info_version";

$epi_info_manifest_link = "$ios_manifest_prefix$server_domain/$epi_info_app_path/manifest.plist";
$epi_info_ipa_path = "../$epi_info_app_path/$epi_info_ipa";

# NIOSH Mine Safety Sim App
$minesim_version = '0.7301.276';
$minesim_release_date = '6/19/2012';
$minesim_size = '38.8MB';
$minesim_ipa = 'mine_sim.ipa';
$minesim_app_path = "applab/downloads/minesim/$minesim_version";

$minesim_manifest_link = "$ios_manifest_prefix$server_domain/$minesim_app_path/manifest.plist";
$minesim_ipa_path = "../$minesim_app_path/$minesim_ipa";

# MMWR Map App
$mmwr_map_version = '1.3.2.001';
$mmwr_map_release_date = '10/23/13';
$mmwr_map_size = '328KB';
$mmwr_map_ipa = 'MapApp.ipa';
$mmwr_map_app_path = "applab/downloads/mapapp/$mmwr_map_version";

$mmwr_map_manifest_link = "$ios_manifest_prefix$server_domain/$mmwr_map_app_path/manifest.plist";
$mmwr_map_ipa_path = "../$mmwr_map_app_path/$mmwr_map_ipa";

# MMWR Navigator App
$mmwr_nav_version = '0.8.9.001';
$mmwr_nav_release_date = '10/23/13';
$mmwr_nav_size = '10.9MB';
$mmwr_nav_ipa = 'mmwr-navigator.ipa';
$mmwr_nav_app_path = "applab/downloads/mmwr-navigator/$mmwr_nav_version";

$mmwr_nav_manifest_link = "$ios_manifest_prefix$server_domain/$mmwr_nav_app_path/manifest.plist";
$mmwr_nav_ipa_path = "../$mmwr_nav_app_path/$mmwr_nav_ipa";

# Pedigree (Family History )iPhone App settings
$pedigree_version = '0.4.10.1';
$pedigree_release_date = '04/15/14';
$pedigree_size = '';
$pedigree_ipa = 'FamilyHistory.ipa';
$pedigree_app_path = "applab/downloads/pedigree/$pedigree_version";

$pedigree_manifest_link = "$ios_manifest_prefix$server_domain/$pedigree_app_path/manifest.plist";
$pedigree_ipa_path = "../$pedigree_app_path/$pedigree_ipa";

# Photon Universal App  settings
$photon_version = '0.10.14.6';
$photon_release_date = '4/11/14';
$photon_size = '2.7MB';
$photon_ipa = 'photon.ipa';
$photon_app_path = "applab/downloads/photon/$photon_version";

$photon_manifest_link = "$ios_manifest_prefix$server_domain/$photon_app_path/manifest.plist";
$photon_ipa_path = "../$photon_app_path/$photon_ipa";

# PTT Advisor App
$ptt_version = '1.0.3';
$ptt_release_date = '7/6/12';
$ptt_size = '1.3MB';
$ptt_ipa = '';
$ptt_app_path = "applab/downloads/ptt/$ptt_version";

$ptt_itunes_link = "http://itunes.apple.com/us/app/ptt-advisor/id537989131?mt=8&ls=1";
$ptt_manifest_link = "$ios_manifest_prefix$server_domain/$ptt_app_path/manifest.plist";
$ptt_ipa_path = "../$ptt_app_path/$ptt_ipa";


# NIOSH Respirator App
$respguide_version = '1.2.8.001';
$respguide_release_date = '6/4/2012';
$respguide_size = '321KB';
$respguide_ipa = 'Respirator%20Guide.ipa';
$respguide_app_path = "applab/downloads/respguide/$respguide_version";

$respguide_manifest_link = "$ios_manifest_prefix$server_domain/$respguide_app_path/manifest.plist";
$respguide_ipa_path = "../$respguide_app_path/$respguide_ipa";


# Retro iPad App
$retro_version = '0.1.6.1';
$retro_release_date = '9/17/13';
$retro_size = '957KB';
$retro_ipa = 'retro.ipa';
$retro_app_path = "applab/downloads/betas/retro/$retro_version";

$retro_manifest_link = "$ios_manifest_prefix$server_domain/$retro_app_path/manifest.plist";
$retro_ipa_path = "../$retro_app_path/$retro_ipa";

# STD 1 settings
$std1_version = '0.4.4.001';
$std1_release_date = '6/4/2012';
$std1_size = '1.73MB';
$std1_ipa = 'Std-Guide.ipa';
$std1_app_path = "applab/downloads/stdguide/$std1_version";

$std1_manifest_link = "$ios_manifest_prefix$server_domain/$std1_app_path/manifest.plist";
$std1_ipa_path = "../$std1_app_path/$std1_ipa";

# STD 2 settings
$std2_version = '0.9.3.001';
$std2_release_date = '6/4/2012';
$std2_size = '2.36MB';
$std2_ipa = 'STD%20Guide%202.ipa';
$std2_app_path = "applab/downloads/std2/$std2_version";

$std2_manifest_link = "$ios_manifest_prefix$server_domain/$std2_app_path/manifest.plist";
$std2_ipa_path = "../$std2_app_path/$std2_ipa";

# STD 3 settings
$std3_version = '1.0.9';
$std3_release_date = '6/5/2013';
$std3_size = '8.1MB';
$std3_ipa = '';
$std3_app_path = "applab/downloads/std3/$std3_version";

$std3_itunes_link = "https://itunes.apple.com/us/app/std-tx-guide/id655206856?mt=8";
$std3_google_play_link = "https://play.google.com/store/apps/details?id=gov.cdc.oid.nchhstp.stdguide";
$std3_ipa_path = "../$std3_app_path/$std3_ipa";


# Tox Guide iPhone App
$tox_guide_version = '0.6.2.001';
$tox_guide_release_date = '6/1/2012';
$tox_guide_size = '254KB';
$tox_guide_ipa = 'mToxGuide.ipa';
$tox_guide_app_path = "applab/downloads/toxguide/$tox_guide_version";

$tox_guide_manifest_link = "$ios_manifest_prefix$server_domain/$tox_guide_app_path/manifest.plist";
$tox_guide_ipa_path = "../$tox_guide_app_path/$tox_guide_ipa";

# Wisqars App
$wisqars_version = '0.2.7';
$wisqars_release_date = '9/13/13';
$wisqars_size = '18.5MB';
$wisqars_ipa = 'WisqarsMobile.ipa';
$wisqars_app_path = "applab/downloads/wisqars";

$wisqars_manifest_link = "$ios_manifest_prefix$server_domain/$wisqars_app_path/manifest.plist";
$wisqars_ipa_path = "../$wisqars_app_path/$wisqars_ipa";



#
?>
