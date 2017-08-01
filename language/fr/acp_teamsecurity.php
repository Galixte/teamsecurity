<?php
/**
*
* Team Security Measures extension for the phpBB Forum Software package.
* French translation by Galixte (http://www.galixte.com)
*
* @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ « » “ ” …
//

$lang = array_merge($lang, array(
	'ACP_FOUNDER_MANAGE_ONLY'				=> 'Vous n’êtes pas autorisé à accéder à ces paramètres. Seul un fondateur peut accéder à ces paramètres.',
	'ACP_TEAM_SECURITY_SETTINGS'			=> 'Paramètres de sécurité de l’équipe',
	'ACP_TEAM_SECURITY_SETTINGS_EXPLAIN'	=> 'Depuis cette page vous pouvez gérer diverses options de sécurité vous permettant de surveiller et identifier d’éventuelles attaques ciblant les comptes utilisateur des membres de l’équipe.',
	'ACP_LOGIN_EMAIL'						=> 'Activer les notifications de connexion au PCA',
	'ACP_LOGIN_EMAIL_EXPLAIN'				=> 'Un e-mail est envoyé lorsqu’un administrateur se connecte au panneau d’administration.',
	'ACP_CONTACT_EMAIL'						=> 'Contact de sécurité',
	'ACP_CONTACT_EMAIL_EXPLAIN'				=> 'E-mail de destination des notifications de connexion au panneau d’administration. Si aucune adresse n’est saisie, l’e-mail de contact défini dans les « Paramètres des e-mails » sera utilisé.',
	'ACP_CONTACT_NAME'						=> 'Nom du contact de sécurité',
	'ACP_CONTACT_NAME_EXPLAIN'				=> 'Il s’agit du nom du contact de sécurité que les destinataires de l’e-mail de notification verront. Ce champ peut être laissé vide.',
	'ACP_GROUP_SECURITY_OPTIONS'			=> 'Options du groupe de sécurité',
	'ACP_LOGIN_ATTEMPTS'					=> 'Journal des tentatives de connexions échouées',
	'ACP_LOGIN_ATTEMPTS_EXPLAIN'			=> 'Affiche les tentatives de connexions échouées pour les groupes sélectionnés dans le « Journal d’utilisateur ».',
	'ACP_EMAIL_CHANGES'						=> 'Notifier tout changement d’adresse e-mail',
	'ACP_EMAIL_CHANGES_EXPLAIN'				=> 'Un e-mail de notification est envoyé lorsqu’une adresse e-mail est modifiée pour un membre des groupes sélectionnés.',
	'ACP_STRONG_PASS'						=> 'Exiger des mots de passe complexes',
	'ACP_STRONG_PASS_EXPLAIN'				=> 'Exige des mots de passe complexes pour les membres des groupes sélectionnés (casse mixte, chiffres et symboles).',
	'ACP_MIN_PASS_CHARS'					=> 'Longueur minimale du mot de passe',
	'ACP_MIN_PASS_CHARS_EXPLAIN'			=> 'Longueur minimale du mot de passe pour les membres des groupes sélectionnés.',
	'ACP_GROUPS_EXPLAIN'					=> 'Groupes d’utilisateurs auxquels les options de sécurité seront appliquées. Appuyer sur la touche <samp>CTRL</samp> (ou <samp>&#8984;CMD</samp> sur Mac) tout en cliquant pour sélectionner / désélectionner plus d’un groupe.',
	'CHARS'									=> 'Caractères',
));
