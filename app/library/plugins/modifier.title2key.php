<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty title modifier plugin
 *
 * Type:     modifier<br>
 * Name:     title2key<br>
 * Purpose:  makes titles to urls
 * @param string
 * @return string
 */
function smarty_modifier_title2key( $string )
{
	return mb_strtolower(preg_replace('@[^a-zA-Z0-9ЯВЕРТЪУИОПШЩЮЛКЙХГФДСАЗЬЦЖБНМчявертъуиопшщюлкйхгфдсазьцжбнм]+@', '-', preg_replace('@\s+@', ' ', $string)), 'utf8');
}
