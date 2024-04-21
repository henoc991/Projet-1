<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gsn";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) 
{
  die("La connexion a échoué : " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{

  $date_reservation = $_POST['date_reservation'];
  $heure_debut = $_POST['heure_debut'];
  $heure_fin = $_POST['heure_fin'];

  $sql = $conn -> prepare('INSERT INTO reservation (date_reservation, heure_debut, heure_fin) VALUES (?,?,?)');
  $sql -> bind_param("sss",$date_reservation, $heure_debut, $heure_fin);

  // Exécution de la requête préparée
  $sql -> execute();
}

$sql = "SELECT * FROM nounou";
$result = $conn->query($sql);

$domestique = array();

if ($result->num_rows > 0) 
{
  while ($row = $result->fetch_assoc()) 
  {
    $domestique[] = $row;
  }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $nom_enfant    = $_POST['nom'];
    $prenom_enfant = $_POST['prenom'];
    $info_enfant   = $_POST['info_sur_enfant'];
    $age           = $_POST['age_enfant'];

    $sql_enfant = $conn->prepare('INSERT INTO enfant (nom, prenom, info, age) VALUES (?, ?, ?, ?)');
    
    $sql_enfant->bind_param("ssss", $nom_enfant, $prenom_enfant, $info_enfant, $age);

    $sql_enfant->execute();
}


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon_Agence - Reservation</title>
    <link rel="stylesheet" href="user.css">
</head>
<body>

    <header>
        <h1>Mon Agence</h1>
        <nav>
            <ul>
                <li><a href="acceuil.php">Accueil</a></li>
            </ul>
        </nav>

      <div class="en_tete">
        <br><br><br><br><br><br><br><br>
        <h1>BIENVENUE SUR L'ESPACE CLIENT</h1>
      </div>
    </header>


    <main>

      
        <div class="form">


            <h2>Ce formulaire recevera les besoin specifique de votre enfant</h2>
          

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
            
              <label for="nom_enfant">Le nom de votre enfant:</label>
              <input type="text" name="nom">

              <label for="prenom_enfant">Le prenom de votre enfant:</label>
              <input type="text" name="prenom">

              <label for="age_enfant">l'age de votre enfant:</label>
              <input type="text" name="age">

              <label for="info_sur_enfant">Entrez les besoins de votre enfant:</label>
              <input type="text" name="info_sur_enfant">
              
              <br><br>

              <button type="submit">valider</button>
             
            </form>

        </div>

        <br><br>

        <h2>Reservez la domestique de votre choix</h2>

        <br><br>

        <div class="conteneur_cadre">      


            <?php foreach ($domestique as $nounou):?>


                <div class="cadre">

                    <header>

                        <h2>
                        <?php echo"Nom:    ",$nounou["Nom"]?>
                        <br>
                        <?php echo "Prenom: ",$nounou["Prenom"]?>
                        <br>
                        <?php echo "Numéro: ",$nounou["Numero"]?>
                        <br>
                        <?php echo "Email:  ",$nounou["Email"]?>
                        </h2>

                    </header>


                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">

                        <label for="date_reservation">entrez la date de votre reservation:</label>
                        <input type="date" name="date_reservation" require>

                    
                        <br><br>

                        <label for="heure_debut">heure de debut:</label>
                        <input type="time" name="heure_debut" require>

                        <br><br>

                        <label for="heure_fin">heure de fin:</label>
                        <input type="time" name="heure_fin" require>

                        <br><br>

                        <button type="submit" onclick="reservedomestique()">Reservation</button>

                        <br><br>
                    </form>


                </div>
                
          
            <?php endforeach; ?>
      </div>
    </main>
  


  <script>  
   function reservedomestique() 
        {
            alert("Votre réservation a bien été effectué!");
        } 
  </script>


</body>
</html>