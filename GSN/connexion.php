<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gsn";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Requête SQL pour vérifier l'email et le mot de passe
    $sql = "SELECT id_user, type FROM utilisateur WHERE email = '$email' AND mot_de_passe = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row["type"] === "admin") {
            // Administrateur trouvé, créer une session
            $_SESSION["email"] = $email;
            header("Location: admin.php");
            exit;
        } else {
            // Utilisateur régulier trouvé, créer une session et rediriger vers la page de profil
            $_SESSION["email"] = $email;
            header("Location: user.php");
            exit;
        }
    } else {
        // Utilisateur non trouvé, rediriger vers la page de connexion avec un message d'erreur
        $error_message = "Email ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="ins-con.css">
</head>
<body>
    <header>
        <h1>Connexion</h1>
        <nav>
            <ul>
               <li><a href="acceuil.php">Acceuil</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="email">Email :</label><br>
            <input type="text" name="email" required><br>
            <label for="password">Mot de passe :</label><br>
            <input type="password" name="password" required><br>
            <button type="submit">Connexion</button><br>
        </form>
        <?php
        if (isset($error_message)) {
            echo "<p style='color: red;'>$error_message</p>";
        }
        ?>
    </main>
</body>
</html>