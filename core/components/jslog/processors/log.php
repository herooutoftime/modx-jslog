<?php
/**
 * Log JS error
 */
// All request data is in $scriptProperties
// Remove the action parameter value
unset($scriptProperties['action']);

// Log to custom log file
// Path: {core_path}/cache/log/javascript.log
$modx->log(xPDO::LOG_LEVEL_ERROR, json_encode($scriptProperties),
  array('target'=>'FILE', 'options'=> array('filename'=>'javascript.log'))
);

// Return something useful
// @todo Use for ExtJS message that an error happened and was reported
// @todo Report error via e-mail (?)
return json_encode(array('success' => true, 'msg' => 'Log was created!'));
