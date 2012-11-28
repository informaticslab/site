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

/* Error box */
define ('CMTX_ERROR_NUMBER_PART_1', 'ขออภัย พบความผิดพลาดจากการส่งข้อความคิดเห็นของคุณ ทั้งหมด ');
define ('CMTX_ERRORS_NUMBER_PART_1', 'ขออภัย พบความผิดพลาดจากการส่งข้อความคิดเห็นของคุณ ทั้งหมด ');
define ('CMTX_ERROR_NUMBER_PART_2', ' แห่ง');
define ('CMTX_ERRORS_NUMBER_PART_2', ' แห่ง');
define ('CMTX_ERROR_CORRECTION', 'กรุณาแก้ไขความผิดพลาดที่เกิดขึ้นให้ถูกต้อง และส่งข้อความคิดเห็นของคุณอีกครั้ง:');
define ('CMTX_ERRORS_CORRECTION', 'กรุณาแก้ไขความผิดพลาดที่เกิดขึ้นให้ถูกต้อง และส่งข้อความคิดเห็นของคุณอีกครั้ง:');

/* Preview box */
define ('CMTX_PREVIEW_TEXT', 'ดูตัวอย่างการแสดงผลเท่านั้น');

/* Approval box */
define ('CMTX_APPROVAL_OPENING', 'ขอบคุณ');
define ('CMTX_APPROVAL_TEXT', 'ข้อความคิดเห็นของคุณอยู่ในระหว่างรอการตรวจสอบ');
define ('CMTX_APPROVAL_SUBSCRIBER', 'อีเมลเพื่อใช้ยืนยัน ถูกส่งไปยังที่อยู่อีเมลของคุณแล้ว');

/* Success box */
define ('CMTX_SUCCESS_OPENING', 'ขอบคุณ');
define ('CMTX_SUCCESS_TEXT', 'ข้อความคิดเห็นของคุณถูกเพิ่มแล้ว');
define ('CMTX_SUCCESS_SUBSCRIBER', 'อีเมลเพื่อใช้ยืนยันถูกส่งไปให้คุณแล้ว');

