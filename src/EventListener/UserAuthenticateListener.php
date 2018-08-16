<?php

namespace BugBuster\BeUserOnlineBundle\EventListener;

use Contao\CoreBundle\Framework\ContaoFrameworkInterface;
use Contao\FrontendUser;
use Contao\BackendUser;
use Contao\User;

class UserAuthenticateListener
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
     * onSetUserAuthenticate
     * 
     * @return array                Add your custom modules to the list and return the array of back end modules.
     */
    public function onSetUserAuthenticate(User $user)
    {
        $intUserId = $user->getData()['id']; // for user id, ugly, but I don't know what's better.
        //$this->framework->initialize();
        $strHash = '';
        $time = time();
        
        if ($user instanceof FrontendUser)
        {
            $strCookie = 'FE_USER_AUTH';
        }
        
        if ($user instanceof BackendUser)
        {
            $strCookie = 'BE_USER_AUTH';
        }
        
        // Generate the cookie hash
        $token = $_COOKIE["csrf_contao_csrf_token"];
        $strHash = sha1($token.$strCookie);
        
        // Update session
        \Database::getInstance()->prepare("UPDATE tl_beuseronline_session SET tstamp=$time WHERE pid=? AND hash=?")
                                ->execute($intUserId, $strHash);
                
        //use app_dev.php to dump
        //dump from Symfony\Component\VarDumper\VarDumper
        //dump($arrModules['content']['modules']);
        

        
    }
}
