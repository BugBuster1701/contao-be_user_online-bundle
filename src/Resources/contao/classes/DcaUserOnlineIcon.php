<?php

/*
 * This file is part of a BugBuster Contao Bundle (Resource/contao)
 *
 * @copyright  Glen Langer 2024 <http://contao.ninja>
 * @author     Glen Langer (BugBuster)
 * @package    BackendUserOnline
 * @license    LGPL-3.0-or-later
 * @see        https://github.com/BugBuster1701/contao-be_user_online-bundle
 */

namespace BugBuster\BackendUserOnline;

use Contao\Date;

/**
 * Class DcaUserOnlineIcon 
 *
 * @copyright  Glen Langer 2012..2022 <http://contao.ninja>
 * @author     Glen Langer (BugBuster)
 */
class DcaUserOnlineIcon extends \Contao\Backend
{
	/**
	 * Add an image to each record
	 * @param array
	 * @param string
	 * @param DataContainer
	 * @param array
	 * @return string
	 */
	public function addIcon($row, $label, \Contao\DataContainer $dc, $args)
	{
		$image = $row['admin'] ? 'admin' : 'user';

		$time = Date::floorToMinute();

		$container = \Contao\System::getContainer();
		$assetURL = $container->get('contao.assets.assets_context')->getStaticUrl();

		$disabled = $row['start'] !== '' && $row['start'] > $time || $row['stop'] !== '' && $row['stop'] < $time;

		if ($row['disable'] || $disabled)
		{
			$image .= '_';
		}

		$objUsers = \Contao\Database::getInstance()
                            ->prepare("SELECT tlu.id 
                                        FROM 
                                            tl_user tlu, tl_online_session tls 
                                        WHERE 
                                            tlu.id = tls.pid 
                                        AND tlu.id = ? 
                                        AND tls.tstamp > ? 
                                        AND tls.instanceof = ?")
                            ->execute($row['id'], time()-600, 'BE_USER_AUTH');
		if ($objUsers->numRows < 1) 
		{
		    //offline
		    $status = \sprintf('<img src="%ssystem/themes/%s/icons/invisible.svg" width="16" height="16" alt="Offline" style="padding-left: 18px;">', $assetURL, \Contao\Backend::getTheme());
		} 
		else 
		{
		    //online
		    $status = \sprintf('<img src="%ssystem/themes/%s/icons/visible.svg" width="16" height="16" alt="Online" style="padding-left: 18px;">', $assetURL, \Contao\Backend::getTheme());
		}

		$args[0] = \sprintf('<div class="list_icon_new" style="background-image:url(\'%ssystem/themes/%s/icons/%s.svg\'); width: 34px;" data-icon="%s.svg" data-icon-disabled="%s.svg">%s</div>', $assetURL, \Contao\Backend::getTheme(), $image, $disabled ? $image : rtrim($image, '_'), rtrim($image, '_') . '_', $status);

		return $args;
	}

}
