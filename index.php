<?php 
require 'bootstrap.php';


$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numerocarte = trim($_POST['numerocarte'] ?? '');

    if ($numerocarte) {
        $stmt = $pdo->prepare('SELECT * FROM clients WHERE num_carte_fidelite = :numerocarte LIMIT 1');
        $stmt->execute([':numerocarte' => $numerocarte]);
        $client = $stmt->fetch();

        if ($client) {
            
            if ($client['est_bloque'] == 1) {
                $error = 'Votre compte est bloqué. Veuillez contacter le support.';
            } else {
                
                $_SESSION['client_id']     = $client['id'];
                $_SESSION['client_nom']    = $client['nom'];
                $_SESSION['client_prenom'] = $client['prenom'];
                $_SESSION['client_carte']  = $client['num_carte_fidelite'];

                header('Location: client-index.php');
                exit;
            }
        } else {
            $error = 'Numéro de carte de fidélité introuvable.';
        }
    } else {
        $error = 'Veuillez saisir votre numéro de carte.';
    }
}
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SE CONNECTER</title>
    <link href="assets/pico-main/css/pico.sand.css" rel="stylesheet">

    <link href="assets/font-awesome/css/fontawesome.css" rel="stylesheet">
    <link href="assets/font-awesome/css/brands.css" rel="stylesheet">
    <link href="assets/font-awesome/css/regular.css" rel="stylesheet">
    <link href="assets/font-awesome/css/solid.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sansita:ital,wght@0,400;0,700;0,800;0,900;1,400;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Vollkorn:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/index.css" rel="stylesheet">

    <script src="assets/javascript/dm-lm.js"></script>
</head>

<body>

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
        
        <section id="page-index">

            <h1>Bienvenue sur le site</h1>
            <p>Choisissez un mode de connexion ou inscrivez-vous pour créer un compte.</p>

            <?php if ($error): ?>
            <p><?php echo htmlspecialchars($error) ?></p>
            <?php endif; ?>

            <form action="" method="post">
                <section>
                    <div>
                        <label for="username">Numéro de carte de fidélité :</label>
                        <input type="text" id="numerocarte" name="numerocarte" required>
                    </div>
                    <div>
                        <button type="submit">Se connecter</button>
                    </div>
                </section>
            </form>
        </section>

        <section id="page-index">
            <p>Numéro de carte oublié ? <a href="./numero-carte-oublié.php">Oublié</a></p>
            <p>Vous êtes Administrateur ? <a href="./admin-login.php">Administrateur</a></p>
        </section>

    </main>
</body>

</html>