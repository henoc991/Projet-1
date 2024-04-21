<!-- inscription.php -->
<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gsn";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) 
{
    die("La connexion a échoué : " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $email = htmlentities($_POST["email"]);
    $nom =  htmlentities($_POST["nom"]);
    $prenom = htmlentities($_POST["prenom"]);
    $password = htmlentities($_POST["password"]);

    // Vérifie si l'email existe déjà dans la base de données
    $sql = "SELECT id_user FROM utilisateur WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) 
    {
        $error_message = "Cet email est déjà utilisé, veuillez en choisir un autre.";
    }

    else 
    {
        // Insérer les informations de l'utilisateur dans la base de données
        $sql = "INSERT INTO utilisateur (email, nom, prenom, mot_de_passe, type) VALUES ('$email', '$nom', '$prenom', '$password','user')";
        if ($conn->query($sql) === TRUE) 
        {
            $_SESSION["email"] = $email;
            header("Location: user.php");
            exit();
        } 
        else
        {
            $error_message = "Une erreur s'est produite lors de l'inscription. Veuillez réessayer.";
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="ins-con.css">
</head>
<body>


    <header>

        <h1>Inscription</h1>

        <nav>
            <ul>
               <li><a href="acceuil.php">Acceuil</a></li>
            </ul>
        </nav>

    </header>


    <main>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

            <h2>Inscrivez-vous gratuitement!</h2>

            <label for="email">Renseignez votre email :</label>
            <input type="text" name="email" required><br>

            <label for="nom">Renseignez votre nom :</label>
            <input type="text" name="nom" required><br>

            <label for="prenom">Renseignez votre prenom :</label>
            <input type="text" name="prenom" required><br>

            <label for="password">Mot de passe :</label>
            <input type="password" name="password" required><br>

            <button type="submit">S'inscrire</button>

        </form>

        
        <?php
        if (isset($error_message)) 
        {
            echo "<p style='color: red;'>$error_message</p>";
        }
        ?>

    </main>
</body>
</html>