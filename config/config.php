<?php
declare(strict_types=1);
/*
  Fichier : /config/config.php

 2 fichiers peuvent être analysés selon la situation :
   - config.local.php pour le développement LOCAL
   - config.prod.php quand le site est placé chez un hébergeur
 On détecte le local car l'IP de la machine est 127.0.0.1
*/
$is_local = $_SERVER['REMOTE_ADDR'] == '127.0.0.1' || $_SERVER['REMOTE_ADDR'] == '::1';
if ($is_local) {
    require 'config/config.local.php';
} else {
    require 'config/config.prod.php';
}
