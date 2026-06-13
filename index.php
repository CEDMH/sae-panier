<?php 
require 'bootstrap.php';


$error = '';
// On vient recuperer l'info rentrer par l'utilisateur dans le formulaire //
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numerocarte = trim($_POST['numerocarte'] ?? '');
// La requete sql va parcourir la BD et ramene toute la ligne correspondant au numéro de carte de fidélité : //
// ':numerocarte' est ce qu'on recoit de la BD puis on le compare avec "=> $numerocarte" qui est ce qu'on recoit du formulaire. //
// et on fini par mettre tout la ligne de la BD dans la variable $client //
    if ($numerocarte) {
        $requete = $pdo->prepare('SELECT * FROM clients WHERE num_carte_fidelite = :numerocarte LIMIT 1');
        $requete->execute([':numerocarte' => $numerocarte]);
        $client = $requete->fetch();
// ici on vient tester si le client a renouveler une commande dans les 3 precedant mois si se n'est pas le cas Hop on bloque !! //
// en premier on va chercher la date de retrait dans la table reservation avec le nom et prenom recuperer plus tot et stocker dans $client, pour nous stocker ça dans $dernier_reservation //
// ensuite on applique la date de retrait dans $date_retrait, on donne la date du jour a $aujourdhui et on calcul la différence entre aujourd'hui et la dat de retrait dans $difference //
// puis on vient comparé la différence qu'on a calculé avec la condition des 3 mois (en mettant les années car au bout de 12 mois ça repasse a 0), si c'est pas bon on change la valeur de la carte pour la bloqué et on change ça aussi pour $client car sinon ça biaise le reste //
        if ($client) {
            $requete2 = $pdo->prepare('SELECT date_retrait FROM reservations WHERE nom = :nom AND prenom = :prenom ORDER BY date_retrait DESC LIMIT 1');
            $requete2->execute([':nom' => $client['nom'], ':prenom' => $client['prenom'],]);
            $derniere_reservation = $requete2->fetch();

            if ($derniere_reservation) {
                $date_retrait = new DateTime($derniere_reservation['date_retrait']);
                $aujourdhui = new DateTime();
                $difference = $aujourdhui->diff($date_retrait);

                if ($difference->y >= 1 || $difference->m >= 3) {
                    $requete3 = $pdo->prepare('UPDATE clients SET est_bloque = 1 WHERE id = :id');
                    $requete3->execute([':id' => $client['id']]);
                    $client['est_bloque'] = 1; 
                }
            }
// condition pour savoir si la carte est bloqué avec les infos recuperer de la BD stocké dans $client //
// puis stockage des infos importantes dans les variables $_SESSION et redirection vers la page // 
            if ($client['est_bloque'] == 1) {
                $error = 'Votre compte est bloqué. Veuillez contacter le gérant.';
            } else {
                
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

    <main>
        
        <section id="page-index">

            <h1>Bienvenue sur le site</h1>
            <p>Identifiez-vous avec votre numéro de carte de fidélité.</p>
<!-- // condition qui dit que si une erreur est déclanché plus haut elle s'affiche ici // -->
            <?php if ($error){ ?>
            <p><?php echo htmlspecialchars($error) ?></p>
            <?php } ?>
            <!-- // formulaire où les infos sont transmisent en method POST // -->
            <form action="" method="post">
                <section>
                    <div>
                        <label for="numerocarte">Numéro de carte de fidélité :</label>
                        <input type="text" id="numerocarte" name="numerocarte" required>
                    </div>
                    <div>
                        <button type="submit" id="se-connecter">Se connecter</button>
                    </div>
                </section>
            </form>
        </section>

        <section id="page-index">
            <p>Pas de compte ? <a href="./inscription.php">S'inscrire</a></p>
            <p>Numéro de carte oublié ? <a href="./numero-carte-oublié.php">Oublié</a></p>
            <p>Vous êtes Administrateur ? <a href="./admin-login.php">Administrateur</a></p>
        </section>

    </main>
</body>

</html>