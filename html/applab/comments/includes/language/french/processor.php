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
define ('CMTX_ERROR_NUMBER_PART_1', 'Désolé mais ');
define ('CMTX_ERRORS_NUMBER_PART_1', 'Désolé mais ');
define ('CMTX_ERROR_NUMBER_PART_2', ' erreur a été constatée lors du traitement de votre commentaire.');
define ('CMTX_ERRORS_NUMBER_PART_2', ' erreurs ont été constatées lors du traitement de votre commentaire.');
define ('CMTX_ERROR_CORRECTION', 'Veuillez corriger cette erreur et soumettre à nouveau le formulaire:');
define ('CMTX_ERRORS_CORRECTION', 'Veuillez corriger ces erreurs et soumettre à nouveau le formulaire:');

/* Preview box */
define ('CMTX_PREVIEW_TEXT', 'Aperçu seulement');

/* Approval box */
define ('CMTX_APPROVAL_OPENING', 'Merci.');
define ('CMTX_APPROVAL_TEXT', 'Votre commentaire est en attente d\'approbation.');
define ('CMTX_APPROVAL_SUBSCRIBER', 'Un email de confirmation vous a été envoyé.');

/* Success box */
define ('CMTX_SUCCESS_OPENING', 'Merci.');
define ('CMTX_SUCCESS_TEXT', 'Votre commentaire a été ajouté.');
define ('CMTX_SUCCESS_SUBSCRIBER', 'Un email de confirmation vous a été envoyé.');

