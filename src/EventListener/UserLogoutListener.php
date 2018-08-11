<?php

namespace BugBuster\BeUserOnlineBundle\EventListener;

use Contao\CoreBundle\Framework\ContaoFrameworkInterface;
use Contao\FrontendUser;
use Contao\BackendUser;
use Contao\User;

class UserLogoutListener
{
    /**
     * @var ContaoFrameworkInterface
     */
    private $framework;

    /**
     * Authentication hash
     * @var string
     */
    protected $strHash;
    
    
    public function __construct(ContaoFrameworkInterface $framework)
    {
        $this->framework = $framework;
    }

    /**
     * onSetUserLogin
     * 
     * @return array                Add your custom modules to the list and return the array of back end modules.
     */
    public function onSetUserLogout(User $user)
    {
        $this->framework->initialize();

        // Generate the cookie hash
        $this->strHash = sha1(session_id() . (!\Config::get('disableIpCheck') ? $user->strIp : '') . $user->strCookie);
        
        if ( ($user instanceof FrontendUser) || ($user instanceof BackendUser) ) 
        {
            // Do something with the front end user $user

            // Remove the session from the database
            \Database::getInstance()->prepare("DELETE FROM tl_beuseronline_session WHERE hash=?")
                                    ->execute($this->strHash);
        }
                
        //use app_dev.php to dump
        //dump from Symfony\Component\VarDumper\VarDumper
        //dump($arrModules['content']['modules']);
        

        
    }
}
