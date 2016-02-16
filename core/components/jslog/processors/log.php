<?php
/**
 * Log JS error
 */
$modx->jslog->createFile();

$modx->jslog->errorLog();

$errorExists = $modx->jslog->errorExists();
if(!$errorExists)
  $modx->jslog->sendMail();

// Return something useful
// @todo Use for ExtJS message that an error happened and was reported
// @todo Report error via e-mail (?)
return json_encode(array('success' => true, 'msg' => 'Log was created!'));
