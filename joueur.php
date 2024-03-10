
<?php
ob_start();
session_start();
$servername = "mysql-balla.alwaysdata.net";
$username = "balla_db_iam";
$password = "1234567890BALLA";
$dbname = "balla_db_iam";
try {
    $connect = new PDO('mysql:host=' . $servername . ';dbname=' . $dbname, $username, $password, array(
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
    ));
} catch (PDOException $e) {
    die("An error occurred while connecting to the database: " . $e->getMessage());
}
$themes = array();
try {
    $sql = "SELECT DISTINCT theme FROM question ORDER BY theme ASC";
    $stmt = $connect->prepare($sql);
    $stmt->execute();
    $themes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur lors de la récupération des thèmes: " . $e->getMessage());
}
ob_end_flush();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre titre</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        form {
            max-width: 600px;
            margin-top: -500px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-left: 400px;
        }

        p {
            font-size: 16px;
            margin-bottom: 10px;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="radio"] {
            margin-right: 5px;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
        }

        .score {
            font-size: 18px;
            font-weight: bold;
            margin-top: 20px;
        }

        .profils img {
            height: 20px;
            border: 2px solid black;
            border-radius: 30px;
            margin-top: 4px;
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
        .search-container {
            display: flex;
            align-items: center;
            margin-top: -110px;
            width:50%;
            margin-left: -80px;
        }
        #searchInput {
            padding: 10px;
            flex: 1;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button img {
            width: 20px; 
        }
        .search-bar{
            margin-left: -200px;
        }
        .titres{
            margin-left: 280px;
            margin-top: -30px;
        }
        #suggestions{
            color: red;
        }
        .acc {
            text-align: center;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 2px solid #3498db;
            border-radius: 10px;
            background-color: #ecf0f1;
            font-family: 'Arial', sans-serif;
            width: 2000px;
            margin-left: 100px;
            margin-top: 20px;
        }

        .acc h1 {
            color: #e74c3c;
        }

        .acc p {
            color: #34495e;
        }

        .acc img {
            max-width: 100%;
            height: auto;
            border-radius: 50%;
            margin-bottom: 15px;
        }
        .footer1 {
            color: red;
            padding: 20px;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
            margin-top: 10px;
            margin-left: -190px;
        }

        .pieds {
            margin: 0;
        }
        .div {
            background-color: rgb(255, 228, 196);
            width: 80%;
            margin-left: 250px;
            animation: changeColor 2s infinite alternate; 
        }

        @keyframes changeColor {
            0% {
                background-color: rgb(255, 228, 196); 
            }
            50% {
                background-color: rgb(255, 192, 203); 
            }
            100% {
                background-color: rgb(255, 228, 196);
            }
        }
    </style>
</head>
<body>
    <div class="logo">
        <img src="image/logo.png">
        <ul>
            <li><a href="joueur.php">Menu</a></li>
            <li><a href="parametre.php">Paramètres</a></li>
            <li><a href="#">Profil</a></li>
            <li><a href="index.php" onclick="return(confirm('Vous vous déconnectez ?'));"><button type="submit" class="disconnect">Déconnexion</button></a></li>
        </ul>
    </div>
    <div class="div">
        <div class="large">
            <div class="search-bar">
                <form id="searchForm">
                    <div class="search-container">
                        <select id="searchSelect">
                            <option value="" disabled selected>Choisir un thème...</option>
                            <?php foreach ($themes as $theme): ?>
                                <option value="<?php echo $theme['theme']; ?>"><?php echo $theme['theme']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button id="searchButton" type="button">
                            <img src="image/rechercher.jpg" alt="Valider">
                        </button>
                    </div>
                </form>
                <div id="suggestions" style="display:none;"></div>
            </div>
            <h3 class="titres">BIENVENUE SUR LA PAGE D'ACCEUIL JOUEUR</h3>
            <div class="acc">
                <a href="javascript:history.go(-1)">RETOUR</a>
                <h1>🎉 Bienvenue sur QUIZZ IAM! 🎉</h1>
                <p>Salut, aventurier du savoir ! Tu es sur le point d'embarquer dans une quête épique à travers le monde fascinant du savoir. Prépare-toi à tester tes connaissances, à défier tes amis et à apprendre de manière ludique et captivante.</p>
                <p>🚀 Voici ce qui t'attend : 🚀</p>
                <ul>
                    <li>Des milliers de questions dans une multitude de catégories. Que tu sois un maestro du football, un érudit de l'education, un amoureux des dessins annime ou un as des sciences, il y a toujours quelque chose de nouveau à découvrir.</li>
                    <li>Des défis quotidiens pour aiguiser ton esprit et te comparer aux autres joueurs.</li>
                    <li>Des classements pour voir comment tu te mesures face aux autres quizzers de la communauté. Peux-tu atteindre le sommet?</li>
                </ul>
        </div>
    </div>
    <script>
        document.getElementById('searchButton').addEventListener('click', function() {
            var selectedTheme = document.getElementById('searchSelect').value;
            if (selectedTheme) {
                window.location.href = selectedTheme + '.php';
            }
        });
    </script>
    <footer class="footer1">
        <p class="pieds">LesTroisFantastiques  © copyright iam big 2024</p>
    </footer>
</body>
</html>
