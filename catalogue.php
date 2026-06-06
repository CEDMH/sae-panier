<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ACCUEIL</title>
    <link rel="icon" type="image/png" sizes="32x32" href="./assets/icons/favicon-32x32.png">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="./assets/icons/apple-touch-icon-180x180.png">
    
    <link href="assets/pico-main/css/pico.sand.css" rel="stylesheet">

    <link href="assets/font-awesome/css/fontawesome.css" rel="stylesheet">
    <link href="assets/font-awesome/css/brands.css" rel="stylesheet">
    <link href="assets/font-awesome/css/regular.css" rel="stylesheet">
    <link href="assets/font-awesome/css/solid.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sansita:ital,wght@0,400;0,700;0,800;0,900;1,400;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Vollkorn:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Martel:wght@200;300;400;600;700;800;900&display=swap" rel="stylesheet">

    <link href="./assets/css/style.css" rel="stylesheet">
    <link href="./assets/css/catalogue.css" rel="stylesheet">

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
              <li id="case"><a href="panier.php">Panier</a></li>
              <li id="case"><a href="catalogue.php">Catalogue</a></li>
              <li><button onclick="modeJour()"><i class="fa-solid fa-sun"></i></button> <button onclick="modeNuit()"><i class="fa-solid fa-moon"></i></button> <button onclick="modeDys()"><i class="fa-solid fa-universal-access"></i></button></li>
            </ul>
        </details>
      </li>
    </ul>
  </nav>

  <br>
  <br>
  <br>

  <main>
    <article id="les-paniers">
        <div id="paniers">
          <h2>Panier 1 personne</h2>
          <img src="./assets/image/panier-m.jpg" id="image-panier">
          <a href="panier.php">Réserver Panier</a>
        </div>
        <div id="paniers">
          <h2>Panier 2 personnes</h2>
          <img src="./assets/image/panier-l.jpg" id="image-panier">
          <a href="panier.php">Réserver Panier</a>
        </div>
        <div id="paniers">
          <h2>Panier 3-4 personnes</h2>
          <img src="./assets/image/panier-xl.jpg" id="image-panier">
          <a href="panier.php">Réserver Panier</a>
        </div>
    </article>
  </main>

</body>

</html>