<?php 
   
/**
 * Contao Open Source CMS, Copyright (C) 2005-2017 Leo Feyer
 *
 * Module Backend User Online - runonce
 *
 * @copyright  Glen Langer 2012..2017 <http://www.contao.glen-langer.de>
 * @author     Glen Langer (BugBuster)
 * @package    BackendUserOnline 
 * @license    LGPL
 * @filesource
 * @see	       https://github.com/BugBuster1701/backend_user_online  
 */

/**
 * Class BackendUserOnlineRunonceJob
 * 
 * Because of the unnecessary change in Contao core
 * https://github.com/contao/core/issues/5949
 * 
 * @copyright  Glen Langer 2012..2017
 * @author     Glen Langer
 * @package    Banner
 * @license    LGPL
 */
class BackendUserOnlineRunonceJob extends Controller
{
	public function __construct()
	{
	    parent::__construct();
	}
	
	public function run()
	{
	    // Backend User Online Issues #6
	    //c3 $a = $this->Session->get('sorting');
	    //c4 $session = System::getContainer()->get('session');
	    //c4 $a = $session->get('sorting');
	    $objSessionBag = System::getContainer()->get('session')->getBag('contao_backend');
	    $a = $objSessionBag->get('sorting');
	    $this->logMessage(print_r($a,true),'BackendUserOnlineRunonceJob');
	    
	    $a['tl_user']   = 'currentLogin DESC';
	    $a['tl_member'] = 'currentLogin DESC';
	    //c3 $this->Session->set('sorting',$a);
	    //c4 $session->set('sorting',$a);
	    $objSessionBag->set('sorting', $a);
	    
	}
	
	/**
	 * Wrapper for old log_message
	 *
	 * @param string $strMessage
	 * @param string $strLogg
	 */
	public function logMessage($strMessage, $strLog=null)
	{
	    if ($strLog === null)
	    {
	        $strLog = 'prod-' . date('Y-m-d') . '.log';
	    }
	    else
	    {
	        $strLog = 'prod-' . date('Y-m-d') . '-' . $strLog . '.log';
	    }
	
	    $strLogsDir = null;
	
	    if (($container = System::getContainer()) !== null)
	    {
	        $strLogsDir = $container->getParameter('kernel.logs_dir');
	    }
	
	    if (!$strLogsDir)
	    {
	        $strLogsDir = TL_ROOT . '/var/logs';
	    }
	
	    error_log(sprintf("[%s] %s\n", date('d-M-Y H:i:s'), $strMessage), 3, $strLogsDir . '/' . $strLog);
	}
}

$objBackendUserOnlineRunonceJob = new BackendUserOnlineRunonceJob();
$objBackendUserOnlineRunonceJob->run();
