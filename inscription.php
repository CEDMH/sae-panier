<?php 
require 'bootstrap.php';

$error = '';
// On vient recuperer l'info rentrer par l'utilisateur dans le formulaire //
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $adresse = trim($_POST['adresse'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telephone = trim($_POST['telephone'] ?? '');

    if ($nom && $prenom && $adresse && $email && $telephone) {

        do {
            $numerocarte = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 6));
            $requete = $pdo->prepare('SELECT id FROM clients WHERE num_carte_fidelite = :numerocarte LIMIT 1');
            $requete->execute(['numerocarte' => $numerocarte]);
        } 

        while ($requete->fetch());

        $requete2 = $pdo->prepare("INSERT INTO clients (nom, prenom, adresse, email, telephone, num_carte_fidelite, date_creation) VALUES (:nom, :prenom, :adresse, :email, :telephone, :num_carte_fidelite, NOW())");
        $inscription = $requete2->execute(['nom' => $nom, 'prenom' => $prenom, 'adresse' => $adresse, 'email' => $email, 'telephone' => $telephone, 'num_carte_fidelite' => $numerocarte,]);
        
    if ($inscription) {

        $email_subject = "Votre carte de fidélité - Le Coin des Saveurs";

        $email_message  = "Bonjour " . $prenom . " " . $nom . ",\n\n";
        $email_message .= "Votre carte de fidélité a bien été créée !\n\n";
        $email_message .= "Votre numéro de carte est : " . $numerocarte . "\n\n";
        $email_message .= "Conservez bien ce numéro, il vous sera demandé à chaque connexion.\n\n";
        $email_message .= "À bientôt,\n";

            $headers = "From: craymond@alwaysdata.net\r\n" .
                       "Reply-To: craymond@alwaysdata.net\r\n" .
                       "MIME-Version: 1.0\r\n" .
                       "Content-Type: text/plain; charset=utf-8\r\n" .
                       "X-Mailer: PHP/" . phpversion();

            mail($email, $email_subject, $email_message, $headers);
           

            $error = 'Votre carte a bien été créée ! Votre numéro de carte est : ' . $numerocarte . '. Un email de confirmation vous a été envoyé, pensez à verifier vos Spams.';

        } else {
            $error = 'Erreur lors de l\'inscription.';
        }

    } else {
        $error = 'Veuillez remplir tous les champs.';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SE CONNECTER</title>
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

        <section id="inscription">

            <h1>Créer un compte</h1>
            <p>Remplissez le formulaire pour obtenir votre carte de fidélité.</p>
            
            <?php if ($error): ?>
            <p><?php echo htmlspecialchars($error) ?></p>
            <?php endif; ?>

            <form action="" method="post">
                <section>
                    <div>
                        <label for="nom">Nom :</label>
                        <input type="text" id="nom" name="nom" required>
                    </div>
                    <div>
                        <label for="prenom">Prénom :</label>
                        <input type="text" id="prenom" name="prenom" required>
                    </div>
                    <div>
                        <label for="adresse">Adresse postale :</label>
                        <input type="text" id="adresse" name="adresse" required>
                    </div>
                    <div>
                        <label for="email">Email :</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div>
                        <label for="telephone">Téléphone :</label>
                        <input type="tel" id="telephone" name="telephone" required>
                    </div>
                    <div>
                        <button type="submit" id="se-connecter">Créer ma carte</button>
                    </div>
                </section>
            </form>

        </section>

        <section id="inscription">
            <p>Déjà un compte ? <a href="./index.php">Se connecter</a></p>
        </section>

    </main>
</body>

</html>