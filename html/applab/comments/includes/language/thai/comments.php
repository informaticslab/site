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

define ('CMTX_ANCHOR_COMMENTS', '#cmtx_comments');

define ('CMTX_COMMENTS_HEADING', 'ความคิดเห็น');

define ('CMTX_NO_COMMENTS', 'ยังไม่มีข้อความคิดเห็น');

define ('CMTX_SORT_1', 'ใหม่ล่าสุด');
define ('CMTX_SORT_2', 'เก่าแก่ที่สุด');
define ('CMTX_SORT_3', 'เป็นประโยชน์');
define ('CMTX_SORT_4', 'ไร้ประโยชน์');
define ('CMTX_SORT_5', 'บวก');
define ('CMTX_SORT_6', 'วิกฤต');

define ('CMTX_TITLE_SORT_1', 'เรียงการแสดงความคิดเห็นโดยใหม่เป็นอันดับแรก');
define ('CMTX_TITLE_SORT_2', 'เรียงการแสดงความคิดเห็นโดยที่เก่าแก่ที่สุดก่อน');
define ('CMTX_TITLE_SORT_3', 'เรียงตามความคิดเห็นที่เป็นประโยชน์มากที่สุดก่อน');
define ('CMTX_TITLE_SORT_4', 'เรียงการแสดงความคิดเห็นโดยไร้ประโยชน์มากที่สุดก่อน');
define ('CMTX_TITLE_SORT_5', 'เรียงการแสดงความคิดเห็นโดยบวกมากที่สุดก่อน');
define ('CMTX_TITLE_SORT_6', 'เรียงการแสดงความคิดเห็นโดยที่สำคัญที่สุดก่อน');

define ('CMTX_TITLE_FULL_STAR', 'ดาวเต็มดวง');
define ('CMTX_TITLE_HALF_STAR', 'ดาวครึ่งดวง');
define ('CMTX_TITLE_EMPTY_STAR', 'ดาวไร้ดวง');

define ('CMTX_SAYS', 'แสดงความคิดเห็น...');

define ('CMTX_REPLY_INTRO', 'ผู้ควบคุมดูแล:');

define ('CMTX_TODAY', 'วันนี้');
define ('CMTX_YESTERDAY', 'เมื่อวาน');

define ('CMTX_TITLE_VOTE_UP', 'โหวต: เห็นด้วย');
define ('CMTX_TITLE_VOTE_DOWN', 'โหวต: ไม่เห็นด้วย');
define ('CMTX_VOTE_UP', 'ขอบคุณที่โหวต!');
define ('CMTX_VOTE_DOWN', 'ขอบคุณที่โหวต!');
define ('CMTX_VOTE_NO_COMMENT', 'ไม่พบข้อความคิดเห็นนี้');
define ('CMTX_VOTE_OWN_COMMENT', 'คุณไม่สามารถลงคะแนนสำหรับความเห็นของคุณเอง!');
define ('CMTX_VOTE_ALREADY_VOTED', 'คุณได้โหวตสำหรับข้อความคิดเห็นนี้ไปแล้ว');
define ('CMTX_VOTE_BANNED', 'คุณได้รับก่อนหน้านี้ห้าม!');

define ('CMTX_FLAG', 'รายงาน');
define ('CMTX_TITLE_FLAG', 'รายงานข้อความคิดเห็นนี้t');
define ('CMTX_FLAG_CONFIRM', 'คุณแน่ใจว่าคุณต้องการรายงานเกี่ยวกับข้อความคิดเห็นนี้?');
define ('CMTX_FLAG_REASON', 'กรุณาให้เหตุผลว่าทำไมจึงต้องรายงาน');
define ('CMTX_FLAG_NO_REASON', 'คุณจำเป็นต้องให้เหตุผลว่าทำไมจึงต้องการรายงาน');
define ('CMTX_FLAG_NO_COMMENT', 'ไม่พบข้อความคิดเห็นนี้');
define ('CMTX_FLAG_OWN_COMMENT', 'คุณไม่สามารถรายงานความเห็นของคุณเอง!');
define ('CMTX_FLAG_BAD_REPORT', 'คุณได้ส่งรายงาน ซึ่งอาจก่อความเสียหาย ก่อนหน้านี้!');
define ('CMTX_FLAG_BANNED', 'คุณได้รับก่อนหน้านี้ห้าม!');
define ('CMTX_FLAG_REPORT_LIMIT', 'คุณไม่สามารถรายงานเกี่ยวกับข้อความคิดเห็นได้อีก');
define ('CMTX_FLAG_ALREADY_REPORTED', 'คุณได้รายงานเกี่ยวกับข้อความคิดเห็นนี้แล้ว');
define ('CMTX_FLAG_ALREADY_FLAGGED', 'ข้อความคิดเห็นนี้ถูกรายงานแล้ว');
define ('CMTX_FLAG_ALREADY_VERIFIED', 'ข้อความคิดเห็นนี้ได้รับการตรวจสอบแล้ว');
define ('CMTX_FLAG_REPORT_SENT', 'ขอบคุณสำหรับการรายงาน');

define ('CMTX_REPLY', 'ตอบ');
define ('CMTX_TITLE_REPLY', 'ตอบข้อความคิดเห็นนี้');

define ('CMTX_RSS_THIS_PAGE', 'หน้านี้');
define ('CMTX_RSS_ALL_PAGES', 'ทุกหน้า');
define ('CMTX_TITLE_RSS_THIS', 'รับโค้ด RSS เพื่อติดตามความเคลื่อนไหวของหน้านี้');
define ('CMTX_TITLE_RSS_ALL', 'รับโค้ด RSS เพื่อติดตามความเคลื่อนไหวของทุกหน้า');

define ('CMTX_INFO_PAGE', 'หน้า');
define ('CMTX_INFO_OF', 'จาก');
define ('CMTX_INFO_COMMENT', 'ข้อความคิดเห็น');
define ('CMTX_INFO_COMMENTS', 'ข้อความคิดเห็น');

define ('CMTX_PAGINATION_FIRST', '[หน้าแรก]');
define ('CMTX_PAGINATION_PREVIOUS', '<');
define ('CMTX_PAGINATION_NEXT', '>');
define ('CMTX_PAGINATION_LAST', '[หน้าสุดท้าย]');
define ('CMTX_TITLE_PAG_FIRST', 'หน้าแรก');
define ('CMTX_TITLE_PAG_PREVIOUS', 'หน้าก่อนหน้า');
define ('CMTX_TITLE_PAG_NEXT', 'หน้าถัดไป');
define ('CMTX_TITLE_PAG_LAST', 'หน้าสุดท้าย');

?>