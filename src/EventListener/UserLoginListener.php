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
        
        if ($user instanceof FrontendUser) {
            // Do something with the front end user $user
            dump('Hook UserLogin Frontend');
        }
        if ($user instanceof BackendUser) {
            // Do something with the back end user $user
            dump('Hook UserLogin Backend');
        }
        
        //use app_dev.php to dump
        //dump from Symfony\Component\VarDumper\VarDumper
        //dump($arrModules['content']['modules']);
        

        
    }
}
