<?php 

/**
 * Contao Open Source CMS, Copyright (C) 2005-2013 Leo Feyer
 *
 * Module Backend User Online - DCA Helper Class DCA_user_onlineicon
 *
 * @copyright  Glen Langer 2012..2013 <http://www.contao.glen-langer.de>
 * @author     Glen Langer (BugBuster)
 * @package    BackendUserOnline 
 * @license    LGPL
 * @filesource
 * @see	       https://github.com/BugBuster1701/backend_user_online  
 */

/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace BugBuster\BackendUserOnline;

/**
 * Class DCA_user_onlineicon 
 *
 * @copyright  Glen Langer 2012..2013 <http://www.contao.glen-langer.de>
 * @author     Glen Langer (BugBuster)
 * @package    BackendUserOnline
 */
class DcaUserOnlineIcon extends \Backend
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
		$image = $row['admin'] ? 'admin' :  'user';

		$time = \Date::floorToMinute();

		$disabled = $row['start'] !== '' && $row['start'] > $time || $row['stop'] !== '' && $row['stop'] < $time;

		if ($row['disable'] || $disabled)
		{
			$image .= '_';
		}
		
		$objUsers = \Database::getInstance()
                            ->prepare("SELECT tlu.id 
                                        FROM 
                                            tl_user tlu, tl_session tls 
                                        WHERE 
                                            tlu.id = tls.pid 
                                        AND tlu.id = ? 
                                        AND tls.tstamp > ? 
                                        AND tls.name = ?")
                            ->execute($row['id'], time()-600, 'BE_USER_AUTH');
		if ($objUsers->numRows < 1) 
		{
		    //offline
		    $status = sprintf('<img src="%ssystem/themes/%s/icons/invisible.svg" width="16" height="16" alt="Offline" style="padding-left: 18px;">', TL_ASSETS_URL, \Backend::getTheme() );
		} 
		else 
		{
		    //online
		    $status = sprintf('<img src="%ssystem/themes/%s/icons/visible.svg" width="16" height="16" alt="Online" style="padding-left: 18px;">', TL_ASSETS_URL, \Backend::getTheme() );
		}

		//c3 $args[0] = sprintf('<div class="list_icon_new" style="background-image:url(\'%ssystem/themes/%s/icons/%s.svg\'); width: 34px;">%s</div>', TL_ASSETS_URL, \Backend::getTheme(), $image, $status);
		$args[0] = sprintf('<div class="list_icon_new" style="background-image:url(\'%ssystem/themes/%s/icons/%s.svg\'); width: 34px;" data-icon="%s.svg" data-icon-disabled="%s.svg">%s</div>', TL_ASSETS_URL, \Backend::getTheme(), $image, $disabled ? $image : rtrim($image, '_'), rtrim($image, '_') . '_', $status);
		return $args;
	}

}
