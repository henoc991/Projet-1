<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gsn";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $numero = htmlspecialchars($_POST['numero']);
    $email = htmlspecialchars($_POST['email']);

    // Validation de l'email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<script>alert("L\'adresse e-mail n\'est pas valide!");</script>';
    } else {
        // Préparation et exécution de la requête SQL
        $sql = $conn->prepare("INSERT INTO nounou (nom, prenom, numero, email) VALUES (?, ?, ?, ?)");
        $sql->bind_param("ssss", $nom, $prenom, $numero, $email);

        if ($sql->execute() === TRUE) {
            // Succès de l'insertion
            echo '<script>alert("Votre nounou a été ajoutée avec succès!");</script>';
        } else {
            // Erreur lors de l'insertion
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Fermeture de la requête
        $sql->close();
    }
}

// Requêtes pour récupérer les données de la base de données
$sql_utilisateur = 'SELECT * FROM utilisateur';
$result_utilisateur = $conn->query($sql_utilisateur);

$sql_nounou = 'SELECT * FROM nounou';
$result_nounou = $conn->query($sql_nounou);

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mon_agence</title>
    <link rel="stylesheet" href="admin.css">
</head>

<body>
    <header>
        <h1>Mon_Agence - Espace Administrateur</h1>
        <p>
            <h2>Bienvenue sur l'espace Administrateur</h2>
        </p>
        <nav>
            <ul>
                <li><a href="acceuil.php" target="_self">Deconnexion</a></li>
            </ul>
        </nav>
    </header>

    <main>

        <h2>Enregistrez votre nounou</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

            <label for="nom">Nom:</label>
            <input type="text" name="nom" placeholder="Entrez le nom de la nounou" required>

            <label for="prenom">Prénom:</label>
            <input type="text" name="prenom" placeholder="Entrez le prénom de la nounou" required>

            <label for="numero">Numéro:</label>
            <input type="text" name="numero" placeholder="Entrez le numéro de la nounou" required>

            <label for="email">Email:</label>
            <input type="email" name="email" placeholder="Entrez l'email de la nounou" required>

            <br><br>
            <button type="submit">Valider</button>

        </form>

        <br><br>

        <div class="utilisateur">
            <h2>Liste des parents</h2>
            <ul>
                <?php
                // Affichage des utilisateurs
                if ($result_utilisateur->num_rows > 0) {
                    while ($row = $result_utilisateur->fetch_assoc()) {
                        echo "<li>" . $row["nom"] . " " . $row["prenom"] . " (" . $row["email"] . ")</li>";
                    }
                } else {
                    echo "<li>Aucun employeur pour l'instant</li>";
                }
                ?>
            </ul>
        </div>

        <div class="domestique">
            <h2>Nounous disponibles</h2>
            <ul>
                <?php
                if ($result_nounou->num_rows > 0) {
                    while ($row = $result_nounou->fetch_assoc()) {
                        echo "<li>" . $row["Nom"] . " " . $row["Prenom"] . " (Numéro: " . $row["Numero"] . ", Email: " . $row["Email"] . ")</li>";
                    }
                } else {
                    echo "<li>Aucune nounou disponible pour l'instant</li>";
                }
                ?>
            </ul>
        </div>

    </main>

</body>

</html>