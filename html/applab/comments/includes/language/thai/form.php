<?php
/*
Copyright © 2009-2012 Commentics Development Team [commentics.org]
License: GNU General Public License v3.0
		 http://www.commentics.org/license/

This file is part of Commentics.

Commentics is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Commentics is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Commentics. If not, see <http://www.gnu.org/licenses/>.

Text to help preserve UTF-8 file encoding: 汉语漢語.
*/

if (!defined("IN_COMMENTICS")) { die("Access Denied."); }

/* Anchors */
define ('CMTX_ANCHOR_FORM', '#cmtx_form');
define ('CMTX_ANCHOR_RESET', '#cmtx_reset');

/* Heading */
define ('CMTX_FORM_HEADING', 'เพิ่มความคิดเห็น');

/* Form disabled messages */
define ('CMTX_ALL_FORMS_DISABLED', 'การแสดงความคิดเห็น ไม่ได้เปิดใช้งาน');
define ('CMTX_THIS_FORM_DISABLED', 'การแสดงความคิดเห็นสำหรับเนื้อหาในหน้านี้ ไม่สามารถดำเนินการได้');

/* JavaScript disabled message */
define ('CMTX_JAVASCRIPT_DISABLED', 'ต้องเปิดใช้งาน JavaScript คุณสมบัติซึ่งเป็นองค์ประกอบจึงสามารถทำงานได้');

/* Reply */
define ('CMTX_REPLY_MESSAGE', 'คุณกำลังตอบข้อความคิดเห็นของ');
define ('CMTX_REPLY_CANCEL', '[ยกเลิก]');
define ('CMTX_REPLY_NOBODY', 'คุณไม่ได้กำลังตอบข้อความคิดเห็นของผู้ใด');

/* Required */
define ('CMTX_REQUIRED_SYMBOL', '*');
define ('CMTX_REQUIRED_SYMBOL_MESSAGE', CMTX_REQUIRED_SYMBOL . ' ข้อมูลซึ่งต้องระบุ');

/* Field labels */
define ('CMTX_LABEL_NAME', 'ชื่อ:');
define ('CMTX_LABEL_EMAIL', 'ที่อยู่อีเมล:');
define ('CMTX_LABEL_WEBSITE', 'ที่อยู่เว็บไซต์:');
define ('CMTX_LABEL_TOWN', 'ชื่อเมือง:');
define ('CMTX_LABEL_COUNTRY', 'ชื่อประเทศ:');
define ('CMTX_LABEL_RATING', 'โหวต:');
define ('CMTX_LABEL_COMMENT', 'ข้อความคิดเห็น:');
define ('CMTX_LABEL_QUESTION', 'คำถาม:');
define ('CMTX_LABEL_CAPTCHA', 'โค้ด:');

/* Field titles */
define ('CMTX_TITLE_NAME', 'พิมพ์ชื่อ');
define ('CMTX_TITLE_EMAIL', 'พิมพ์ที่อยู่อีเมล');
define ('CMTX_TITLE_WEBSITE', 'พิมพ์ที่อยู่เว็บไซต์');
define ('CMTX_TITLE_TOWN', 'พิมพ์ชื่อเมืองที่อาศัยอยู่');
define ('CMTX_TITLE_COUNTRY', 'พิมพ์ชื่อประเทศที่อาศัยอยู่');
define ('CMTX_TITLE_RATING', 'เลือกระดับคะแนน');
define ('CMTX_TITLE_COMMENT', 'พิมพ์ข้อความคิดเห็น');
define ('CMTX_TITLE_QUESTION', 'พิมพ์คำตอบที่ถูกต้องตรงกับคำถาม');
define ('CMTX_TITLE_CAPTCHA_IMAGE', 'ภาพโค้ด');
define ('CMTX_TITLE_CAPTCHA_AUDIO', 'ฟังการออกเสียงตามภาพโค้ด');
define ('CMTX_TITLE_CAPTCHA_REFRESH', 'เปลี่ยนภาพโค้ด');
define ('CMTX_TITLE_CAPTCHA', 'พิมพ์อักขระซึ่งตรงกับภาพโค้ด');
define ('CMTX_TITLE_NOTIFY', 'ประสงค์รับ อีเมลแจ้งเตือน');
define ('CMTX_TITLE_PRIVACY', 'ยอมรับตามนโยบายส่วนบุคคล');
define ('CMTX_TITLE_TERMS', 'ยอมรับตามเงื่อนไขและข้อตกลง');
define ('CMTX_TITLE_SUBMIT', 'เพิ่มข้อความคิดเห็น');
define ('CMTX_TITLE_PREVIEW', 'ดูตัวอย่างการแสดงผล');

/* Note displayed after email field */
define ('CMTX_NOTE_EMAIL', '(จะไม่ถูกเปิดเผย');

/* Countries */
define ('CMTX_TOP_COUNTRY', 'กรุณาเลือก');

