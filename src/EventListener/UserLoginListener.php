<?php

namespace BugBuster\BeUserOnlineBundle\EventListener;

use Contao\CoreBundle\Framework\ContaoFrameworkInterface;
use Contao\FrontendUser;
use Contao\BackendUser;
use Contao\User;
use Contao\Config;
use Contao\System;

class UserLoginListener
{
    /**
     * @var ContaoFrameworkInterface
     */
    private $framework;


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
        $time    = time();
        $strHash = '';
        
        $intUserId = $user->getData()['id']; // for user id, ugly, but I don't know what's better.
        
        $this->framework->initialize();
        
        /** @var Config $config */
        $config  = $this->framework->getAdapter(Config::class);
        $timeout = (int) $config->get('sessionTimeout');
        
        
        // Generate the cookie hash

        if ($user instanceof FrontendUser)
        {
            $strCookie = 'FE_USER_AUTH';
        }
        
        if ($user instanceof BackendUser)
        {
            $strCookie = 'BE_USER_AUTH';
        }
        //$token = $_COOKIE["csrf_contao_csrf_token"];
        $container = System::getContainer();
        $token = $container->get('contao.csrf.token_manager')
                           ->getToken($container->getParameter('contao.csrf_token_name'))
                           ->getValue();

        $token = json_encode($token);
        dump($token); //TODO entfernen vor Deployment
        $strHash = sha1($token.$strCookie);
        
        // Clean up old sessions
        \Database::getInstance()->prepare("DELETE FROM tl_beuseronline_session WHERE tstamp<? OR hash=?")
                                ->execute( ($time - $timeout), $strHash );
        
        // Save the session in the database
        \Database::getInstance()->prepare("INSERT INTO tl_beuseronline_session (pid, tstamp, name, hash) VALUES (?, ?, ?, ?)")
                                ->execute($intUserId, $time, $strCookie, $strHash);
        

        //use app_dev.php to dump
        //dump from Symfony\Component\VarDumper\VarDumper
        //dump($arrModules['content']['modules']);
        

        
    }
}