/* Error messages */
define ('CMTX_ERROR_MESSAGE_NO_NAME', 'ช่องระบุชื่อไม่สามารถเว้นว่าง กรุณาพิมพ์ชื่อของคุณ');
define ('CMTX_ERROR_MESSAGE_ONE_NAME', 'ช่องระบุชื่อ สำหรับระบุชื่อเพียงชื่อเดียว กรุณาพิมพ์ชื่อเพียงชื่อเดียว');
define ('CMTX_ERROR_MESSAGE_INVALID_NAME', 'ชื่อต้องประกอบด้วยพยัญชนะและสระ หรืออักขระอื่นซึ่งเป็นตัวเลือก ได้แก่ - & . 0-9 \'');
define ('CMTX_ERROR_MESSAGE_RESERVED_NAME', 'ชื่อซึ่งระบุตรงกับชื่อที่ถูกสงวนไว้ กรุณาใช้ชื่ออื่น');
define ('CMTX_ERROR_MESSAGE_BANNED_NAME', 'ชื่อซึ่งระบุตรงกับชื่อต้องห้าม กรุณาใช้ชื่ออื่น');
define ('CMTX_ERROR_MESSAGE_DUMMY_NAME', 'ชื่อซึ่งระบุไม่ใช่ชื่อของคุณ กรุณาพิมพ์ชื่อจริงของคุณ');
define ('CMTX_ERROR_MESSAGE_LINK_IN_NAME', 'ชื่อซึ่งระบุเป็นชื่อเชื่อมโยง กรุณาพิมพ์ชื่อจริงของคุณ');
define ('CMTX_ERROR_MESSAGE_NO_EMAIL', 'ช่องสำหรับที่อยู่อีเมลไม่สามารถเว้นว่าง กรุณาพิมพ์ที่อยู่อีเมลของคุณ');
define ('CMTX_ERROR_MESSAGE_INVALID_EMAIL', 'ที่อยู่อีเมลตามที่ระบุไม่ถูกต้อง กรุณาตรวจสอบ');
define ('CMTX_ERROR_MESSAGE_RESERVED_EMAIL', 'ที่อยู่อีเมลตามที่ระบุตรงกับที่อยู่อีเมลซึ่งถูกสงวนไว้ กรุณาพิมพ์ที่อยู่อีเมลของคุณ');
define ('CMTX_ERROR_MESSAGE_BANNED_EMAIL', 'ที่อยู่อีเมลตามที่ระบุตรงกับที่อยู่อีเมลต้องห้าม กรุณาใช้ที่อยู่อีเมลอื่น');
define ('CMTX_ERROR_MESSAGE_DUMMY_EMAIL', 'ที่อยู่อีเมลตามที่ระบุไม่ใช่ที่อยู่อีเมลของคุณ กรุณาพิมพ์ที่อยู่อีเมลของคุณ');
define ('CMTX_ERROR_MESSAGE_NO_WEBSITE', 'ช่องสำหรับระบุที่อยู่เว็บไซต์ไม่สามารถเว้นว่าง กรุณาพิมพ์ที่อยู่เว็บไซต์ของคุณ');
define ('CMTX_ERROR_MESSAGE_DEFAULT_WEBSITE', 'ที่อยู่เว็บไซต์ตามที่ระบุ ตรงกับที่อยู่เว็บไซต์หลักซึ่งถูกระบุไว้จากภายในส่วนควบคุม กรุณาพิมพ์ที่อยู่เว็บไซต์ของคุณ');
define ('CMTX_ERROR_MESSAGE_INVALID_WEBSITE', 'ที่อยู่เว็บไซต์ตามที่ระบุไม่ถูกต้อง กรุณาตรวจสอบ');
define ('CMTX_ERROR_MESSAGE_RESERVED_WEBSITE', 'ที่อยู่เว็บไซต์ตามที่ระบุตรงกับที่อยู่เว็บไซต์ซึ่งถูกสงวนไว้ กรุณาพิมพ์ที่อยู่เว็บไซต์ของคุณ');
define ('CMTX_ERROR_MESSAGE_BANNED_WEBSITE_IN_WEBSITE', 'ที่อยู่เว็บไซต์ตามที่ระบุตรงกับที่อยู่เว็บไซต์ต้องห้าม กรุณาลบออก');
define ('CMTX_ERROR_MESSAGE_BANNED_WEBSITE_IN_COMMENT', 'ที่อยู่เว็บไซต์ซึ่งปรากฏอยู่ในข้อความคิดเห็น ตรงกับที่อยู่เว็บไซต์ต้องห้าม กรุณาลบออก');
define ('CMTX_ERROR_MESSAGE_DUMMY_WEBSITE', 'ที่อยู่เว็บไซต์ตามที่ระบุไม่ใช่ที่อยู่เว็บไซต์ของคุณ กรุณาพิมพ์ที่อยู่เว็บไซต์ของคุณ');
define ('CMTX_ERROR_MESSAGE_NO_TOWN', 'ช่องสำหรับระบุชื่อเมืองที่คุณอาศัยอยู่ไม่สามารถเว้นว่าง กรุณาพิมพ์ชื่อเมืองซึ่งคุณอาศัยอยู่');
define ('CMTX_ERROR_MESSAGE_INVALID_TOWN', 'ชื่อเมืองต้องประกอบด้วยพยัญชนะและสระ หรืออักขระอื่นซึ่งเป็นตัวเลือก ได้แก่ - & . \'');
define ('CMTX_ERROR_MESSAGE_RESERVED_TOWN', 'ชื่อเมืองตามที่ระบุตรงกับชื่อเมืองซึ่งถูกสงวนไว้ กรุณาพิมพ์ชื่อเมืองอื่น');
define ('CMTX_ERROR_MESSAGE_BANNED_TOWN', 'ชื่อเมืองตามที่ระบุตรงกับชื่อเมืองต้องห้าม กรุณาพิมพ์ชื่อเมืองอื่น');
define ('CMTX_ERROR_MESSAGE_DUMMY_TOWN', 'ชื่อเมืองตามที่ระบุไม่ใช่ชื่อเมืองซึ่งคุณอาศัยอยู่ กรุณาพิมพ์ชื่อเมืองซึ่งคุณอาศัยอยู่');
define ('CMTX_ERROR_MESSAGE_LINK_IN_TOWN', 'ชื่อเมืองตามที่ระบุเป็นชื่อเชื่อมโยง กรุณาพิมพ์ชื่อเมืองซึ่งคุณอาศัยอยู่');
define ('CMTX_ERROR_MESSAGE_NO_COUNTRY', 'ชื่อประเทศไม่ได้ถูกเลือก กรุณาเลือกชื่อประเทศซึ่งคุณอาศัยอยู่');
define ('CMTX_ERROR_MESSAGE_INVALID_COUNTRY', 'ประเทศที่เลือกไม่ถูกต้อง โปรดลองอีกครั้ง');
define ('CMTX_ERROR_MESSAGE_NO_RATING', 'ระดับคะแนนไม่ได้ถูกเลือก กรุณาเลือกระดับคะแนน ซึ่งคุณต้องการใช้ในการให้คะแนนแก่เนื้อหาเรื่องที่คุณได้อ่าน');
define ('CMTX_ERROR_MESSAGE_INVALID_RATING', 'การประเมินโดยเลือกไม่ถูกต้อง โปรดลองอีกครั้ง');
define ('CMTX_ERROR_MESSAGE_INVALID_REPLY', 'ข้อความคิดเห็นซึ่งคุณเลือกที่จะแสดงความคิดเห็นเพื่อสนับสนุนหรือหักล้างไม่ถูกต้อง กรุณาลองอีกครั้ง');
define ('CMTX_ERROR_MESSAGE_NO_COMMENT', 'ช่องระบุข้อความคิดเห็นไม่สามารถเว้นว่าง กรุณาพิมพ์ข้อความคิดเห็นของคุณ');
define ('CMTX_ERROR_MESSAGE_COMMENT_MIN', 'ข้อความคิดเห็นสั้นเกินไป กรุณาให้รายละเอียดเพิ่มเติม');
define ('CMTX_ERROR_MESSAGE_COMMENT_MAX', 'ข้อความคิดเห็นยาวเกินไป กรุณาแก้ไขเพื่อทำให้สั้นกระชับมากขึ้น');
define ('CMTX_ERROR_MESSAGE_COMMENT_MAX_LINES', 'ข้อความคิดเห็นประกอบด้วยข้อความหลายบรรทัดและเกินจากที่กำหนด กรุณาตรวจทานและแก้ไข');
define ('CMTX_ERROR_MESSAGE_COMMENT_RESUBMIT', 'ข้อความคิดเห็นตามที่ระบุตรงกับข้อมูลที่มีอยู่เดิม กรุณาให้รายละเอียดที่แตกต่าง');
define ('CMTX_ERROR_MESSAGE_SMILIES_MAX', 'ข้อความคิดเห็นประกอบด้วยภาพสัญลักษณ์แสดงอารมณ์เกินจากที่กำหนด กรุณาลบในส่วนที่ไม่จำเป็นออก');
define ('CMTX_ERROR_MESSAGE_MILD_SWEARING', 'ข้อความคิดเห็นประกอบด้วย คำก้าวร้าว กรุณาลบออก');
define ('CMTX_ERROR_MESSAGE_STRONG_SWEARING', 'ไม่อนุญาตให้ใช้คำหยาบ กรุณาลบคำหยาบนั้นออก');
define ('CMTX_ERROR_MESSAGE_SPAMMING', 'ไม่อนุญาตให้ใช้คำซึ่งเป็นสแปม กรุณาลบออกจากข้อความคิดเห็นของคุณ');
define ('CMTX_ERROR_MESSAGE_LONG_WORD', 'ข้อความคิดเห็นประกอบด้วย คำที่มีความยาวเกินจากปกติ กรุณาเลือกใช้คำที่สั้นลงแทน');
define ('CMTX_ERROR_MESSAGE_CAPITALS', 'ข้อความคิดเห็นประกอบด้วยจำนวนตัวพิมพ์ใหญ่เกินจากที่กำหนด กรุณาลดจำนวนลง');
define ('CMTX_ERROR_MESSAGE_LINK_IN_COMMENT', 'ข้อความคิดเห็นประกอบด้วยข้อความเชื่อมโยง กรุณาลบออก');
define ('CMTX_ERROR_MESSAGE_REPEATS', 'ข้อความคิดเห็นประกอบด้วย คำซึ่งมีอักขระเหมือนกันทั้งหมด กรุณาลบออก');
define ('CMTX_ERROR_MESSAGE_NO_ANSWER', 'ช่องตอบคำถามไม่สามารถเว้นว่าง กรุณาพิมพ์คำตอบที่ถูกต้องตรงกับคำถาม');
define ('CMTX_ERROR_MESSAGE_WRONG_ANSWER', 'คำตอบไม่ถูกต้อง กรุณาใช้ความพยายามอีกครั้ง');
define ('CMTX_ERROR_MESSAGE_NO_CAPTCHA', 'ช่องระบุโค้ดไม่สามารถเว้นว่าง กรุณาพิมพ์โค้ดตามที่เห็นจากภาพ');
define ('CMTX_ERROR_MESSAGE_WRONG_CAPTCHA', 'อักขระในโค้ดตามที่ระบุไม่ถูกต้อง กรุณาพิมพ์อีกครั้ง');
define ('CMTX_ERROR_MESSAGE_FLOOD_CONTROL_DELAY', 'ข้อความคิดเห็นล่าสุดของคุณเพิ่งถูกเพิ่มได้ไม่นาน กรุณารอสักครู่');
define ('CMTX_ERROR_MESSAGE_FLOOD_CONTROL_MAXIMUM', 'คุณเพิ่มข้อความคิดเห็นต่อเนื่องและกระชั้นชิดเกินไป กรุณารอสักครู่');
define ('CMTX_ERROR_MESSAGE_SUBSCRIBER_EXISTS', 'คุณไม่จำเป็นต้องแสดงความประสงค์เพื่อรับอีเมลแจ้งเตือนเกี่ยวกับเนื้อหาเรื่องนี้ เนื่องจากคุณเคยแจ้งความประสงค์ไว้เรียบร้อยแล้ว');
define ('CMTX_ERROR_MESSAGE_SUBSCRIBER_BAD', 'คุณไม่จำเป็นต้องแสดงความประสงค์เพื่อรับอีเมลแจ้งเตือน ในขณะที่คุณรออีเมล');
define ('CMTX_ERROR_MESSAGE_NO_REFERRER', 'กรุณาเปิดใช้งาน เพื่อจะสามารถส่งข้อมูลอ้างอิง จากภายในในเว็บบเราเซอร์ของคุณ');

