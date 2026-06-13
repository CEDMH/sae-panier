<?php
require 'bootstrap.php'; // Pour avoir accès à $pdo

if (empty($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: admin-login.php');
    exit;
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // MODIFIER UN PANIER EXISTANT
    if (isset($_POST['action_type']) && $_POST['action_type'] === 'modifier') {
        $id = $_POST['id_panier'];
        $type = trim($_POST['type']);
        $description = trim($_POST['description']);
        $prix = $_POST['prix'];
        $date_retrait = $_POST['date_retrait'];

        $req = $pdo->prepare("UPDATE paniers SET type = :type, description = :desc, prix = :prix, date_retrait = :date_retrait WHERE id = :id");
        $req->execute([
            ':type'         => $type,
            ':desc'         => $description,
            ':prix'         => $prix,
            ':date_retrait' => $date_retrait,
            ':id'           => $id
        ]);
        $message = "Le panier a bien été mis à jour !";
    }

    // SUPPRIMER UN PANIER
    if (isset($_POST['action_type']) && $_POST['action_type'] === 'supprimer') {
        $id = $_POST['id_panier'];

        $req = $pdo->prepare("DELETE FROM paniers WHERE id = :id");
        $req->execute([':id' => $id]);
        $message = "Le panier a été supprimé définitivement.";
    }
}

$paniers = $pdo->query("SELECT * FROM paniers")->fetchAll();

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PANIER</title>
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
    <link href="./assets/css/admin-index.css" rel="stylesheet">

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

        <?php if (!empty($message)): ?>
            <article style="background-color: #d4edda; color: #155724; border-color: #c3e6cb; padding: 10px; font-weight: bold;">
                <?php echo $message; ?>
            </article>
        <?php endif; ?>

        <div><a href="./admin-panier.php" class="lien-va">Créer un nouveau panier</a></div>

        <h2>Paniers existants (Modifier ou Supprimer)</h2>
        
        <section style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px;">

            <?php foreach ($paniers as $panier): ?>
                <article style="border: 1px solid #ccc; padding: 15px; border-radius: 8px;">
                    
                    <form action="" method="POST" style="margin-bottom: 10px;">
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
                        
                        <button type="submit" style="background-color: #1141a1; border: none;">Mettre à jour</button>
                    </form>

                    <form action="" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer définitivement ce format de panier ?');" style="margin: 0;">
                        <input type="hidden" name="id_panier" value="<?php echo $panier['id']; ?>">
                        <input type="hidden" name="action_type" value="supprimer">
                        <button type="submit" style="background-color: #ff4d4d; border: none; width: 100%;">Supprimer ce panier</button>
                    </form>

                </article>
            <?php endforeach; ?>

        </section>

    </main>
</body>
</html>