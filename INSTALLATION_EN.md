# Installation of Contao Backend-User-Online Bundle

There are two types of installation.

* with the Contao-Manager
* via the command line


## Installation with Contao-Manager

* search for package: `bugbuster/contao-be_user_online-bundle`
* on version enter "^2.3". (for Contao 4.13 enter "^2.2")
* install the package
* update the database


## Installation via command line

Installation in a Composer-based Contao 5.1+ Managed-Edition:

* `composer require "bugbuster/contao-be_user_online-bundle:^2.3"`
* `php bin/console contao:migrate`

(for Contao 4.13 enter "^2.2")