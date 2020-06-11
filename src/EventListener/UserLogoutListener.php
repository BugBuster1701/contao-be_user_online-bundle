<?php

namespace BugBuster\BeUserOnlineBundle\EventListener;

use Contao\FrontendUser;
use Contao\BackendUser;
use Contao\User;
use Contao\System;

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
    
    
    public function __construct()
    {
        
    }

    /**
     * onSetUserLogin
     * 
     * @return array                Add your custom modules to the list and return the array of back end modules.
     */
    public function onSetUserLogout(User $user)
    {
        $intUserId = $user->getData()['id']; // for user id, ugly, but I don't know what's better.

        $strHash = '';
        
        if ($user instanceof FrontendUser)
        {
            $strCookie = 'FE_USER_AUTH';
        }
        
        if ($user instanceof BackendUser)
        {
            $strCookie = 'BE_USER_AUTH';
        }
        // Generate the cookie hash
        //$token = $_COOKIE["csrf_contao_csrf_token"];
        $container = System::getContainer();
        $token = $container->get('contao.csrf.token_manager')
                           ->getToken($container->getParameter('contao.csrf_token_name'))
                           ->getValue();

        $token = json_encode($token);
        dump($token); //TODO entfernen vor Deployment
        $strHash = sha1($token.$strCookie);
        
        // Remove the oldest session for the hash from the database
        \Database::getInstance()->prepare("DELETE FROM tl_beuseronline_session WHERE pid=? AND hash=? ORDER BY tstamp")
                                ->limit(1)
                                ->execute($intUserId, $strHash);
                
        //use app_dev.php to dump
        //dump from Symfony\Component\VarDumper\VarDumper
        //dump($arrModules['content']['modules']);
        

        
    }
}
