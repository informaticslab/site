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

//Set the transport method
if ($settings->transport_method == "php") {
	$transport = Swift_MailTransport::newInstance();
} else if ($settings->transport_method == "smtp") {
	$transport = Swift_SmtpTransport::newInstance();
	$transport->setHost($settings->smtp_host);
	$transport->setPort($settings->smtp_port);
	if ($settings->smtp_encrypt == "ssl") {
		$transport->setEncryption('ssl');
	} else if ($settings->smtp_encryption == "tls") {
		$transport->setEncryption('tls');
	}
	if ($settings->smtp_auth) {
		$transport->setUsername($settings->smtp_username);
		$transport->setPassword($settings->smtp_password);
	}
} else if ($settings->transport_method == "sendmail") {
	$transport = Swift_SendmailTransport::newInstance($settings->sendmail_path . ' -bs');
}

//Create the Mailer using the created Transport
$mailer = Swift_Mailer::newInstance($transport);

//Create the message
$message = Swift_Message::newInstance();

?>