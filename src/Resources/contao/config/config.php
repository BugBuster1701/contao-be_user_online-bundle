<?php

$GLOBALS['TL_HOOKS']['postLogin'][]  = ['bugbuster_beuseronline.user_login_listener' , 'onSetUserLogin'];
$GLOBALS['TL_HOOKS']['postLogout'][] = ['bugbuster_beuseronline.user_logout_listener', 'onSetUserLogout'];

/*
 * vendor/bin/contao-console cache:clear --env prod --no-warmup
 * vendor/bin/contao-console cache:warmup --env prod
 */