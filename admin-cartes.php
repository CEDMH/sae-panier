<?php
require 'bootstrap.php';
// verification de la session admin, si pas bon hop on redirige //
if (empty($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: admin-login.php');
    exit;
}

$message   = '';
// On récupère l'information de si l'admin a cliqué sur le bouton débloquer via le formulaire dédié,//
// puis on prépare la requête pour changer le 1 en 0 avec un message de succès //
if (isset($_POST['debloquer'])) {
    $id = $_POST['id'] ?? '';
    $requete = $pdo->prepare('UPDATE clients SET est_bloque = 0 WHERE id = :id');
    $requete->execute([':id' => $id]);
    $message = 'Carte débloquée avec succès.';
}
// On récupère l'information de si l'admin a cliqué sur le bouton supprimer via le formulaire dédié,//
// puis on prépare la requête pour delete le client via son "id" avec un message de succès //
if (isset($_POST['supprimer'])) {
    $id = $_POST['id'] ?? '';
    $requete = $pdo->prepare('DELETE FROM clients WHERE id = :id');
    $requete->execute([':id' => $id]);
    $message = 'Carte supprimée avec succès.';
}
// On récupère les informations via le formulaire dédié que l'admin a changé ou modifié //
if (isset($_POST['modifier'])) {
    $id        = $_POST['id'] ?? '';
    $nom       = trim($_POST['nom'] ?? '');
    $prenom    = trim($_POST['prenom'] ?? '');
    $adresse   = trim($_POST['adresse'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $telephone = trim($_POST['telephone'] ?? '');
// puis on modifie la BDD avec "UPDATE" qui va tout remplacer avec les données fournis avec un message de succès. //
    if ($nom && $prenom && $adresse && $email && $telephone) {
        $requete = $pdo->prepare('UPDATE clients SET nom = :nom, prenom = :prenom, adresse = :adresse, email = :email, telephone = :telephone WHERE id = :id');
        $requete->execute([':id' => $id,':nom' => $nom,':prenom' => $prenom,':adresse' => $adresse,':email' => $email,':telephone' => $telephone,]);
        $message = 'Carte modifiée avec succès.';
    } 
}
// On récupère toutes les infos de la table clients pour les mettrent dans un tableau //
$requete = $pdo->prepare('SELECT * FROM clients ORDER BY nom ASC');
$requete->execute();
$clients = $requete->fetchAll();

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GESTION CARTES</title>
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
    <link href="./assets/css/admin-cartes.css" rel="stylesheet">


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
              <li class="case"><a href="admin-panier.php">Paniers</a></li>
              <li class="case"><a href="admin-reservations.php">Réservations</a></li>
              <li class="case"><a href="admin-cartes.php" class="active">Cartes</a></li>
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
      <h1>Géstion des cartes clients</h1>
      <p>Vous pouvez débloquer, modifier ou supprimer les cartes de vos clients.</p>
    </article>
<!-- Affichage des message de succées -->
    <?php if ($message): ?>
        <p><?php echo htmlspecialchars($message) ?></p>
    <?php endif; ?>

<!-- On parcour $clients et on assigne la valeur de l'élément courant dans $client  -->
    <?php foreach ($clients as $client): ?>

    <section>
<!-- Affichage du numero de carte de fidélité de la personne et de son statut (bloqué ou actif) -->
        <p> 
            La carte : "<?php echo htmlspecialchars($client['num_carte_fidelite']) ?>" est <?php echo $client['est_bloque'] ? '<strong>BLOQUÉ</strong>' : 'Active' ?>
        </p>
<!-- formulaire de modification des informations du client (selectionner avec l'id qui est l'identification) avec le boutons de validation  -->
        <form action="" method="post">
            <input type="hidden" name="id" value="<?php echo $client['id'] ?>">

            <div>
                <label for="nom">Nom :</label>
                <input type="text"  name="nom" value="<?php echo htmlspecialchars($client['nom']) ?>" required>
            </div>
            <div>
                <label for="prenom">Prénom :</label>
                <input type="text"  name="prenom" value="<?php echo htmlspecialchars($client['prenom']) ?>" required>
            </div>
            <div>
                <label for="adresse">Adresse postale :</label>
                <input type="text"  name="adresse" value="<?php echo htmlspecialchars($client['adresse']) ?>" required>
            </div>
            <div>
                <label for="email">Email :</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($client['email']) ?>" required>
            </div>
            <div>
                <label for="telephone">Téléphone :</label>
                <input type="tel"   name="telephone" value="<?php echo htmlspecialchars($client['telephone']) ?>" required>
            </div>
            
            <button type="submit" name="modifier">Valider la modification</button>
        </form>
<!-- Formulaire du bouton pour débloqué la cartes qui s'affiche que si est_bloque est égale a 1 dans la BDD  -->
        <?php if ($client['est_bloque'] == 1): ?>
        <form action="" method="post">
            <input type="hidden" name="id" value="<?php echo $client['id'] ?>">
            <button type="submit" name="debloquer">Débloquer</button>
        </form>
        <?php endif; ?>
<!-- Formulaire du bouton pour supprimer un compte client  -->
        <form action="" method="post">
            <input type="hidden" name="id" value="<?php echo $client['id'] ?>">
            <button type="submit" name="supprimer">Supprimer</button>
        </form>
    
    </section>

    <?php endforeach; ?>

  </main>

</body>

</html>