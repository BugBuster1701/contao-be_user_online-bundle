<?php

/*
 * This file is part of a BugBuster Contao Bundle (Resource/contao)
 *
 * @copyright  Glen Langer 2023 <http://contao.ninja>
 * @author     Glen Langer (BugBuster)
 * @package    BackendUserOnline
 * @license    LGPL-3.0-or-later
 * @see        https://github.com/BugBuster1701/contao-be_user_online-bundle
 */

/**
 * DCA Config, overwrite label_callback
 */
$GLOBALS['TL_DCA']['tl_member']['list']['label']['label_callback'] = array('BugBuster\BackendUserOnline\DcaMemberOnlineIcon', 'addIcon');

