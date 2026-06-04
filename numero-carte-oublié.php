<?php 
require 'bootstrap.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom       = trim($_POST['nom'] ?? '');
    $telephone = trim($_POST['telephone'] ?? '');

    if ($nom && $telephone) {
        $stmt = $pdo->prepare('SELECT * FROM clients WHERE nom = :nom AND telephone = :telephone LIMIT 1');
        $stmt->execute([
            ':nom'       => $nom,
            ':telephone' => $telephone,
        ]);
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
            $error = 'Aucun compte trouvé avec ces informations.';
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
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://unpkg.com/@picocss/pico@1.*/css/pico.min.css">
  <link rel="stylesheet" href="assets/css/custom.css">
  <title>Se connecter</title>
</head>

<body>

    <header>
        <h1>Numéro de carte oublié</h1>
        <p>Identifiez-vous avec votre nom et votre numéro de téléphone.</p>
    </header>

    <main>
        <section>

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
                        <label for="telephone">Numéro de téléphone :</label>
                        <input type="tel" id="telephone" name="telephone" required>
                    </div>
                    <div>
                        <button type="submit">Se connecter</button>
                    </div>
                </section>
            </form>
        </section>

        <section>
            <p>Se connecter <a href="./index.php">Se connecter</a></p>
            <p>Vous êtes Administrateur ? <a href="./admin-login.php">Administrateur</a></p>
        </section>

    </main>
    <script src="script.js"></script>
</body>

</html>