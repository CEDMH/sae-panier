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

    <link href="assets/css/style.css" rel="stylesheet">

    <script src="assets/javascript/dm-lm.js"></script>
</head>

<body>

  <nav class="header">
    <ul>
      <li><img src="assets/image/logo.png" id="logo"></li>
    </ul>
    <ul id="menu-burger">
      <li>
        <details class="dropdown">
          <summary>
            <i class="fa-solid fa-bars" style="color: rgb(0, 122, 80);"></i>
          </summary>
            <ul dir="rtl">
              <li><a href="client-index.php">Accueil</a></li>
              <li><a href="panier.php">Panier</a></li>
              <li><a href="catalogue.php">Catalogue</a></li>
              <li><button onclick="modeJour()"><i class="fa-solid fa-sun"></i></button> <button onclick="modeNuit()"><i class="fa-solid fa-moon"></i></button></li>
            </ul>
        </details>
      </li>
    </ul>
  </nav>

  <main>
    <article>
        <p>Ceci est un exemple temporaire</p>
    </article>
  </main>

</body>

</html>