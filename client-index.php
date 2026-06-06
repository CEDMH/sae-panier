<?php
require 'bootstrap.php';

if (!(!empty($_SESSION['client_carte']) || (!empty($_SESSION['client_nom']) && !empty($_SESSION['client_tel'])))) {
    header('Location: index.php');
    exit;
}
?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ACCUEIL</title>
    <link href="assets/pico-main/css/pico.sand.css" rel="stylesheet">

    <link href="assets/font-awesome/css/fontawesome.css" rel="stylesheet">
    <link href="assets/font-awesome/css/brands.css" rel="stylesheet">
    <link href="assets/font-awesome/css/regular.css" rel="stylesheet">
    <link href="assets/font-awesome/css/solid.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sansita:ital,wght@0,400;0,700;0,800;0,900;1,400;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/client-index.css" rel="stylesheet">

    <script src="assets/javascript/dm-lm.js"></script>
</head>

<body class="fond-d-ecran">

  <nav class="header">
    <ul>
      <li><img src="assets/image/logo.png" id="logo"></li>
    </ul>
    <ul>
      <li class="lecoindessaveurs"><img src="assets/image/titre.png" id="titre"></li>
    </ul>
    <ul id="menu-burger">
      <li>
        <details class="dropdown">
          <summary>
            
          </summary>
            <ul dir="rtl">
              <li id="case"><a href="client-index.php">Accueil</a></li>
              <li id="case"><a href="paniers.php">Panier</a></li>
              <li id="case"><a href="catalogue.php">Catalogue</a></li>
              <li><button onclick="modeJour()"><i class="fa-solid fa-sun"></i></button> <button onclick="modeNuit()"><i class="fa-solid fa-moon"></i></button></li>
            </ul>
        </details>
      </li>
    </ul>
  </nav>

  <main>
    <div id="super-accueil">
      <p>L'Épicerie Le Coin Des Saveurs Vous souhaite le bonjour !</p>
    </div>
    <article>
      <h1>Bienvenue sur notre appli de réservation !</h1>
      <p>Le mardi et le mercredi, vous pourrez retrouver ci dessous nos trois paniers que vous pourrez réserver !</p>
    </article>
    <article id="les-paniers">
      <ul id="panier">
        <li><img src="./assets/image/panier-m.jpg"><p>Panier 1 personne</p><a href="catalogue.php">Réserver Panier</a></li>
        <li><img src="./assets/image/panier-l.jpg"><p>Panier 2 personnes</p><a href="catalogue.php">Réserver Panier</a></li>
        <li><img src="./assets/image/panier-xl.jpg"><p>Panier 3-4 personnes</p><a href="catalogue.php">Réserver Panier</a></li>
      </ul>
    </article>
  </main>

</body>

</html>