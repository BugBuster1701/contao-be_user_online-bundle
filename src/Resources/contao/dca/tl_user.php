<?php

/**
 * Contao Open Source CMS, Copyright (C) 2005-2018 Leo Feyer
 *
 * Module Backend User Online - DCA 
 *
 * @copyright  Glen Langer 2012..2018 <http://contao.ninja>
 * @author     Glen Langer (BugBuster)
 * @license    LGPL
 * @filesource
 * @see	       https://github.com/BugBuster1701/contao-be_user_online-bundle  
 */

/**
 * DCA Config, overwrite label_callback
 */
$GLOBALS['TL_DCA']['tl_user']['list']['label']['label_callback'] = array('BugBuster\BackendUserOnline\DcaUserOnlineIcon', 'addIcon');

