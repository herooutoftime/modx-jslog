<?php
/**
 * systemSettings transport file for JSLog extra
 *
 * Copyright 2016 by Andreas Bilz <anti@herooutoftime.com>
 * Created on 02-15-2016
 *
 * @package jslog
 * @subpackage build
 */

if (! function_exists('stripPhpTags')) {
    function stripPhpTags($filename) {
        $o = file_get_contents($filename);
        $o = str_replace('<' . '?' . 'php', '', $o);
        $o = str_replace('?>', '', $o);
        $o = trim($o);
        return $o;
    }
}
/* @var $modx modX */
/* @var $sources array */
/* @var xPDOObject[] $systemSettings */


$systemSettings = array();

$systemSettings[1] = $modx->newObject('modSystemSetting');
$systemSettings[1]->fromArray(array (
  'key' => 'jslog.enabled',
  'value' => '1',
  'xtype' => 'combo-boolean',
  'namespace' => 'jslog',
  'area' => 'jslog',
  'name' => 'JSLog Enabled',
  'description' => 'setting_jslog.enabled_desc',
), '', true, true);
$systemSettings[2] = $modx->newObject('modSystemSetting');
$systemSettings[2]->fromArray(array (
  'key' => 'jslog.error_interval',
  'value' => '86400',
  'xtype' => 'textfield',
  'namespace' => 'jslog',
  'area' => 'jslog',
  'name' => 'JSLog Error Interval',
  'description' => 'After what period do you want to be remembered if an error still exists and occurs?',
), '', true, true);
$systemSettings[3] = $modx->newObject('modSystemSetting');
$systemSettings[3]->fromArray(array (
  'key' => 'jslog.email',
  'value' => 'andreas.bilz@gmail.com
andreas@subsolutions.at
anti@herooutoftime.com',
  'xtype' => 'textarea',
  'namespace' => 'jslog',
  'area' => 'jslog',
  'name' => 'JSLog E-Mail Adresses',
  'description' => 'E-Mail addresses to send to. Multiple separated by comma, semicolon or line break.',
), '', true, true);
$systemSettings[4] = $modx->newObject('modSystemSetting');
$systemSettings[4]->fromArray(array (
  'key' => 'jslog.send_mail',
  'value' => '1',
  'xtype' => 'combo-boolean',
  'namespace' => 'jslog',
  'area' => 'jslog',
  'name' => 'JSLog Send Mail',
  'description' => 'setting_jslog.send_mail_desc',
), '', true, true);
return $systemSettings;
