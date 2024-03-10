<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des questions avec leurs réponses</title>
    <link rel="stylesheet" href="admin.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .profils p img {
            height: 50px; /* Adjust the height as needed */
            margin-left: 10px; /* Add margin for spacing */
        }

        .logo img {
            height: 30px; /* Adjust the height as needed */
        }

        .logo ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
        }

        .logo li {
            margin-right: 15px; /* Adjust the margin as needed */
        }

        .disconnect {
            padding: 5px 10px;
            background-color: #e74c3c;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }

        .disconnect:hover {
            background-color: #c0392b;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-left: 100px;
        }

        .libelle {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="radio"] {
            margin-right: 5px;
        }

        .btn {
            display: inline-block;
            padding: 8px 12px;
            background-color: #3498db;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            margin-right: 10px;
        }

        .button {
            background-color: #2ecc71;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            margin: 10px;
        }

        .button:hover {
            background-color: #27ae60;
        }

        .tout {
            margin-left: 350px;
            margin-top: -550px;
            background-color: rgba(20, 100, 150);
            width: 500px;
            height: 400px;
            border-radius: 60px;
            overflow: hidden; /* Prevent content overflow */
        }

        .footer1 .pieds {
            margin-top: 70px;
            color: red;
            margin-left: 500px;
        }

        .tout img {
            margin-left: 200px;
            height: 100px;
            border: 3px solid blue;
            border-radius: 10px;
        }

        .tout .tout1 {
            padding-left: 50px;
        }

    </style>
</head>
<body>
<div class="profils">
        <p>Balla BEYE <img src="image/profils.jpg" alt="Profile Image"></p>
    </div>
    <div class="logo">
        <img src="image/logo.png" alt="Logo">
        <ul>
            <li><a href="admin.php">Menu</a></li>
            <li><a href="parametre.php">Paramètres</a></li>
            <li><a href="profil.php">Profil</a></li>
            <li><a href="index.php" onclick="return(confirm('Vous vous déconnectez ?'));"><button type="submit" class="disconnect">Déconnexion</button></a></li>
        </ul>
    </div>

    <div class="tout">
        <a href='javascript:history.go(-1)' class='btn'>RETOUR</a>
        <img src="image/question.jpg" alt="Question Image">
        <div class="tout1">
        <?php
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["numQuestions"])) {
            $numQuestions = $_POST["numQuestions"];
        }
    }

    if (!isset($_SESSION['currentQuestion'])) {
        $_SESSION['currentQuestion'] = 1;
    }

    $servername = "mysql-balla.alwaysdata.net";
    $username = "balla_db_iam";
    $password = "1234567890BALLA";
    $dbname = "balla_db_iam";    
    try {
        $connect = new PDO('mysql:host='.$servername.';dbname='.$dbname, $username, $password,
            array(
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
            )
        );

        $query = "SELECT q.id_question, q.libelle AS question, r.reponse_text AS reponse
                  FROM question q
                  LEFT JOIN reponses r ON q.id_question = r.id_question";
        $result = $connect->query($query);

        $currentQuestionId = null;

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            if ($row['id_question'] !== $currentQuestionId) {
                if ($currentQuestionId !== null) {
                    echo "</ul>"; 
                }

                if ($row['id_question'] == $_SESSION['currentQuestion']) {
                    echo "<h3>" . $row['question'] . "</h3>";
                    echo "<ul>";
                }

                $currentQuestionId = $row['id_question'];
            }

            if ($row['id_question'] == $_SESSION['currentQuestion']) {
                echo "<li><input type='radio' name='reponse_" . $row['id_question'] . "' value='" . $row['reponse'] . "'>" . $row['reponse'] . "</li>";
            }
        }

        // Fermer la dernière liste
        if ($currentQuestionId !== null) {
            echo "</ul>";
        }

        echo "<form method='post' action=''>";
        echo "<input type='hidden' name='numQuestions' value='" . $numQuestions . "'>";
        echo "<input type='hidden' name='currentQuestion' value='" . $_SESSION['currentQuestion'] . "'>";
        echo "<input type='submit' name='prev' value='Précédent'>";
        echo "<input type='submit' name='next' value='Suivant'>";
        echo "</form>";

        if (isset($_POST['prev'])) {
            $_SESSION['currentQuestion'] = max(1, $_SESSION['currentQuestion'] - 1);
        } elseif (isset($_POST['next'])) {
            $_SESSION['currentQuestion'] = min($numQuestions, $_SESSION['currentQuestion'] + 1);
        }
    } catch (PDOException $e) {
        die("Une erreur est survenue lors de la connexion à la Base de données !");
    } 
?>

        </div>
    </div>
</body>
</html>
