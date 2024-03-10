<?php
    ob_start();
    session_start();

    $servername = " mysql-balla.alwaysdata.net";
    $username = "balla_db_iam";
    $password = "1234567890BALLA";
    $dbname = "balla_db_iam";


    try {
        $connect = new PDO('mysql:host=' . $dbhost . ';dbname=' . $dbname, $dbuser, $dbpswd, array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
        ));
    } catch (PDOException $e) {
        die("An error occurred while connecting to the database: " . $e->getMessage());
    }

    function getCorrectAnswersForQuestion($questionId, $connect) {
        $stmtCorrectAnswers = $connect->prepare("SELECT * FROM reponses WHERE id_question = :questionId AND is_correct = 1");
        $stmtCorrectAnswers->bindParam(':questionId', $questionId, PDO::PARAM_INT);
        $stmtCorrectAnswers->execute();
        return $stmtCorrectAnswers->fetchAll(PDO::FETCH_ASSOC);
    }

    function getAnswersForQuestion($questionId, $connect) {
        $stmtAnswers = $connect->prepare("SELECT * FROM reponses WHERE id_question = :questionId");
        $stmtAnswers->bindParam(':questionId', $questionId, PDO::PARAM_INT);
        $stmtAnswers->execute();
        return $stmtAnswers->fetchAll(PDO::FETCH_ASSOC);
    }

    $questions = [];
    $score = 0;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['answers']) && is_array($_POST['answers'])) {
            foreach ($_POST['answers'] as $questionId => $userAnswer) {
                $correctAnswers = getCorrectAnswersForQuestion($questionId, $connect);
                foreach ($correctAnswers as $correctAnswer) {
                    if ($userAnswer == $correctAnswer['id_reponse']) {
                        $score += 4;
                        break;
                    }
                }
            }
            $score = min($score, 20);
        }
        
    }

    $stmtQuestions = $connect->query("SELECT * FROM question");
    $questions = $stmtQuestions->fetchAll(PDO::FETCH_ASSOC);
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
            height: 500px;
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

        .question {
            display: none;
        }

        .question.active {
            display: block;
        }

        .result-container {
            display: none;
        }

        .result-container p {
            font-size: 18px;
            font-weight: bold;
            margin-top: 20px;
        }

        .question-result {
            margin-top: 10px;
        }

        .question-result label {
            display: block;
            margin-bottom: 5px;
        }

        .correct {
            color: green;
        }

        .incorrect {
            color: red;
        }
    </style>
</head>
<body>
    <div class="profils">
        <a href="index.php">logout → </a>
    </div>
    <div class="logo">
        <img src="image/logo.png">
        <ul>
            <li><a href="ACCEUIL">Accueil</a></li>
            <li><a href="MENU">Menu</a></li>
            <li><a href="PARAMETRES">Paramètres</a></li>
            <li><a href="PROFIL">Profil</a></li>
            <li><a href="index.php" onclick="return(confirm('Vous vous déconnectez ?'));"><button type="submit"
                        class="disconnect">Déconnexion</button></a></li>
        </ul>
    </div>

    <form action='joueur.php' method='post'>
        <p>Bienvenue sur la page d'acceuil JOUEUR <br> Veillez repondre a ces question <br> Bonne chance</p>
        <button type="button" onclick="prevQuestion()">Précédent</button>
        <button type="button" onclick="nextQuestion()">Suivant</button>
        <button type="submit">Soumettre</button>

        <div class="questions-container">
            <?php
            foreach ($questions as $index => $question) {
                $class = ($index === 0) ? 'question active' : 'question';
                echo "<div class='$class'>";
                echo "<p>" . $question['libelle'] . "</p>";

                $answers = getAnswersForQuestion($question['id_question'], $connect);

                foreach ($answers as $answer) {
                    echo "<label>";
                    echo "<input type='radio' name='answers[" . $question['id_question'] . "]' value='" . $answer['id_reponse'] . "'>";
                    echo $answer['reponse_text'];
                    echo "</label>";
                }

                echo "</div>";
            }
            ?>
        </div>

        <div>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                echo "<p>Votre score est: " . $score . "/20</p>";
                echo "<p>Voulez-vous rejouer? <a href='joueur.php'>Oui</a>? <a href='index.php'>Non</a></p>";
                echo "<p><a href='reponse.php'>Je veux voir mes reponses correcte et incorrecte !</a>";
            }
            ?>
        </div>

    </form>
    <script>
        function nextQuestion() {
            var currentQuestion = document.querySelector('.question.active');
            var nextQuestion = currentQuestion.nextElementSibling;

            if (nextQuestion) {
                currentQuestion.classList.remove('active');
                nextQuestion.classList.add('active');
            }
        }

        function prevQuestion() {
            var currentQuestion = document.querySelector('.question.active');
            var prevQuestion = currentQuestion.previousElementSibling;

            if (prevQuestion) {
                currentQuestion.classList.remove('active');
                prevQuestion.classList.add('active');
            }
        }
    </script>
</body>
</html>
