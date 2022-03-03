<?php

/**
 * Contao Open Source CMS, Copyright (C) 2005-2022 Leo Feyer
 *
 * Module Backend User Online - DCA 
 *
 * @copyright  Glen Langer 2012..2022 <http://contao.ninja>
 * @author     Glen Langer (BugBuster)
 * @license    LGPL
 * @filesource
 * @see	       https://github.com/BugBuster1701/contao-be_user_online-bundle  
 */

/**
 * Table tl_beuseronline_session
 */
$GLOBALS['TL_DCA']['tl_beuseronline_session'] = array
(

	// Config
	'config' => array
	(
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary',
				'pid' => 'index',
				'hash' => 'index'
			)
		)
	),

	// Fields
	'fields' => array
	(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'pid' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'name' => array
		(
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'hash' => array
		(
			'sql'                     => "varchar(40) NULL"
		)
	)
);
