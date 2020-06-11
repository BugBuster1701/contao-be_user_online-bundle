<?php

$GLOBALS['TL_HOOKS']['postLogin'][]        = array('bugbuster_beuseronline.user_login_listener', 'onSetUserLogin');
$GLOBALS['TL_HOOKS']['postLogout'][]       = array('bugbuster_beuseronline.user_logout_listener', 'onSetUserLogout');
$GLOBALS['TL_HOOKS']['postAuthenticate'][] = array('bugbuster_beuseronline.user_authenticate_listener', 'onSetUserAuthenticate');

/*
 * vendor/bin/contao-console cache:clear --env prod --no-warmup
 * vendor/bin/contao-console cache:warmup --env prod
 */