<?php
/**
 * JSLog Connector
 */
if(strpos(dirname(__FILE__), 'mycomponents') === FALSE) {
  require_once dirname(dirname(dirname(dirname(__FILE__)))).'/config.core.php';
} else {
  require_once dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))).'/config.core.php';
}

require_once MODX_CORE_PATH.'config/'.MODX_CONFIG_KEY.'.inc.php';
require_once MODX_CONNECTORS_PATH.'index.php';

$corePath = $modx->getOption('jslog.core_path', null, $modx->getOption('core_path').'components/jslog/');
require_once $corePath.'model/jslog/jslog.class.php';
$modx->jslog = new JSLog($modx);
$modx->lexicon->load('jslog:default');

/* Handle request */
$path = $modx->getOption('processorsPath', $modx->jslog->config, $corePath.'processors/');
$modx->request->handleRequest(array(
    'processors_path' => $path,
    'location' => '',
));