/* Ratings */
define ('CMTX_TOP_RATING', 'กรุณาเลือกระดับคะแนน');
define ('CMTX_RATING_ONE', 'ไร้ประโยชน์');
define ('CMTX_RATING_TWO', 'พอใช้ได้');
define ('CMTX_RATING_THREE', 'ใช้ได้');
define ('CMTX_RATING_FOUR', 'ดี');
define ('CMTX_RATING_FIVE', 'ดีเยี่ยม');

/* Text displayed for JavaScript BB Code prompts */
define ('CMTX_PROMPT_ENTER_BULLET', 'พิมพ์รายการตามหัวข้อ คลิกยกเลิกโดยปล่อยให้เว้นว่างไว้เพื่อสิ้นสุดการพิมพ์รายการตามหัวข้อ');
define ('CMTX_PROMPT_ENTER_ANOTHER_BULLET', 'พิมพ์รายการในหัวข้ออื่น  คลิกยกเลิกโดยปล่อยให้เว้นว่างไว้เพื่อสิ้นสุดการพิมพ์รายการตามหัวข้อ');
define ('CMTX_PROMPT_ENTER_NUMERIC', 'พิมพ์รายการตามหัวข้อ  คลิกยกเลิกโดยปล่อยให้เว้นว่างไว้เพื่อสิ้นสุดการพิมพ์รายการตามหัวข้อ');
define ('CMTX_PROMPT_ENTER_ANOTHER_NUMERIC', 'พิมพ์รายการในหัวข้ออื่น  คลิกยกเลิกโดยปล่อยให้เว้นว่างไว้เพื่อสิ้นสุดการพิมพ์รายการตามหัวข้อ');
define ('CMTX_PROMPT_ENTER_LINK', 'กรุณาพิมพ์ที่อยู่เชื่อมโยงของเว็บไซต์');
define ('CMTX_PROMPT_ENTER_LINK_TITLE', 'ตัวเลือก ซึ่งช่วยให้คุณเพิ่ม ข้อความเชื่อมโยง เพื่อใช้แสดงผล');
define ('CMTX_PROMPT_ENTER_EMAIL', 'กรุณาพิมพ์ที่อยู่อีเมล');
define ('CMTX_PROMPT_ENTER_EMAIL_TITLE', 'ตัวเลือก ซึ่งช่วยให้คุณเพิ่ม ข้อความเชื่อมโยง เพื่อใช้แสดงผล');
define ('CMTX_PROMPT_ENTER_IMAGE', 'กรุณาพิมพ์ที่อยู่เชื่อมโยงของไฟล์ภาพ');
define ('CMTX_PROMPT_ENTER_VIDEO', 'กรุณาใส่ลิงค์ของวิดีโอ เว็บไซต์ที่สนับสนุน ได้แก่ : \ nYouTube, Vimeo, MetaCafe และ Dailymotion');

/* Text displayed for invalid BB Code entries */
define ('CMTX_BB_INVALID_LINK', '<i>(การเชื่อมโยงไม่ถูกต้อง)</i>');
define ('CMTX_BB_INVALID_EMAIL', '<i>(ที่อยู่อีเมลไม่ถูกต้อง)</i>');
define ('CMTX_BB_INVALID_IMAGE', '<i>(ที่อยู่ไฟล์ภาพไม่ถูกต้อง)</i>');
define ('CMTX_BB_INVALID_VIDEO', '<i>(วิดีโอที่ไม่ถูกต้อง)</i>');

/* Text displayed before question field */
define ('CMTX_TEXT_QUESTION', 'พิมพ์คำตอบ:');

/* Text displayed before captcha field */
define ('CMTX_TEXT_CAPTCHA', 'พิมพ์อักขระ:');

/* Text displayed after notify checkbox */
define ('CMTX_TEXT_NOTIFY', 'ส่งอีเมลแจ้งเตือนให้ฉันเมื่อมีข้อความคิดเห็นใหม่');

/* Text displayed after privacy checkbox */
define ('CMTX_TEXT_PRIVACY', 'ฉันได้อ่านและเข้าใจเป็นอย่างดีแล้วเกี่ยวกับ <a href="' . $settings->url_to_comments_folder . 'agreement/thai/privacy_policy.html" title="View privacy policy" target="_blank" rel="nofollow">นโยบายส่วนบุคคล</a>.');

/* Text displayed after terms checkbox */
define ('CMTX_TEXT_TERMS', 'ฉันได้อ่านและยอมรับตาม <a href="' . $settings->url_to_comments_folder . 'agreement/thai/terms_and_conditions.html" title="View terms and conditions" target="_blank" rel="nofollow">ข้อตกลงและเงื่อนไข</a>.');

/* Text for form submit button */
define ('CMTX_SUBMIT_BUTTON', 'เพิ่มข้อความคิดเห็น');

/* Text for form preview button */
define ('CMTX_PREVIEW_BUTTON', 'ดูตัวอย่างการแสดงผล');

/* Text for form buttons when processing */
define ('CMTX_PROCESSING_BUTTON', 'กรุณารอสักครู่..');

/* Text for 'powered by' statement */
define ('CMTX_POWERED_BY', 'ขับเคลื่อน โดย');
?>