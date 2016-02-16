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
            ),$config);
    }
}
