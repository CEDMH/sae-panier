<?php require 'bootstrap.php' ?>
<?php require 'helpers/functions.php' ?>
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
        <h1>Bienvenue sur le site</h1>
        <p>Choisissez un mode de connexion ou inscrivez-vous pour créer un compte.</p>
    </header>

    <main>
        <section>
            <form action="#" method="post">
                <section>
                    <legend>Se connecter</legend>
                    <div>
                        <label>
                            <input type="radio" name="role" value="admin" checked>
                            Administrateur
                        </label>
                    </div>
                    <div>
                        <label>
                            <input type="radio" name="role" value="client">
                            Client
                        </label>
                    </div>
                    <div>
                        <label for="username">Nom d'utilisateur :</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    <div>
                        <label for="password">Mot de passe :</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <div>
                        <button type="submit">Se connecter</button>
                    </div>
                </section>
            </form>
        </section>

        <section>
            <p>Pas encore inscrit ? <a href="inscription.html">S'inscrire</a></p>
        </section>

    </main>
    <script src="script.js"></script>
</body>

</html>