/* Error messages */
define ('CMTX_ERROR_MESSAGE_NO_NAME', 'Le champ Nom ne peut pas être vide. Veuillez entrer votre nom.');
define ('CMTX_ERROR_MESSAGE_ONE_NAME', 'Un seul nom peut être entré pour le champ Nom. Veuillez entrer un seul nom.');
define ('CMTX_ERROR_MESSAGE_INVALID_NAME', 'Le nom ne doit contenir que des lettres et éventuellement - & . 0-9 \'');
define ('CMTX_ERROR_MESSAGE_RESERVED_NAME', 'Le nom entré est déjà réservé. Veuillez choisir un autre nom.');
define ('CMTX_ERROR_MESSAGE_BANNED_NAME', 'Le nom saisi est interdit. Veuillez choisir un autre nom.');
define ('CMTX_ERROR_MESSAGE_DUMMY_NAME', 'Le nom entré n\'est pas le vôtre. Veuillez entrer votre vrai nom.');
define ('CMTX_ERROR_MESSAGE_LINK_IN_NAME', 'Le nom entré contient un lien. S\'il vous plaît entrer votre nom.');
define ('CMTX_ERROR_MESSAGE_NO_EMAIL', 'Le champ email ne peut pas être vide. Veuillez entrer votre adresse email.');
define ('CMTX_ERROR_MESSAGE_INVALID_EMAIL', 'L\'adresse email saisie est incorrecte. Veuillez vérifier votre entrée.');
define ('CMTX_ERROR_MESSAGE_RESERVED_EMAIL', 'L\'adresse email saisie est déjà réservée. Veuillez entrer une autre adresse email.');
define ('CMTX_ERROR_MESSAGE_BANNED_EMAIL', 'L\'adresse email saisie est interdite. Veuillez entrer une autre adresse email.');
define ('CMTX_ERROR_MESSAGE_DUMMY_EMAIL', 'L\'adresse email saisie est la vôtre. Veuillez entrer votre vraie adresse email.');
define ('CMTX_ERROR_MESSAGE_NO_WEBSITE', 'Le champ Site web ne peut pas être vide. Veuillez entrer votre site web.');
define ('CMTX_ERROR_MESSAGE_DEFAULT_WEBSITE', 'Le champ Site web ne peut pas contenir sa valeur par défaut. Veuillez entrer votre site web.');
define ('CMTX_ERROR_MESSAGE_INVALID_WEBSITE', 'L\'adresse du site web saisie semble être incorrecte. Veuillez vérifier votre entrée.');
define ('CMTX_ERROR_MESSAGE_RESERVED_WEBSITE', 'L\'adresse du site web saisie est déjà réservée. Veuillez entrer une autre adresse site web.');
define ('CMTX_ERROR_MESSAGE_BANNED_WEBSITE_IN_WEBSITE', 'L\'adresse du site web saisie est interdite. Veuillez la supprimer.');
define ('CMTX_ERROR_MESSAGE_BANNED_WEBSITE_IN_COMMENT', 'L\'adresse du site web dans votre commentaire est interdite. Veuillez la supprimer.');
define ('CMTX_ERROR_MESSAGE_DUMMY_WEBSITE', 'L\'adresse du site web saisie n\'est pas la vôtre. Veuillez entrer votre vraie adresse site web.');
define ('CMTX_ERROR_MESSAGE_NO_TOWN', 'Le champ Ville ne peut pas être vide. Veuillez entrer votre ville.');
define ('CMTX_ERROR_MESSAGE_INVALID_TOWN', 'La ville doit contenir des lettres et éventuellement - & . \'');
define ('CMTX_ERROR_MESSAGE_RESERVED_TOWN', 'La ville est entré est réservé. S\'il vous plaît entrer dans une autre ville.');
define ('CMTX_ERROR_MESSAGE_BANNED_TOWN', 'La ville est entrée est interdite. S\'il vous plaît entrer dans une autre ville.');
define ('CMTX_ERROR_MESSAGE_DUMMY_TOWN', 'La ville est entrée n\'est pas le vôtre. S\'il vous plaît entrer votre vraie ville.');
define ('CMTX_ERROR_MESSAGE_LINK_IN_TOWN', 'La ville est entré contient un lien. S\'il vous plaît entrer votre ville.');
define ('CMTX_ERROR_MESSAGE_NO_COUNTRY', 'Un pays n\'a pas été sélectionné. Veuillez sélectionner votre pays.');
define ('CMTX_ERROR_MESSAGE_INVALID_COUNTRY', 'Le pays choisi est invalide. S\'il vous plaît essayez de nouveau.');
define ('CMTX_ERROR_MESSAGE_NO_RATING', 'Un vote n\'a pas été sélectionné. Veuillez sélectionner un vote.');
define ('CMTX_ERROR_MESSAGE_INVALID_RATING', 'La note sélectionnée n\'est pas valide. S\'il vous plaît essayez de nouveau.');
define ('CMTX_ERROR_MESSAGE_INVALID_REPLY', 'Le commentaire que vous répondez à n\'est pas valide. S\'il vous plaît essayez de nouveau.');
define ('CMTX_ERROR_MESSAGE_NO_COMMENT', 'Le champ Commentaire ne peut pas être vide. Veuillez entrer votre commentaire.');
define ('CMTX_ERROR_MESSAGE_COMMENT_MIN', 'Le commentaire entré est trop court. Veuillez entrer un plus long commentaire.');
define ('CMTX_ERROR_MESSAGE_COMMENT_MAX', 'Le commentaire entré est trop long. Veuillez entrer un plus court commentaire.');
define ('CMTX_ERROR_MESSAGE_COMMENT_MAX_LINES', 'Le commentaire entré contient trop de lignes. Veuillez entrer moins de lignes.');
define ('CMTX_ERROR_MESSAGE_COMMENT_RESUBMIT', 'Le commentaire entré a déjà été soumis. S\'il vous plaît soumettre un commentaire.');
define ('CMTX_ERROR_MESSAGE_SMILIES_MAX', 'Le commentaire entré contient trop de smileys. Veuillez entrer moins de smileys.');
define ('CMTX_ERROR_MESSAGE_MILD_SWEARING', 'Le commentaire entré contient des mots offensants. S\'il vous plaît supprimer ces mots.');
define ('CMTX_ERROR_MESSAGE_STRONG_SWEARING', 'Les jurons ne sont pas autorisés. Veuillez supprimer les jurons de votre commentaire.');
define ('CMTX_ERROR_MESSAGE_SPAMMING', 'Le spamming est interdit. Veuillez supprimer le spam de votre commentaire.');
define ('CMTX_ERROR_MESSAGE_LONG_WORD', 'Le commentaire entré contient un mot long. Veuillez abréger ou supprimer ce mot.');
define ('CMTX_ERROR_MESSAGE_CAPITALS', 'Le commentaire entré contient trop de capitales. Veuillez entrer moins de capitales.');
define ('CMTX_ERROR_MESSAGE_LINK_IN_COMMENT', 'Le commentaire entré contient un lien. S\'il vous plaît supprimer le lien.');
define ('CMTX_ERROR_MESSAGE_REPEATS', 'Le commentaire entré contient des caractères répéter. S\'il vous plaît de les supprimer.');
define ('CMTX_ERROR_MESSAGE_NO_ANSWER', 'Le champ question ne peut pas être vide. Veuillez entrer une réponse à la question.');
define ('CMTX_ERROR_MESSAGE_WRONG_ANSWER', 'La réponse à la question était incorrecte. Veuillez essayer de nouveau.');
define ('CMTX_ERROR_MESSAGE_NO_CAPTCHA', 'Le champ captcha ne peut pas être vide. Veuillez entrer les caractères de l\'image.');
define ('CMTX_ERROR_MESSAGE_WRONG_CAPTCHA', 'Les caractères saisis à partir de l\'image du captcha étaient incorrects. Veuillez essayer de nouveau.');
define ('CMTX_ERROR_MESSAGE_FLOOD_CONTROL_DELAY', 'Votre dernier commentaire a été soumis très récemment. Veuillez attendre un peu.');
define ('CMTX_ERROR_MESSAGE_FLOOD_CONTROL_MAXIMUM', 'Vous avez soumis plusieurs commentaires dernièrement. Veuillez attendre un peu.');
define ('CMTX_ERROR_MESSAGE_SUBSCRIBER_EXISTS', 'Il y a un problème avec votre demande de notification. Vous êtes déjà abonné.');
define ('CMTX_ERROR_MESSAGE_SUBSCRIBER_BAD', 'Il y a un problème avec votre demande de notification. Vous avez un abonnement en cours.');
define ('CMTX_ERROR_MESSAGE_NO_REFERRER', 'Veuillez activer votre navigateur Web pour envoyer les informations de provenance.');

