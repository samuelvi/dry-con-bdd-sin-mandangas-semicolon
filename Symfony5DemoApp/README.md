BDD Demo en Symfony 5 bajo php 7.4
==================================

Tests en BDD tomando como proyecto base la Aplicación de Demo de Symfony.


Requerimientos
------------

  * PHP 7.4 o superior;
  * Extensión PDO-SQLite PHP activada
  * composer
  * symfony

Instalación
------------

  * composer install
  * ejecutar servidor php: symfony server:start, se levantará https://localhost:8000
  * ejecutar selenium: bash ./scripts/selenium-start.sh
  * inicializar data fixtures: php bin/console doctrine:fixtures:load -n 
  * lanzar todos los tests behat: ./vendor/behat/behat/bin/behat --config=tests/Context/behat.yaml
