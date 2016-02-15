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
  'key' => 'jslog_system_setting_status',
  'name' => 'jslog Status',
  'description' => 'Enable/Disable JSLog',
  'namespace' => 'jslog',
  'xtype' => 'combo-boolean',
  'value' => true,
  'area' => 'jslog',
), '', true, true);
return $systemSettings;
