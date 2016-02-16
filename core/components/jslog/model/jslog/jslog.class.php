<?php
/**
 * JSLog class file for JSLog extra
 *
 * Copyright 2016 by Andreas Bilz <anti@herooutoftime.com>
 * Created on 02-15-2016
 *
 * JSLog is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * JSLog is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * JSLog; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package jslog
 */


class JSLog {
    /** @var $modx modX */
    public $modx;
    /** @var $props array */
    public $props;
    /** @var $error array */
    public $error;

    function __construct(&$modx, &$config = array()) {
        $this->modx =& $modx;
        $this->props =& $config;

        $this->modx =& $modx;

        $basePath = $this->modx->getOption('jslog.core_path', $config, $this->modx->getOption('core_path').'components/jslog/');
        $assetsPath = $this->modx->getOption('jslog.assets_path', $config, $this->modx->getOption('assets_path').'components/jslog/');
        $assetsUrl = $this->modx->getOption('jslog.assets_url', $config, $this->modx->getOption('assets_url').'components/jslog/');

        $this->config = array_merge(array(
            'basePath'       => $basePath,
            'assetsPath'     => $assetsPath,
            'corePath'       => $basePath,
            'modelPath'      => $basePath.'model/',
            'processorsPath' => $basePath.'processors/',
            'controllersPath' => $basePath.'controllers/',
            'chunksPath'     => $basePath.'elements/chunks/',
            'jsUrl'          => $assetsUrl.'js/',
            'baseUrl'        => $assetsUrl,
            'cssUrl'         => $assetsUrl.'css/',
            'assetsUrl'      => $assetsUrl,
            'connectorUrl'   => $assetsUrl.'connector.php',
            'errorPath'      => $this->modx->getOption('core_path') . 'cache/jslog/',
            'enabled'        => (bool) $this->modx->getOption('jslog.enabled'),
            ),$config);
    }

    /**
     * Set current error
     * @param array $data Error data
     */
    public function setError($data)
    {
      $data = json_decode($data, true);
      $data['time'] = $this->setTimeData();
      $data['user'] = $this->setUserData();

      $data['key'] = $this->generateKey($data);
      $this->error = $data;

    }

    /**
     * Generate file key
     * @param  mixed $data JSON-string or array
     * @return string       MD5 string
     */
    public function generateKey($data)
    {
      // String (JSONified) need to be converted to Array
      if(is_string($data))
        $data = json_decode($data, true);

      // Take time sensitive data out of key generation
      unset($data['time']);

      // Serialize & MD5
      return md5(serialize($data));
    }

    /**
     * Set user data
     * Only returns id & username
     */
    public function setUserData()
    {
      $user = $this->modx->getUser();
      return array(
        'id' => $user->get('id'),
        'username' => $user->get('username'),
      );
      // $userArr = $user->toArray();
      // $bad_keys = array('password', 'hash_class', 'salt');
      // return array_diff_key($userArr, array_flip($bad_keys));
    }

    /**
     * Set time data
     * Timestamp & nice formatted date
     */
    public function setTimeData()
    {
      return array(
        'timestamp' => time(),
        'nice' => date('Y-m-d H:i:s')
      );
    }

    /**
     * Create the error file
     * @return [type] [description]
     */
    public function createFile()
    {
      if(!is_dir($this->config['errorPath']))
        mkdir($this->config['errorPath'], 0775, true);

      if(!file_exists($this->config['errorPath'] . $this->error['key'])) {
        touch($this->config['errorPath'] . $this->error['key']);
        file_put_contents($this->config['errorPath'] . $this->error['key'], json_encode($this->error, JSON_PRETTY_PRINT));
      }
    }

    /**
     * Check if an error exists and if we should be remembered of its existence
     * @return boolean Either TRUE or FALSE
     */
    public function errorExists()
    {
      $remember = $this->errorRemember();
      if(!$remember && file_exists($this->config['errorPath'] . $this->error['key']))
        return true;
      return false;
    }

    /**
     * Check if this error is overdue of fixing
     *
     * Set interval via system settings
     *
     * @return boolean TRUE or FALSE
     */
    public function errorRemember()
    {
      $interval = $this->modx->getOption('jslog.error_interval', '', 0);
      $file = new SplFileInfo($this->config['errorPath'] . $this->error['key']);
      $interval = 0;
      if($file->getCTime() < time() - $interval) {
        touch($this->config['errorPath'] . $this->error['key']);
        return true;
        // unlink($this->config['errorPath'] . $this->error['key']);
      }
      return false;
    }

    /**
     * Write to custom error log
     *
     * @return [type] [description]
     */
    public function errorLog()
    {
      $this->modx->log(xPDO::LOG_LEVEL_ERROR, json_encode($this->error),
        array('target'=>'FILE', 'options'=> array('filename'=>'javascript.log')),
        '',
        'JS'
      );
    }

    /**
     * Send mail
     *
     * Mail will only be sent if error occurs:
     * * 1st time
     * * Reoccurs after set interval is met
     *
     * @return [type] [description]
     */
    public function sendMail()
    {

      if(!$this->modx->getOption('jslog.send_mail'))
        return;

      $error = file_get_contents($this->config['errorPath'] . $this->error['key']);
      $setting_emails = explode(PHP_EOL, $this->modx->getOption('jslog.email'));

      $this->modx->getService('mail', 'mail.modPHPMailer');
      $this->modx->mail->set(modMail::MAIL_BODY,$error);
      $this->modx->mail->set(modMail::MAIL_FROM,'web@nachhaltigkeit.at');
      $this->modx->mail->set(modMail::MAIL_FROM_NAME,'Web @ Nachhaltigkeit');
      $this->modx->mail->set(modMail::MAIL_SUBJECT,'JSLog: We caught an error!');

      $this->modx->mail->address('to', $setting_emails[0]);
      // foreach($setting_emails as $email) {
      //   $this->modx->mail->address('to', $email);
      // }

      if (!$this->modx->mail->send()) {
          $this->modx->log(modX::LOG_LEVEL_ERROR,'An error occurred while trying to send the email: '.$this->modx->mail->mailer->ErrorInfo);
      }
      $this->modx->mail->reset();
    }

}
