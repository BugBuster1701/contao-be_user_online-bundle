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

namespace BugBuster\BackendUserOnline;

use Contao\Date;

/**
 * Class DcaMemberOnlineIcon
 *
 * @copyright  Glen Langer 2012..2023 <http://contao.ninja>
 * @author     Glen Langer (BugBuster)
 */
class DcaMemberOnlineIcon extends \Contao\Backend
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
		$image = 'member';

		$time = Date::floorToMinute();

		$disabled = $row['start'] !== '' && $row['start'] > $time || $row['stop'] !== '' && $row['stop'] < $time;

		if ($row['disable'] || $disabled)
		{
			$image .= '_';
		}

		$objUsers = \Contao\Database::getInstance()
		                    ->prepare("SELECT 
                                            tlm.id 
                                        FROM 
		                                    tl_member tlm, tl_online_session tls 
                                        WHERE 
		                                    tlm.id = tls.pid 
                                        AND tlm.id = ? 
                                        AND tls.tstamp > ? 
                                        AND tls.instanceof = ?")
                            ->execute($row['id'], time()-300, 'FE_USER_AUTH');
		if ($objUsers->numRows < 1) 
		{
			//offline
			$status = sprintf('<img src="%ssystem/themes/%s/icons/invisible.svg" width="16" height="16" alt="Offline" style="padding-left: 18px;">', TL_ASSETS_URL, \Backend::getTheme());
		} 
		else 
		{
			//online
			$status = sprintf('<img src="%ssystem/themes/%s/icons/visible.svg" width="16" height="16" alt="Online" style="padding-left: 18px;">', TL_ASSETS_URL, \Backend::getTheme());
		}

		$args[0] = sprintf('<div class="list_icon_new" style="background-image:url(\'%ssystem/themes/%s/icons/%s.svg\'); width: 34px;" data-icon="%s.svg" data-icon-disabled="%s.svg">%s</div>', TL_ASSETS_URL, \Backend::getTheme(), $image, $disabled ? $image : rtrim($image, '_'), rtrim($image, '_') . '_', $status);

		return $args;
	}

}
