<?php
/**
 * Log JS error
 */
// All request data is in $scriptProperties
// Remove the action parameter value
// $data = json_decode($scriptProperties['data'], true);
// $data['md5'] = $modx->jslog->generateKey(serialize($data));

$modx->jslog->createFile();

// Log to custom log file
// Path: {core_path}/cache/log/javascript.log
$modx->jslog->errorLog();

$errorExists = $modx->jslog->errorExists();
if(!$errorExists)
  $modx->jslog->sendMail();

// Return something useful
// @todo Use for ExtJS message that an error happened and was reported
// @todo Report error via e-mail (?)
return json_encode(array('success' => true, 'msg' => 'Log was created!'));
