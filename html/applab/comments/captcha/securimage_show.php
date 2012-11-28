<?php

/**
 * Project:     Securimage: A PHP class for creating and managing form CAPTCHA images<br />
 * File:        securimage_show.php<br />
 *
 * Copyright (c) 2011, Drew Phillips
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:
 * 
 *  - Redistributions of source code must retain the above copyright notice,
 *    this list of conditions and the following disclaimer.
 *  - Redistributions in binary form must reproduce the above copyright notice,
 *    this list of conditions and the following disclaimer in the documentation
 *    and/or other materials provided with the distribution.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * Any modifications to the library should be indicated clearly in the source code
 * to inform users that the changes are not a part of the original software.<br /><br />
 *
 * If you found this script useful, please take a quick moment to rate it.<br />
 * http://www.hotscripts.com/rate/49400.html  Thanks.
 *
 * @link http://www.phpcaptcha.org Securimage PHP CAPTCHA
 * @link http://www.phpcaptcha.org/latest.zip Download Latest Version
 * @link http://www.phpcaptcha.org/Securimage_Docs/ Online Documentation
 * @copyright 2011 Drew Phillips
 * @author Drew Phillips <drew@drew-phillips.com>
 * @version 3.0 (October 2011)
 * @package Securimage
 *
 */

// Remove the "//" from the following line for debugging problems
// error_reporting(E_ALL); ini_set('display_errors', 1);

require_once dirname(__FILE__) . '/securimage.php';

$img = new securimage();

// You can customize the image by making changes below, some examples are included - remove the "//" to uncomment

if (isset($_SERVER['HTTP_USER_AGENT']) && stripos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false) {
$img->image_width = 158;
} else if (isset($_SERVER['HTTP_USER_AGENT']) && stripos($_SERVER['HTTP_USER_AGENT'], 'Firefox') !== false) {
$img->image_width = 152;
} else if (isset($_SERVER['HTTP_USER_AGENT']) && stripos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== false) {
$img->image_width = 160;
} else {
$img->image_width = 145;
}
$img->image_height = 50;
$img->code_length = 4;
$img->num_lines = 3;
$img->image_bg_color = new Securimage_Color("#F0F0F0");
$img->charset = 'abcdefghjkmnpqrtuvwyz123456789';
$img->perturbation = 0.5; // 1.0 = high distortion, higher numbers = more distortion
$img->text_color = new Securimage_Color('#525252');
$img->line_color = new Securimage_Color('#525252');

// see securimage.php for more options that can be set



$img->show();  // outputs the image and content headers to the browser
// alternate use: 
// $img->show('/path/to/background_image.jpg');
