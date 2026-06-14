<?php
require 'bootstrap.php'; // Pour avoir accès à $pdo

if (empty($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: admin-login.php');
    exit;
}

$message = "";
// On récupère les informations via le formulaire dédié que l'admin a rempli //
if ($_SERVER['REQUEST_METHOD'] === 'POST') {  
    if (isset($_POST['action_type']) && $_POST['action_type'] === 'ajouter') {
        $type = trim($_POST['nouveau_type']);
        $description = trim($_POST['nouvelle_description']);
        $prix = $_POST['nouveau_prix'];
        $date_retrait = $_POST['nouvelle_date_retrait'];
// puis on envoie à la BDD avec "INSERT INTO" qui va créé une ligne avec les données fournis avec un message de succès. //
        if (!empty($type) && !empty($description) && !empty($date_retrait)) {
            $requete = $pdo->prepare("INSERT INTO paniers (type, description, prix, date_retrait) VALUES (:type, :desc, :prix, :date_retrait)");
            $requete->execute([':type' => $type,':desc' => $description,':prix' => $prix,':date_retrait' => $date_retrait]);
            $message = "Le nouveau panier '$type' avec retrait le $date_retrait a bien été ajouté !";
        }

    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GESTION PANIER</title>
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
    <link href="./assets/css/admin-panier.css" rel="stylesheet">

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
              <li class="case"><a href="admin-index.php">Accueil</a></li>
              <li class="case"><a href="admin-panier.php" class="active">Paniers</a></li>
              <li class="case"><a href="admin-reservations.php">Réservations</a></li>
              <li class="case"><a href="admin-cartes.php">Cartes</a></li>
              <li class="case"><a href="admin-statistiques.php">Statistiques</a></li>
              <li class="deco"><a href="./back/deconnexion.php">Déconnexion</a></li>
              <!-- LES TROIS BOUTONS DU NIGHT MOD, LIGHT MOD ET DYSLEXIC MOD -->
              <li><button onclick="modeJour()"><i class="fa-solid fa-sun"></i></button> <button onclick="modeNuit()"><i class="fa-solid fa-moon"></i></button> <button onclick="modeDys()"><i class="fa-solid fa-universal-access"></i></button></li>
            </ul>
        </details>
      </li>
    </ul>
    <ul>
      <li class="lecoindessaveurs"><img src="assets/image/titre.png" id="titre"></li>
    </ul>
    <ul>
      <li><img src="assets/image/logo.png" id="logo"></li>
    </ul>
  </nav>

      <!-- TROIS SAUTS A LA LIGNE BRUTAUX POUR QUE LE MAIN NE SOIT PAS CACHÉ PAR LE HEADER/NAV QUI EST EN POSITION FIXE -->
  <br>
  <br>
  <br>
  <br>

    <main>

        <article>
        <h1>Ajout des paniers :</h1>
        <p>Ici vous pouvez créer de nouveaux paniers qui seront proposés à vos clients pour qu'ils puissent les réserver ! Si vous voulez les supprimer ou les modifier, vous pouvez cliquer sur le bouton en bas de page "Voir les paniers mis en ligne".</p>
        </article>
<!-- condition qui dit que si un "message" est déclanché plus haut il s'affiche ici -->
        <?php if (!empty($message)){ ?>
            <article class="message"><?php echo $message; ?></article>
        <?php } ?>

        <article class="ajout-panier">
            <h2>Ajouter un nouveau panier !</h2>
<!-- formulaire de création de paniers avec le boutons de validation  -->           
            <form action="" method="POST">
                <input type="hidden" name="action_type" value="ajouter">
                
                <div class="grid">
                    <label>Type de panier (ex: 1p, 2p, 3-4p) :
                        <input type="text" name="nouveau_type" placeholder="Format du panier (ex: 4p)..." required>
                    </label>
                    
                    <label>Prix :
                        <input type="number" step="0.01" name="nouveau_prix" placeholder="15.00" required>
                    </label>

                    <label>Date de retrait prévue :
                        <input type="date" name="nouvelle_date_retrait" required>
                    </label>
                </div>

                <label>Description des produits inclus :
                    <textarea name="nouvelle_description" rows="3" placeholder="Ex: 1kg de pommes de terre, 500g de carottes, 1 salade..." required></textarea>
                </label>

                <button type="submit" class="bouton-ml">
                    Créer et mettre en ligne ce panier
                </button>
            </form>
        </article>
        
        <div class="bouton-va"><a href="./admin-panier-existant.php" class="lien-va">Voir les paniers mis en ligne</a></div>

    </main>
</body>
</html>