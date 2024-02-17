# Installation von Contao Backend-User-Online Bundle

Es gibt zwei Arten der Installation.

* mit dem Contao-Manager 
* über die Kommandozeile


## Installation über Contao-Manager

* Suche das Paket: `bugbuster/contao-be_user_online-bundle`
* Bei Version "^2.3" angeben. (für Contao 4.13 "^2.2" angeben)
* Installation der Erweiterung
* Datenbank Update durchführen


## Installation über die Kommandozeile

Installation in einer Composer-basierenden Contao 5.1+ Managed-Edition:

* `composer require "bugbuster/contao-be_user_online-bundle:^2.3"`
* `php bin/console contao:migrate`

(für Contao 4.13 "^2.2" angeben)