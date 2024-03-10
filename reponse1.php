<?php
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
        die("Une erreur s'est produite lors de la connexion à la base de données 2: " . $e->getMessage());
    }

    $selectedTheme = $_SESSION['selected_theme'] ?? null;

    $stmtQuestions = $selectedTheme
        ? $connect->prepare("SELECT * FROM question WHERE theme = :selectedTheme")
        : $connect->query("SELECT * FROM question");

    if ($selectedTheme) {
        $stmtQuestions->bindParam(':selectedTheme', $selectedTheme, PDO::PARAM_STR);
    }

    $stmtQuestions->execute();
    $questions = $stmtQuestions->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réponses</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin-top: -400px;
            color: #3498db;
        }

        div {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: -290px;
        }

        p {
            font-size: 16px;
            margin-bottom: 10px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 4px;
        }

        input[type="radio"] {
            margin-right: 5px;
        }

        .correct {
            background-color: #c8e6c9; 
        }

        .incorrect {
            background-color: #ffcdd2;
        }

        .profils img {
            height: 20px;
            border: 2px solid black;
            border-radius: 30px;
            margin-top: 4px;
        }

        .profils {
            margin-left: 900px;
        }

        .logo {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            background-color: #3498db;
            padding: 10px;
            width: 180px;
            height: 580px;
            margin-left: 0px;
            margin-top: 200px;
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

        .navigation-buttons {
            margin-top: 10px;
            margin-left: 500px;
            width:90px;
        }
        .question-container{
            background-color: #5F9EA0;

        }
        .footer1 {
            color: red;
            padding: 20px;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
            margin-top: -50px;
            margin-left: -10px;
        }    
    </style>
</head>
<body>
    <div class="profils">
        <p>Balla BEYE <img src="image/profils.jpg"></p>
    </div>
    <div class="logo">
        <img src="image/logo.png">
        <ul>
            <li><a href="joueur.php">Menu</a></li>
            <li><a href="parametre.php">Paramètres</a></li>
            <li><a href="#">Profil</a></li>
            <li><a href="index.php" onclick="return(confirm('Vous vous déconnectez ?'));"><button type="submit" class="disconnect">Déconnexion</button></a></li>
        </ul>
    </div>
    <div class="question-container">
        <?php
        foreach ($questions as $index => $question) {
            if ($question['theme'] === 'football') {
                echo "<div class='question' id='question-$index'>";
                echo "<p>" . $question['libelle'] . "</p>";

                $stmtCorrectAnswer = $connect->prepare("SELECT * FROM reponses WHERE id_question = :questionId AND is_correct = 1");
                $stmtCorrectAnswer->bindParam(':questionId', $question['id_question'], PDO::PARAM_INT);
                $stmtCorrectAnswer->execute();
                $correctAnswer = $stmtCorrectAnswer->fetch(PDO::FETCH_ASSOC);

                $stmtIncorrectAnswers = $connect->prepare("SELECT * FROM reponses WHERE id_question = :questionId AND is_correct = 0");
                $stmtIncorrectAnswers->bindParam(':questionId', $question['id_question'], PDO::PARAM_INT);
                $stmtIncorrectAnswers->execute();
                $incorrectAnswers = $stmtIncorrectAnswers->fetchAll(PDO::FETCH_ASSOC);

                if ($correctAnswer) {
                    echo"<a href='javascript:history.go(-1)'>RETOUR</a>";
                    echo"<br>";
                    echo "<label class='correct'>";
                    echo "<input type='radio' value='" . $correctAnswer['id_reponse'] . "' disabled>";
                    echo $correctAnswer['reponse_text'];
                    echo "</label>";
                } else {
                    echo "<p>Erreur fetching data for question ID: " . $question['id_question'] . "</p>";
                }

                foreach ($incorrectAnswers as $incorrectAnswer) {
                    echo "<label class='incorrect'>";
                    echo "<input type='radio' value='" . $incorrectAnswer['id_reponse'] . "' disabled>";
                    echo $incorrectAnswer['reponse_text'];
                    echo "</label>";
                }

                echo "</div>";
            }
        }
        ?>
    </div>
    <div class="navigation-buttons">
        <button onclick="showPreviousQuestion()"> ←</button>
        <button onclick="showNextQuestion()">&#x2794</button>
    </div>
    <script>
        let currentQuestion = 0;
        const questions = document.querySelectorAll('.question');

        function showQuestion(index) {
            questions.forEach((question, i) => {
                question.style.display = i === index ? 'block' : 'none';
            });
        }

        function showNextQuestion() {
            if (currentQuestion < questions.length - 1) {
                currentQuestion++;
                showQuestion(currentQuestion);
            }
        }

        function showPreviousQuestion() {
            if (currentQuestion > 0) {
                currentQuestion--;
                showQuestion(currentQuestion);
            }
        }

        showQuestion(currentQuestion);
    </script>
    <footer class="footer1">
        <p class="pieds">LesTroisFantastiques  © copyright iam big 2024</p>
    </footer>
</body>
</html>
