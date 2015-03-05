<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="{$lang_code}" xml:lang="{$lang_code}" dir="{$dir}">
<head>
	{include file="layout/head.tpl"}
</head>
<body>
<div id="header">
    <div>
        <a href="{$base_url}" class="logo"></a>																																																	
        <div class="search">
                <form id="index" name="index" method="get" action="{$base_url}search">
                        <input id="q" name="q" type="text" class="search_field"  value="{$smarty.get.find|escape|default:$lang.cat.find_def}" onfocus='showDown("q","{$lang.cat.find_def}");' onblur='showUp("q","{$lang.cat.find_def}")'/>
                        <input type="submit" class="search_button" value="" />
                </form>
        </div>
    </div>
    <div style="color:#fff;padding-top: 8px;margin-top:0px">
        <p style="color:#fff;margin-top:0px">{$total_pages|number_format} сайта в {$total_categories} категории.</p>
    </div>
</div>
