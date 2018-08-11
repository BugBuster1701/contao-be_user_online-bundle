<?php

namespace BugBuster\BeUserOnlineBundle\EventListener;

use Contao\CoreBundle\Framework\ContaoFrameworkInterface;
use Contao\FrontendUser;
use Contao\BackendUser;
use Contao\User;

class UserLoginListener
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
    

    /**
     * Contructor 
     * 
     * @param ContaoFrameworkInterface $framework
     */
    public function __construct(ContaoFrameworkInterface $framework)
    {
        $this->framework = $framework;
    }

    /**
     * onSetUserLogin
     * 
     * @return array                Add your custom modules to the list and return the array of back end modules.
     */
    public function onSetUserLogin(User $user)
    {
        $this->framework->initialize();
        $time = time();
        // Generate the cookie hash
        $this->strHash = sha1(session_id() . (!\Config::get('disableIpCheck') ? $user->strIp : '') . $user->strCookie);
        
        if ( ($user instanceof FrontendUser) || ($user instanceof BackendUser) ) 
        {
            // Do something with the front end user $user
            
            // Clean up old sessions
            \Database::getInstance()->prepare("DELETE FROM tl_beuseronline_session WHERE tstamp<? OR hash=?")
                                    ->execute( ($time - \Config::get('sessionTimeout')), $this->strHash );
            
            // Save the session in the database
            \Database::getInstance()->prepare("INSERT INTO tl_beuseronline_session (pid, tstamp, name, hash) VALUES (?, ?, ?, ?)")
                                    ->execute($user->intId, $time, $user->strCookie, $this->strHash);
            
        }

        //use app_dev.php to dump
        //dump from Symfony\Component\VarDumper\VarDumper
        //dump($arrModules['content']['modules']);
        

        
    }
}