/* Messages displayed to user when banned */
define ('CMTX_BAN_MESSAGE_BANNED_NOW', 'Vous venez d\'être banni.<p/>Cela peut être dû à une variété de raisons, y compris les jurons, le spamming et les comportements liés aux hackers.<p/>Si vous pensez que c\'était une erreur, Veuillez contacter l\'administrateur en indiquant votre adresse IP.');
define ('CMTX_BAN_MESSAGE_BANNED_PREVIOUSLY', 'Désolé, vous avez été banni précédemment.');

/* Ban reasons */
define ('CMTX_BAN_REASON_INCORRECT_SECURITY_KEY', 'Clé de sécurité incorrecte.');
define ('CMTX_BAN_REASON_NO_SECURITY_KEY', 'Pas de clé de sécurité.');
define ('CMTX_BAN_REASON_INJECTION', 'tentative d\'injection.');
define ('CMTX_BAN_REASON_INCORRECT_REFERRER', 'Références incorrectes.');
define ('CMTX_BAN_REASON_MISMATCHING_DATA', 'Désadaptation de données.');
define ('CMTX_BAN_REASON_MAXIMUMS', 'Données maximales dépassées.');
define ('CMTX_BAN_REASON_RESERVED_NAME', 'Nom entré réservé.');
define ('CMTX_BAN_REASON_BANNED_NAME', 'Nom banni entré.');
define ('CMTX_BAN_REASON_DUMMY_NAME', 'Nom factice entré.');
define ('CMTX_BAN_REASON_LINK_IN_NAME', 'Link est entré dans le nom.');
define ('CMTX_BAN_REASON_RESERVED_EMAIL', 'Adresse email réservée entrée.');
define ('CMTX_BAN_REASON_BANNED_EMAIL', 'Adresse email bannie entrée.');
define ('CMTX_BAN_REASON_DUMMY_EMAIL', 'Adresse email factice entrée.');
define ('CMTX_BAN_REASON_RESERVED_WEBSITE', 'Adresse de site web réservée entrée.');
define ('CMTX_BAN_REASON_BANNED_WEBSITE_IN_WEBSITE', 'Site interdit inscrit au site.');
define ('CMTX_BAN_REASON_BANNED_WEBSITE_IN_COMMENT', 'Site interdit est entré dans le commentaire.');
define ('CMTX_BAN_REASON_DUMMY_WEBSITE', 'Adresse de site web factice entrée.');
define ('CMTX_BAN_REASON_RESERVED_TOWN', 'La ville est entré réservés.');
define ('CMTX_BAN_REASON_BANNED_TOWN', 'Ville Banned entrée.');
define ('CMTX_BAN_REASON_DUMMY_TOWN', 'Ville fictive est entré.');
define ('CMTX_BAN_REASON_LINK_IN_TOWN', 'Link est entré dans la ville.');
define ('CMTX_BAN_REASON_MILD_SWEARING', 'Jurons doux.');
define ('CMTX_BAN_REASON_STRONG_SWEARING', 'Jurons fort.');
define ('CMTX_BAN_REASON_SPAMMING', 'Spamming.');
define ('CMTX_BAN_REASON_CAPITALS', 'Trop de capitales.');
define ('CMTX_BAN_REASON_LINK_IN_COMMENT', 'Link est entré dans le commentaire.');
define ('CMTX_BAN_REASON_REPEATS', 'Répète entré dans le commentaire.');

