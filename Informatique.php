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

$stmtQuestions = $connect->prepare("SELECT * FROM question WHERE theme = :theme");
$stmtQuestions->execute(['theme' => 'informatique']);
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
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
        form { max-width: 600px; margin-top: -550px; background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); margin-left: 150px; }
        p { font-size: 16px; margin-bottom: 10px; }
        label { display: block; margin-bottom: 10px; }
        input[type="radio"] { margin-right: 5px; }
        .prec { background-color: #4caf50; color: #fff; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; }
        .suiv { background-color:rgb(123, 104, 238); color: #fff; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; }
        .soum { background-color:rgb(139, 0, 139); color: #fff; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; }        button:hover { background-color: #45a049; }        button:hover { background-color: #45a049; }
        .score { font-size: 18px; font-weight: bold; margin-top: 20px; }
        .profils img { height: 20px; border: 2px solid black; border-radius: 30px; margin-top: 4px; }
        .profils { margin-left: 900px; }
        .logo { display: flex; align-items: center; margin-bottom: 30px; background-color: #3498db; padding: 10px; width: 180px; height: 600px; }
        .logo img { width: 50px; margin-right: 10px; border-radius: 50%; }
        .logo ul { display: flex; flex-direction: column; margin: 0; padding: 0; }
        .logo li { margin-bottom: 15px; }
        .logo a { text-decoration: none; color: #fff; font-weight: bold; transition: color 0.3s ease; }
        .logo a:hover { color: #f2f2f2; }
        .question { display: none; }
        .question.active { display: block; }
        .div{
            background-color: rgb(47, 79, 79);
            margin-left: 400px;
            margin-right: 100px;
            width: 800px;
            height: 350px;

        }
        .disconnect{
            background-color: rgb(255, 192, 203);
        }
        .footer1 {
            color: red;
            padding: 20px;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
            margin-top: 10px;
            margin-left: -10px;
        }

        .pieds {
            margin: 0;
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
            <li><a href="joueur.php">Menu</a></li>
            <li><a href="parametre.php">Paramètres</a></li>
            <li><a href="#">Profil</a></li>
            <li><a href="index.php" onclick="return(confirm('Vous vous déconnectez ?'));"><button type="submit" class="disconnect">Déconnexion</button></a></li>
        </ul>
    </div>
    <div class="div">

    <form action='Informatique.php' method='post'>
    <a href="javascript:history.go(-1)">RETOUR</a>

        <p>Bienvenue sur la page d'acceuil JOUEUR <br> Veillez repondre a ces question <br> Bonne chance</p>
        <button type="button" onclick="prevQuestion()" class="prec">Précédent</button>
        <button type="button" onclick="nextQuestion()" class="suiv">Suivant</button>
        <button type="submit" class="soum">Soumettre</button>

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
                echo "<p><a href='reponse2.php'>Je veux voir mes reponses correcte et incorrecte !</a>";
            }
            ?>
        </div>
    </form>
    </div>
    <script>
        let currentQuestionIndex = 0;
        const questions = document.querySelectorAll('.question');
        const showQuestion = (index) => {
            questions.forEach((question, i) => {
                if (i === index) question.classList.add('active');
                else question.classList.remove('active');
            });
        };

        const nextQuestion = () => {
            if (currentQuestionIndex < questions.length - 1) {
                currentQuestionIndex++;
                showQuestion(currentQuestionIndex);
            }
        };

        const prevQuestion = () => {
            if (currentQuestionIndex > 0) {
                currentQuestionIndex--;
                showQuestion(currentQuestionIndex);
            }
        };

        document.addEventListener('DOMContentLoaded', () => {
            showQuestion(currentQuestionIndex);
        });
    </script>
    <footer class="footer1">
        <p class="pieds">LesTroisFantastiques  © copyright iam big 2024</p>
    </footer>
</body>
</html>