/* Messages displayed to user when banned */
define ('CMTX_BAN_MESSAGE_BANNED_NOW', 'คุณเพิ่งถูกแบน<p/>กรณีนี้อาจเกิดขึ้นได้จากหลายสาเหตุ ได้แก่ การใช้คำหยาบ การใช้คำซึ่งตรงกับสแปม การมีพฤติกรรมอันส่อไปในทางแฮกเคอร์<p/>หากคุณคิดว่าสิ่งที่เกิดขึ้นกับคุณนี้ ต้องมีอะไรสักอย่างผิดพลาด กรุณาติดต่อกับผู้ควบคุมดูแลพร้อมด้วยข้อมูลซึ่งเป็น IP Address ของคุณ');
define ('CMTX_BAN_MESSAGE_BANNED_PREVIOUSLY', 'ขออภัย คุณถูกแบนไปแล้วก่อนหน้านี้');

/* Ban reasons */
define ('CMTX_BAN_REASON_INCORRECT_SECURITY_KEY', 'รหัสนิรภัยไม่ถูกต้อง');
define ('CMTX_BAN_REASON_NO_SECURITY_KEY', 'ไม่พบรหัสนิรภัย');
define ('CMTX_BAN_REASON_INJECTION', 'พบความพยายามในการแทรกเพิ่มข้อมูล');
define ('CMTX_BAN_REASON_INCORRECT_REFERRER', 'ข้อมูลอ้างอิงไม่ถูกต้อง');
define ('CMTX_BAN_REASON_MISMATCHING_DATA', 'ข้อมูลไม่ตรงกัน');
define ('CMTX_BAN_REASON_MAXIMUMS', 'ปริมาณข้อมูลเกินจากปริมาณสูงสุดที่ได้กำหนดไว้');
define ('CMTX_BAN_REASON_RESERVED_NAME', 'ชื่อตามที่ระบุเป็นชื่อซึ่งถูกสงวนไว้');
define ('CMTX_BAN_REASON_BANNED_NAME', 'ชื่อตามที่ระบุเป็นชื่อซึ่งถูกแบน');
define ('CMTX_BAN_REASON_DUMMY_NAME', 'ชื่อตามที่ระบุไม่น่าเชื่อถือ');
define ('CMTX_BAN_REASON_LINK_IN_NAME', 'พบข้อความเชื่อมโยงในช่องระบุชื่อ');
define ('CMTX_BAN_REASON_RESERVED_EMAIL', 'ที่อยู่อีเมลตามที่ระบุเป็นที่อยู่อีเมลซึ่งถูกสงวนไว้');
define ('CMTX_BAN_REASON_BANNED_EMAIL', 'ที่อยู่อีเมลตามที่ระบุเป็นที่อยู่อีเมลซึ่งถูกแบน');
define ('CMTX_BAN_REASON_DUMMY_EMAIL', 'ที่อยู่อีเมลตามที่ระบุไม่น่าเชื่อถือ');
define ('CMTX_BAN_REASON_RESERVED_WEBSITE', 'ที่อยู่เว็บไซต์ตามที่ระบุเป็นที่อยู่เว็บไซต์ซึ่งถูกสงวนไว้');
define ('CMTX_BAN_REASON_BANNED_WEBSITE_IN_WEBSITE', 'ที่อยู่เว็บไซต์ตามที่ระบุในช่องที่อยู่เว็บไซต์ เป็นที่อยู่เว็บไซต์ซึ่งถูกแบน');
define ('CMTX_BAN_REASON_BANNED_WEBSITE_IN_COMMENT', 'ที่อยู่เว็บไซต์ในข้อความคิดเห็นเป็นที่อยู่เว็บไซต์ซึ่งถูกแบน');
define ('CMTX_BAN_REASON_DUMMY_WEBSITE', 'ท่อยู่เว็บไซต์ตามที่ระบุไม่น่าเชื่อถือ');
define ('CMTX_BAN_REASON_RESERVED_TOWN', 'ชื่อเมืองตามที่ระบุเป็นชื่อเมืองซึ่งถูกสงวนไว้');
define ('CMTX_BAN_REASON_BANNED_TOWN', 'ชื่อเมืองตามที่ระบุเป็นชื่อเมืองซึ่งถูกแบน');
define ('CMTX_BAN_REASON_DUMMY_TOWN', 'ชื่อเมืองตามที่ระบุไม่น่าเชื่อถือ');
define ('CMTX_BAN_REASON_LINK_IN_TOWN', 'ชื่อเมืองตามที่ระบุเป็นข้อความเชื่อมโยง');
define ('CMTX_BAN_REASON_MILD_SWEARING', 'พบคำหยาบ');
define ('CMTX_BAN_REASON_STRONG_SWEARING', 'พบคำหยาบรุนแรง');
define ('CMTX_BAN_REASON_SPAMMING', 'พบการสแปม');
define ('CMTX_BAN_REASON_CAPITALS', 'พบจำนวนตัวพิมพ์ใหญ่มีมากกว่าที่กำหนด');
define ('CMTX_BAN_REASON_LINK_IN_COMMENT', 'พบข้อความเชื่อมโยงในข้อความคิดเห็น');
define ('CMTX_BAN_REASON_REPEATS', 'การเพิ่มข้อความคิดเห็นเป็นการกระทำซ้ำ');

