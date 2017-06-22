<?php 

/**
 * Contao Open Source CMS, Copyright (C) 2005-2017 Leo Feyer
 *
 * Module Backend User Online - DCA 
 *
 * @copyright  Glen Langer 2012..2017 <http://contao.ninja>
 * @author     Glen Langer (BugBuster)
 * @package    BackendUserOnline 
 * @license    LGPL
 * @filesource
 * @see	       https://github.com/BugBuster1701/contao-be_user_online-bundle  
 */

/**
 * DCA Config, overwrite label_callback
 */
$GLOBALS['TL_DCA']['tl_member']['list']['label']['label_callback'] = array('BugBuster\BackendUserOnline\DcaMemberOnlineIcon','addIcon');

