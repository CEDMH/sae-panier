<?php 
require 'bootstrap.php';

$erreur = '';
// on definit l'identifiant et le mot de passe ici //
$admin_identifiant = 'admin';
$admin_mdp         = 'admin';
// on recupere les données rentrer par l'admin via le formulaire //
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identifiant = trim($_POST['identifiant'] ?? '');
    $mdp         = trim($_POST['mdp'] ?? '');
// On compare les donées recus avec celles pré-défini et si c'est bon on incrémente "vrai" dans $_SESSION admin puis on redirige // 
    if ($identifiant && $mdp) {

        if ($identifiant === $admin_identifiant && $mdp === $admin_mdp) {
            $_SESSION['admin'] = true;
            header('Location: admin-index.php');
            exit;

        } else {
            $erreur = 'Identifiant ou mot de passe incorrect.';
        }

    } else {
        $erreur = 'Veuillez remplir tous les champs.';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Administrateur</title>
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

    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/index.css" rel="stylesheet">

    <script src="assets/javascript/dm-lm.js"></script>
</head>

<body class="fond-d-ecran">

   <nav class="header">
    <ul id="menu-burger">
      <li>
        <details class="dropdown">
          <summary>
            
          </summary>
            <ul dir="ltr">
              <!-- LES TROIS BOUTONS DU NIGHT MOD, LIGHT MOD ET DYSLEXIC MOD -->
              <li><button onclick="modeJour()"><i class="fa-solid fa-sun"></i></button> <button onclick="modeNuit()"><i class="fa-solid fa-moon"></i></button> <button onclick="modeDys()"><i class="fa-solid fa-universal-access"></i></button></li>
            </ul>
        </details>
      </li>
    </ul>
    <ul>
      <li class="lecoindessaveurs"><img src="assets/image/titre.webp" id="titre"></li>
    </ul>
    <ul>
      <li><img src="assets/image/logo.webp" id="logo"></li>
    </ul>
  </nav>

    <!-- TROIS SAUTS A LA LIGNE BRUTAUX POUR QUE LE MAIN NE SOIT PAS CACHÉ PAR LE HEADER/NAV QUI EST EN POSITION FIXE -->
    <br>
    <br>
    <br>

    <main>

        <section id="page-index">

            <h1>Connexion Administrateur</h1>
            <p>Accès réservé aux administrateurs.</p>
<!-- condition qui dit que si une erreur est déclanché plus haut elle s'affiche ici -->
            <?php if ($erreur){ ?>
                <p><?php echo htmlspecialchars($erreur) ?></p>
            <?php } ?>

            <form action="" method="post">
                <section>
                    <div>
                        <label for="identifiant">Identifiant :</label>
                        <input type="text" id="identifiant" name="identifiant" required>
                    </div>
                    <div>
                        <label for="mdp">Mot de passe :</label>
                        <input type="password" id="mdp" name="mdp" required>
                    </div>
                    <div>
                        <button type="submit" id="se-connecter">Se connecter</button>
                    </div>
                </section>
            </form>

            <p>Vous êtes un client ? <a href="./index.php">Retour à l'accueil</a></p>

        </section>

    </main>
</body>

</html>