/* Approval reasons */
define ('CMTX_APPROVE_REASON_ALL', 'ตรวจสอบทั้งหมด');
define ('CMTX_APPROVE_REASON_RESERVED_NAME', 'ชื่อตามที่ระบุเป็นชื่อซึ่งถูกสงวนไว้');
define ('CMTX_APPROVE_REASON_BANNED_NAME', 'ชื่อตามที่ระบุเป็นชื่อซึ่งถูกแบน');
define ('CMTX_APPROVE_REASON_DUMMY_NAME', 'ชื่อตามที่ระบุไม่น่าเชื่อถือ');
define ('CMTX_APPROVE_REASON_LINK_IN_NAME', 'ชือ่ในช่องระบุชื่อ เป็นข้อความเชื่อมโยง');
define ('CMTX_APPROVE_REASON_RESERVED_EMAIL', 'ที่อยู่อีเมลตามที่ระบุตรงกับที่อยู่อีเมลซึ่งสงวนไว้');
define ('CMTX_APPROVE_REASON_BANNED_EMAIL', 'ที่อยู่อีเมลตามที่ระบุเป็นที่อยู่อีเมลซึ่งถูกแบน');
define ('CMTX_APPROVE_REASON_DUMMY_EMAIL', 'ที่อยู่อีเมลตามที่ระบุไม่น่าเชื่อถือ');
define ('CMTX_APPROVE_REASON_WEBSITE_ENTERED', 'ที่อยู่เว็บไซต์ตามที่ถูกระบุ');
define ('CMTX_APPROVE_REASON_RESERVED_WEBSITE', 'ที่อยู่เว็บไซต์ตรงกับที่อยู่เว็บไซต์ซึ่งสงวนไว้');
define ('CMTX_APPROVE_REASON_BANNED_WEBSITE_IN_WEBSITE', 'ที่อยู่เว็บไซต์ในช่องที่อยู่เว็บไซต์เป็นที่อยู่เว็บไซต์ซึ่งถูกแบน');
define ('CMTX_APPROVE_REASON_BANNED_WEBSITE_IN_COMMENT', 'ที่อยู่เว็บไซต์ในข้อความคิดเห็นเป็นที่อยู่เว็บไซต์ซึ่งถูกแบน');
define ('CMTX_APPROVE_REASON_DUMMY_WEBSITE', 'ที่อยู่เว็บไซต์ไม่น่าเชื่อถือ');
define ('CMTX_APPROVE_REASON_RESERVED_TOWN', 'ชื่อเมืองตรงกับชื่อเมืองซึ่งสงวนไว้');
define ('CMTX_APPROVE_REASON_BANNED_TOWN', 'ชื่อเมืองตรงกับชื่อเมืองที่ถูกแบน');
define ('CMTX_APPROVE_REASON_DUMMY_TOWN', 'ชื่อเมืองไม่น่าเชื่อถือ');
define ('CMTX_APPROVE_REASON_LINK_IN_TOWN', 'ชื่อเมืองเป็นข้อความเชื่อมโยง');
define ('CMTX_APPROVE_REASON_LINK_IN_COMMENT', 'ข้อความคิดเห็นมีข้อความเชื่อมโยง');
define ('CMTX_APPROVE_REASON_REPEATS', 'เพิ่มข้อความคิดเห็นซ้ำ');
define ('CMTX_APPROVE_REASON_IMAGE_ENTERED', 'ข้อมูลภาพ');
define ('CMTX_APPROVE_REASON_VIDEO_ENTERED', 'วิดีโอที่ป้อน');
define ('CMTX_APPROVE_REASON_MILD_SWEARING', 'คำหยาบ');
define ('CMTX_APPROVE_REASON_STRONG_SWEARING', 'คำหยาบรุนแรง');
define ('CMTX_APPROVE_REASON_SPAMMING', 'คำสแปม.');
define ('CMTX_APPROVE_REASON_CAPITALS', 'ตัวพิมพ์ใหญ่มากเกินไป');
define ('CMTX_APPROVE_REASON_AKISMET', 'Akismet.');
?>