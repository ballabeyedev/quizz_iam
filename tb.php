<?php
    // $servername = "mysql-balla.alwaysdata.net";
    // $username = "balla_db_iam";
    // $password = "1234567890BALLA";
    //  $dbname = "balla_db_iam";

     $servername = "localhost";
     $username = "root";
     $password = "";
      $dbname = "jeu_iam";
    try {
        $connect = new PDO('mysql:host='.$servername.';dbname='.$dbname, $username, $password,
            array(
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
            )
        );
    } catch (PDOException $e) {
        die("Une erreur est survenue lors de la connexion à la Base de données 1 !");
    } 


function getNumberOfPlayers($connect) {
    $query = $connect->query("SELECT COUNT(*) as count FROM joueur");
    $result = $query->fetch(PDO::FETCH_ASSOC);
    return $result['count'];
}

function getNumberOfQuestions($connect) {
    $query = $connect->query("SELECT COUNT(*) as count FROM question");
    $result = $query->fetch(PDO::FETCH_ASSOC);
    return $result['count'];
}

function getNumberOfAdmins($connect) {
    $query = $connect->query("SELECT COUNT(*) as count FROM administrateur");
    $result = $query->fetch(PDO::FETCH_ASSOC);
    return $result['count'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord</title>
    <style>
       .container {
            display: flex;
            justify-content: space-between;
            margin-left: 300px;
            margin-top: -500px;
            width: 600px;
        }

        .box {
            border: 1px solid #000;
            width: 50%; 
            text-align: center;
            margin-right: 30px;
            height: 80px
        }
        .logo {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            background-color: #3498db;
            padding: 10px;
            width: 180px;
            height: 580px;
        }
        .logo img {
            width: 50px;
            margin-right: 10px;
            border-radius: 50%;
        }
        .logo ul {
            display: flex;
            flex-direction: column;
            margin: 0;
            padding: 0;
        }
        .logo li {
            margin-bottom: 15px;
        }
        .logo a {
            text-decoration: none;
            color: #fff;
            font-weight: bold;
            transition: color 0.3s ease;
        }
        .logo a:hover {
            color: #f2f2f2;
        }
        .etc{
            border: 1px solid black;
            background-color: #fff;
            height: 200px;
            margin-left: 250px;
            margin-top: 30px;
            width: 400px;
            border-radius: 10px
        }
        .etc .p{
            padding-left: 70px;
            background-color: rgb(112, 128, 144);
            margin-top: -10px;
            height: 20px
        }
        .etc1{
            border: 1px solid black;
            background-color: #fff;
            height: 200px;
            margin-left: 750px;
            margin-top: -200px;
            width: 200px;
            border-radius: 10px
        }
        .etc1 .p{
            padding-left: 50px;
            background-color: rgb(112, 128, 144);
            margin-top: -10px;
            height: 20px
        }
        .joueur{
            padding-left: 10px;
        }
    </style>
</head>
<body>

    <div class="logo">
        <img src="image/logo.png">
        <ul>
            <li><a href="admin.php">Menu</a></li>
            <li><a href="parametre.php">Paramètres</a></li>
            <li><a href="profil.php">Profil</a></li>
            <li><a href="index.php" onclick="return(confirm('Vous vous déconnectez ?'));"><button type="submit" class="disconnect">Déconnexion</button></a></li>
        </ul>
    </div>
    <div class="container">
        <a href="javascript:history.go(-1)">RETOUR</a><br>
        <div class="box">
            <h3>QUESTIONS</h3>
            <p><?php echo getNumberOfQuestions($connect); ?></p>
        </div>
        <div class="box">
            <h3>ADMINS</h3>
            <p><?php echo getNumberOfAdmins($connect); ?></p>
        </div>
        <div class="box">
            <h3>JOUEURS</h3>
            <p><?php echo getNumberOfPlayers($connect); ?></p>
        </div>
    </div>
    <div class="etc">
    <div class="p">
        <p>EVOLUTION DU TEMPS DE JEU</p>
    </div>
    </div>
<div class="etc1">
    <div class="p">
        <p>TOP SCORES</p>
    </div>
    <div class="tp">
        <?php
        $query = $connect->prepare("SELECT nom_joueur, prenom_joueur, score_joueur FROM joueur WHERE score_joueur > 90");
        $query->execute();

        if ($query) {
            $results = $query->fetchAll(PDO::FETCH_ASSOC);

            foreach ($results as $result) {
                echo '<p class="joueur">' . $result['nom_joueur'] . ' ' . $result['prenom_joueur'] . ' ' . $result['score_joueur'] . '👑' .'</p>';
            }
        } else {
            echo "Erreur lors de la récupération des données.";
        }
        ?>
    </div>
</div>


</body>
</html>

<?php
// ... Fermeture de la connexion à la base de données
$connect = null;
?>

