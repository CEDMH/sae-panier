<?php
require 'bootstrap.php'; // Pour avoir accès à $pdo

if (empty($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: admin-login.php');
    exit;
}

$message = "";
// On récupère les informations via le formulaire dédié que l'admin a changé ou modifié //
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action_type']) && $_POST['action_type'] === 'modifier') {
        $id = $_POST['id_panier'];
        $type = trim($_POST['type']);
        $description = trim($_POST['description']);
        $prix = $_POST['prix'];
        $date_retrait = $_POST['date_retrait'];
// puis on modifie la BDD avec "UPDATE" qui va tout remplacer avec les données fournis avec un message de succès. //
        $requete = $pdo->prepare("UPDATE paniers SET type = :type, description = :desc, prix = :prix, date_retrait = :date_retrait WHERE id = :id");
        $requete->execute([':type' => $type,':desc' => $description,':prix' => $prix,':date_retrait' => $date_retrait,':id' => $id]);
        $message = "Le panier est mis à jour !";
    }
// On récupère l'information de si l'admin a cliqué sur le bouton supprimer via le formulaire dédié, //
// puis on prépare la requête pour delete le paner via son "id_panier" avec un message de succès //
    if (isset($_POST['action_type']) && $_POST['action_type'] === 'supprimer') {
        $id = $_POST['id_panier'];

        $requete2 = $pdo->prepare("DELETE FROM paniers WHERE id = :id");
        $requete2->execute([':id' => $id]);
        $message = "Le panier a été supprimé définitivement.";
    }
}
// on met tout le contenu de la table paniers dans $paniers sous forme de tableau //
$paniers = $pdo->query("SELECT * FROM paniers")->fetchAll();

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CREATION PANIER</title>
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
<!-- condition qui dit que si un "message" est déclanché plus haut il s'affiche ici -->
        <?php if (!empty($message)){ ?>
            <article class="message"><?php echo $message; ?></article>
        <?php } ?>
        
        <article>
        <h1>Paniers existants :</h1>
        <p>Ici vous pouvez modifier vos paniers qui sont actuellement proposés à vos clients ! Si vous voulez créer un nouveau panier, vous pouvez cliquer sur le bouton en bas de page "Créer un nouveau panier".</p>
        </article>

        <section class="section-page-paniers">
<!-- On parcour $paniers et on assigne la valeur de l'élément courant dans $panier  -->
            <?php foreach ($paniers as $panier){ ?>
                <article class="paniers">
<!-- formulaire de modification des informations du client (selectionner avec l'id qui est l'identification) avec le boutons de validation  -->                    
                    <form action="" method="POST">
                        <input type="hidden" name="id_panier" value="<?php echo $panier['id']; ?>">
                        <input type="hidden" name="action_type" value="modifier">
                        
                        <label>Format / Type du panier :
                            <input type="text" name="type" value="<?php echo htmlspecialchars($panier['type']); ?>" required>
                        </label>

                        <label>Description du panier :
                            <textarea name="description" rows="3" required><?php echo htmlspecialchars($panier['description']); ?></textarea>
                        </label>
                        
                        <div class="grid">
                            <label>Prix (€) :
                                <input type="number" step="0.01" name="prix" value="<?php echo htmlspecialchars((string)$panier['prix']); ?>" required>
                            </label>
                            
                            <label>Date de retrait :
                                <input type="date" name="date_retrait" value="<?php echo htmlspecialchars($panier['date_retrait'] ?? ''); ?>" required>
                            </label>
                        </div>
                        
                        <button type="submit" class="bouton-mj">Mettre à jour</button>
                    </form>
<!-- Formulaire du bouton pour supprimer un panier avec un onsubmit qui permet d'avoir une fenetre modale en pop-up  -->
                    <form action="" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer définitivement ce format de panier ?');">
                        <input type="hidden" name="id_panier" value="<?php echo $panier['id']; ?>">
                        <input type="hidden" name="action_type" value="supprimer">
                        <button type="submit" class="bouton-supr">Supprimer ce panier</button>
                    </form>

                </article>
            <?php } ?>
                
        </section>

        <div class="bouton-va"><a href="./admin-panier.php" class="lien-va">Créer un nouveau panier</a></div>

    </main>
</body>
</html>