<?php

/**
 * Contao Open Source CMS, Copyright (C) 2005-2022 Leo Feyer
 *
 * Module Backend User Online - DCA Helper Class DcaMemberOnlineIcon
 *
 * @copyright  Glen Langer 2012..2022 <http://contao.ninja>
 * @author     Glen Langer (BugBuster)
 * @license    LGPL
 * @filesource
 * @see	       https://github.com/BugBuster1701/contao-be_user_online-bundle 
 */

/**
 * Run in a custom namespace, so the class can be replaced
 */

namespace BugBuster\BackendUserOnline;

/**
 * Class DcaMemberOnlineIcon
 *
 * @copyright  Glen Langer 2012..2022 <http://contao.ninja>
 * @author     Glen Langer (BugBuster)
 */
class DcaMemberOnlineIcon extends \Backend
{
	/**
	 * Add an image to each record
	 * @param array
	 * @param string
	 * @param DataContainer
	 * @param array
	 * @return string
	 */
	public function addIcon($row, $label, \DataContainer $dc, $args)
	{
		$image = 'member';

		$time = \Date::floorToMinute();

		$disabled = $row['start'] !== '' && $row['start'] > $time || $row['stop'] !== '' && $row['stop'] < $time;

		if ($row['disable'] || $disabled)
		{
			$image .= '_';
		}

		$objUsers = \Database::getInstance()
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
