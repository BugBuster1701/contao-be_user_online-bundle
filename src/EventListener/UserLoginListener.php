<?php

declare(strict_types=1);

/*
 * This file is part of a BugBuster Contao Bundle
 *
 * @copyright  Glen Langer 2020 <http://contao.ninja>
 * @author     Glen Langer (BugBuster)
 * @package    BackendUserOnline
 * @license    LGPL-3.0-or-later
 * @see        https://github.com/BugBuster1701/contao-be_user_online-bundle
 */

namespace BugBuster\BeUserOnlineBundle\EventListener;

use Contao\BackendUser;
use Contao\Config;
use Contao\CoreBundle\Framework\ContaoFrameworkInterface;
use Contao\FrontendUser;
use Contao\System;
use Contao\User;

class UserLoginListener
{
    /**
     * @var ContaoFrameworkInterface
     */
    private $framework;

    /**
     * Contructor.
     */
    public function __construct(ContaoFrameworkInterface $framework)
    {
        $this->framework = $framework;
    }

    /**
     * onSetUserLogin.
     *
     * @return array add your custom modules to the list and return the array of back end modules
     */
    public function onSetUserLogin(User $user)
    {
        $time = time();
        $strHash = '';

        $intUserId = $user->getData()['id']; // for user id, ugly, but I don't know what's better.

        $this->framework->initialize();

        /** @var Config $config */
        $config = $this->framework->getAdapter(Config::class);
        $timeout = (int) $config->get('sessionTimeout');

        // Generate the cookie hash

        if ($user instanceof FrontendUser) {
            $strCookie = 'FE_USER_AUTH';
        }

        if ($user instanceof BackendUser) {
            $strCookie = 'BE_USER_AUTH';
        }
        // Generate the cookie hash
        $container = System::getContainer();
        $token = $container->get('contao.csrf.token_manager')
                           ->getToken($container->getParameter('contao.csrf_token_name'))
                           ->getValue()
        ;
        $token = json_encode($token);

        $strHash = sha1($token.$strCookie);

        // Clean up old sessions
        \Database::getInstance()->prepare('DELETE FROM tl_beuseronline_session WHERE tstamp<? OR hash=?')
                                ->execute(($time - $timeout), $strHash)
        ;

        // Save the session in the database
        \Database::getInstance()->prepare('INSERT INTO tl_beuseronline_session (pid, tstamp, name, hash) VALUES (?, ?, ?, ?)')
                                ->execute($intUserId, $time, $strCookie, $strHash)
        ;

        //use app_dev.php to dump
        //dump from Symfony\Component\VarDumper\VarDumper
        //dump($arrModules['content']['modules']);
    }
}
