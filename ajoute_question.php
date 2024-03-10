<?php
$servername = "mysql-balla.alwaysdata.net";
$username = "balla_db_iam";
$password = "1234567890BALLA";
$dbname = "balla_db_iam";
$message = '';

try {
    $connect = new PDO('mysql:host='.$servername.';dbname='.$dbname, $username, $password,
        array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING)
    );
} catch (PDOException $e) {
    die("Une erreur est survenue lors de la connexion à la Base de données !");
}

$showResponseForm = false;
$id_question = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['libelle'])) {
    $libelle = $_POST['libelle'];
    $nombre_point = $_POST['nombre_point'];
    $theme = $_POST['theme'];

    if (!empty($libelle) && !empty($nombre_point) && is_numeric($nombre_point)) {
        $query = "INSERT INTO question (libelle, nombre_point, theme) VALUES (:libelle, :nombre_point, :theme)";
        $stmt = $connect->prepare($query);
        $stmt->bindParam(':libelle', $libelle);
        $stmt->bindParam(':nombre_point', $nombre_point);
        $stmt->bindParam(':theme', $theme);

        if ($stmt->execute()) {
            $message = "Question ajoutée avec succès.";
            $id_question = $connect->lastInsertId();
            $showResponseForm = true;
        } else {
            $message = "Erreur lors de l'ajout de la question.";
        }
    } else {
        $message = "Le libellé et le nombre de points sont obligatoires, et le nombre de points doit être un nombre.";
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_reponses'])) {
    $id_question = $_POST['id_question'];
    $reponses = $_POST['reponses'];
    

    foreach ($reponses as $reponse) {
        $text = $reponse['text'];
        $is_correct = $reponse['is_correct'];
        $query = "INSERT INTO reponses (reponse_text, is_correct, id_question) VALUES (:reponse_text, :is_correct, :id_question)";
        $stmt = $connect->prepare($query);
        $stmt->bindParam(':reponse_text', $text);
        $stmt->bindParam(':is_correct', $is_correct);
        $stmt->bindParam(':id_question', $id_question);
        $stmt->execute();
    }
    $message = "Réponses ajoutées avec succès.";
    $showResponseForm = false;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajout de Question</title>
    <link rel="stylesheet" href="inscription.css">
    <link rel="stylesheet" href="admin.css">
    <style>
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
        .tq{
            margin-top: -520px;
            margin-left: 250px;
        }
        h3{
            margin-top: -240px;
            margin-left:300px;
            text-decoration: underline;
        }
        .login{
            margin-top: 20px;
        }
        .form2 {
    max-width: 600px;
    margin: 20px auto;
    padding: 20px;
    background-color: #f4f7f6;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.form2 div {
    margin-bottom: 15px;
    position: relative;
}

.form2 label {
    display: inline-block;
    margin-bottom: 5px;
}

.form2 input[type="text"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    margin-bottom: 10px;
    resize: vertical;
}

.form2 select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    background-color: white;
    box-sizing: border-box;
    margin-bottom: 10px;
}

.form2 button[type="submit"] {
    background-color: #5cb85c;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.form2 button[type="submit"]:hover {
    background-color: #4cae4c;
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
        <li><a href="deconnexion.php" onclick="return(confirm('Vous vous déconnectez ?'));"><button type="submit" class="disconnect">Déconnexion</button></a></li>
    </ul>
</div>
<div class="tq">
<hr class="hr">
<div class="ins"><img src="image/insc.jpg" alt=""></div>
    <?php if (!$showResponseForm): ?>
    <h3>AJOUTE QUESTION</h3>
    <form id="myform" class="login" method="post">
        <a href="javascript:history.go(-1)">RETOUR</a><br>
        <input type="text" name="libelle" id="libelle" placeholder="Libellé" required>
        <br>
        <input type="text" name="nombre_point" id="nombre_point" placeholder="Nombre de Point" required>
        <br>
        <input type="text" name="theme" id="theme" placeholder="Theme question" required>
        <br>
        <div id="error-message"></div> 
        <button type="submit">Ajouter →</button>
    </form>
    <?php else: ?>
    <h3>Ajouter des réponses pour la question ID <?= htmlspecialchars($id_question) ?></h3>
    <form method="post" class="form2">
        <input type="hidden" name="id_question" value="<?= htmlspecialchars($id_question) ?>">
        <?php for ($i = 1; $i <= 4; $i++): ?>
        <div>
            <label>Réponse <?= $i ?>:</label>
            <input type="text" name="reponses[<?= $i ?>][text]" required>
            <select name="reponses[<?= $i ?>][is_correct]">
                <option value="0">Faux</option>
                <option value="1">Vrai</option>
            </select>
        </div>
        <?php endfor; ?>
        <button type="submit" name="submit_reponses">Ajouter Réponses</button>
    </form>
    <?php endif; ?>
</div>
<script>
            const form = document.getElementById('myform');
            const libelle = document.getElementById('libelle');
            const nombre_point = document.getElementById('nombre_point');
            const errorsDiv = document.getElementById('error-message');
            const button = document.querySelector('button[type="submit"]');

            form.addEventListener('input', validateForm);

            function validateForm() {
                errorsDiv.innerHTML = '';
                let hasErrors = false;

                if (libelle.value === '') {
                    displayError('Le champ libellé est obligatoire.');
                    hasErrors = true;
                }

                if (nombre_point.value === '') {
                    displayError('Le champ nombre de points est obligatoire.');
                    hasErrors = true;
                }
                if (theme.value === '') {
                    displayError('Le champ theme est obligatoire.');
                    hasErrors = true;
                }

                button.disabled = hasErrors;
            }

            function displayError(errorMessage) {
                const errorPara = document.createElement('p');
                errorPara.classList.add('error');
                errorPara.textContent = errorMessage;
                errorsDiv.appendChild(errorPara);
            }
        </script>
<footer class="footer1">
    <p class="pieds">LesTroisFantastiques  © copyright iam big 2024</p>
</footer>
</body>
</html>