/* Approval reasons */
define ('CMTX_APPROVE_REASON_ALL', 'Approuver tous.');
define ('CMTX_APPROVE_REASON_RESERVED_NAME', 'Nom réservé entré.');
define ('CMTX_APPROVE_REASON_BANNED_NAME', 'Nom banni entré.');
define ('CMTX_APPROVE_REASON_DUMMY_NAME', 'Nom factice entré.');
define ('CMTX_APPROVE_REASON_LINK_IN_NAME', 'Link est entré dans le nom.');
define ('CMTX_APPROVE_REASON_RESERVED_EMAIL', 'Adresse email réservée entrée.');
define ('CMTX_APPROVE_REASON_BANNED_EMAIL', 'Adresse email bannie entrée.');
define ('CMTX_APPROVE_REASON_DUMMY_EMAIL', 'Adresse email factice entrée.');
define ('CMTX_APPROVE_REASON_WEBSITE_ENTERED', 'Site web entré.');
define ('CMTX_APPROVE_REASON_RESERVED_WEBSITE', 'Adresse de site web réservé entré.');
define ('CMTX_APPROVE_REASON_BANNED_WEBSITE_IN_WEBSITE', 'Site interdit inscrit au site.');
define ('CMTX_APPROVE_REASON_BANNED_WEBSITE_IN_COMMENT', 'Site interdit est entré dans le commentaire.');
define ('CMTX_APPROVE_REASON_DUMMY_WEBSITE', 'Adresse de site web factice entrée.');
define ('CMTX_APPROVE_REASON_RESERVED_TOWN', 'La ville est entré réservés.');
define ('CMTX_APPROVE_REASON_BANNED_TOWN', 'Ville Banned entrée.');
define ('CMTX_APPROVE_REASON_DUMMY_TOWN', 'Ville fictive est entré.');
define ('CMTX_APPROVE_REASON_LINK_IN_TOWN', 'Link est entré dans la ville.');
define ('CMTX_APPROVE_REASON_LINK_IN_COMMENT', 'Link est entré dans le commentaire.');
define ('CMTX_APPROVE_REASON_REPEATS', 'Répète entré dans le commentaire.');
define ('CMTX_APPROVE_REASON_IMAGE_ENTERED', 'Image entrée.');
define ('CMTX_APPROVE_REASON_VIDEO_ENTERED', 'Vidéo entrée.');
define ('CMTX_APPROVE_REASON_MILD_SWEARING', 'Jurons doux.');
define ('CMTX_APPROVE_REASON_STRONG_SWEARING', 'Jurons fort.');
define ('CMTX_APPROVE_REASON_SPAMMING', 'Spamming.');
define ('CMTX_APPROVE_REASON_CAPITALS', 'Trop de capitales.');
define ('CMTX_APPROVE_REASON_AKISMET', 'Akismet.');
?>