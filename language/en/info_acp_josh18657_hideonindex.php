<?php
/**
 *
 * Hide on Index. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2025, Joshua Sayles, https://www.josh18657.com
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */
 
 if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'HIDE_FORUM_ON_INDEX'	=> 'Hide forum on index.php',
));