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
define ('CMTX_FORM_HEADING', 'Ajouter un Commentaire');

/* Form disabled messages */
define ('CMTX_ALL_FORMS_DISABLED', 'L\'ajout de commentaires a été désactivé.');
define ('CMTX_THIS_FORM_DISABLED', 'L\'ajout de commentaires a été désactivé pour cette page.');

/* JavaScript disabled message */
define ('CMTX_JAVASCRIPT_DISABLED', 'JavaScript doit être activé pour que certaines fonctionnalités puissent fonctionner.');

/* Reply */
define ('CMTX_REPLY_MESSAGE', 'Vous répondez à');
define ('CMTX_REPLY_CANCEL', '[annuler]');
define ('CMTX_REPLY_NOBODY', 'Vous êtes pas vous répondez.');

/* Required */
define ('CMTX_REQUIRED_SYMBOL', '*');
define ('CMTX_REQUIRED_SYMBOL_MESSAGE', CMTX_REQUIRED_SYMBOL . ' Informations obligatoires');

/* Field labels */
define ('CMTX_LABEL_NAME', 'Nom:');
define ('CMTX_LABEL_EMAIL', 'Email:');
define ('CMTX_LABEL_WEBSITE', 'Site web:');
define ('CMTX_LABEL_TOWN', 'Ville:');
define ('CMTX_LABEL_COUNTRY', 'Pays:');
define ('CMTX_LABEL_RATING', 'Vote:');
define ('CMTX_LABEL_COMMENT', 'Commentaire:');
define ('CMTX_LABEL_QUESTION', 'Question:');
define ('CMTX_LABEL_CAPTCHA', 'Captcha:');

/* Field titles */
define ('CMTX_TITLE_NAME', 'Entrez le nom');
define ('CMTX_TITLE_EMAIL', 'Entrez l\'adresse email');
define ('CMTX_TITLE_WEBSITE', 'Entrez l\'adresse site web');
define ('CMTX_TITLE_TOWN', 'Entrez dans la ville');
define ('CMTX_TITLE_COUNTRY', 'Choisissez un pays');
define ('CMTX_TITLE_RATING', 'Sélectionnez un vote');
define ('CMTX_TITLE_COMMENT', 'Entrez un commentaire');
define ('CMTX_TITLE_QUESTION', 'Entrez réponse à la question');
define ('CMTX_TITLE_CAPTCHA_IMAGE', 'Captcha image');
define ('CMTX_TITLE_CAPTCHA_AUDIO', 'Version sonore de captcha');
define ('CMTX_TITLE_CAPTCHA_REFRESH', 'Rafraîchir l\'image captcha');
define ('CMTX_TITLE_CAPTCHA', 'Saisissez les caractères du captcha');
define ('CMTX_TITLE_NOTIFY', 'Recevoir des notifications par email');
define ('CMTX_TITLE_PRIVACY', 'J\'accepte la politique de confidentialité');
define ('CMTX_TITLE_TERMS', 'J\'accepte les termes et conditions');
define ('CMTX_TITLE_SUBMIT', 'Ajouter commentaire');
define ('CMTX_TITLE_PREVIEW', 'Aperçu');

/* Note displayed after email field */
define ('CMTX_NOTE_EMAIL', '(ne sera pas publiée)');

/* Countries */
define ('CMTX_TOP_COUNTRY', 'Veuillez choisir');

/* Ratings */
define ('CMTX_TOP_RATING', 'Sélectionnez un vote');
define ('CMTX_RATING_ONE', 'Horrible');
define ('CMTX_RATING_TWO', 'Pauvre');
define ('CMTX_RATING_THREE', 'Moyen');
define ('CMTX_RATING_FOUR', 'Bien');
define ('CMTX_RATING_FIVE', 'Excellent');

/* Text displayed for JavaScript BB Code prompts */
define ('CMTX_PROMPT_ENTER_BULLET', 'Entrez une liste de choix. Cliquez sur Annuler ou laisser en blanc pour mettre fin à la liste.');
define ('CMTX_PROMPT_ENTER_ANOTHER_BULLET', 'Entrez une autre liste de choix. Cliquez sur Annuler ou laisser en blanc pour mettre fin à la liste.');
define ('CMTX_PROMPT_ENTER_NUMERIC', 'Entrez une liste de choix. Cliquez sur Annuler ou laisser en blanc pour mettre fin à la liste.');
define ('CMTX_PROMPT_ENTER_ANOTHER_NUMERIC', 'Entrez une autre liste de choix. Cliquez sur Annuler ou laisser en blanc pour mettre fin à la liste.');
define ('CMTX_PROMPT_ENTER_LINK', 'Veuillez entrer le lien du site web');
define ('CMTX_PROMPT_ENTER_LINK_TITLE', 'En option, vous pouvez également entrer un titre pour le lien');
define ('CMTX_PROMPT_ENTER_EMAIL', 'Veuillez entrer l\'adresse email');
define ('CMTX_PROMPT_ENTER_EMAIL_TITLE', 'En option, vous pouvez également entrer un titre pour l\'adresse e-mail');
define ('CMTX_PROMPT_ENTER_IMAGE', 'Veuillez entrer le lien de l\'image');
define ('CMTX_PROMPT_ENTER_VIDEO', 'S\'il vous plaît entrez le lien de la vidéo. Les sites pris en charge incluent:\nYouTube, Vimeo, MetaCafe et Dailymotion.');

/* Text displayed for invalid BB Code entries */
define ('CMTX_BB_INVALID_LINK', '<i>(Lien invalide)</i>');
define ('CMTX_BB_INVALID_EMAIL', '<i>(email invalide)</i>');
define ('CMTX_BB_INVALID_IMAGE', '<i>(image invalide)</i>');
define ('CMTX_BB_INVALID_VIDEO', '<i>(vidéo invalide)</i>');

/* Text displayed before question field */
define ('CMTX_TEXT_QUESTION', 'Entrez la réponse:');

/* Text displayed before captcha field */
define ('CMTX_TEXT_CAPTCHA', 'Entrez les caractères:');

/* Text displayed after notify checkbox */
define ('CMTX_TEXT_NOTIFY', 'Avertissez-moi des nouveaux commentaires par e-mail.');

/* Text displayed after privacy checkbox */
define ('CMTX_TEXT_PRIVACY', 'J\'ai lu et j\'ai compris la <a href="' . $settings->url_to_comments_folder . 'agreement/french/privacy_policy.html" title="Lire politique de confidentialité" target="_blank" rel="nofollow">politique de confidentialité</a>.');

/* Text displayed after terms checkbox */
define ('CMTX_TEXT_TERMS', 'J\'ai lu et j\'approuve les <a href="' . $settings->url_to_comments_folder . 'agreement/french/terms_and_conditions.html" title="Lire termes et conditions" target="_blank" rel="nofollow">termes et conditions</a>.');

/* Text for form submit button */
define ('CMTX_SUBMIT_BUTTON', 'Ajouter commentaire');

/* Text for form preview button */
define ('CMTX_PREVIEW_BUTTON', 'Aperçu');

/* Text for form buttons when processing */
define ('CMTX_PROCESSING_BUTTON', 'Veuillez patienter..');

/* Text for 'powered by' statement */
define ('CMTX_POWERED_BY', 'Powered by');
?>