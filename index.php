<?php
session_start();
require_once('connexion.php');
global $connect;

$login = "";

if (isset($_POST['Email']) && isset($_POST["passwd"])) {
    $login = $_POST['Email'];
    $password = $_POST['passwd'];

    $sqlAdmin = "SELECT *, 'admin' as role FROM administrateur WHERE login_admin = ? AND passwd_admin = ?";
    $query = $connect->prepare($sqlAdmin);
    $query->execute([$login, $password]);
    $user = $query->fetch();

    if (!$user) {
        $sqlJoueur = "SELECT *, 'joueur' as role FROM joueur WHERE login_joueur = ? AND passwd_joueur = ?";
        $query = $connect->prepare($sqlJoueur);
        $query->execute([$login, $password]);
        $user = $query->fetch();
    }

    if ($user) {
        $_SESSION['Email'] = $login; 
        $_SESSION['role'] = $user['role'];

        if ($user['role'] === "admin") {
            header("Location: admin.php");
            exit();
        } elseif ($user['role'] === "joueur") {
            header("Location: joueur.php");
            exit();
        }
    } else {
        $error = "Cet utilisateur n'existe pas ou le mot de passe est incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style1.css">
    <link href='https://fonts.googleapis.com/css?family=Oswald:300' rel='stylesheet' type='text/css'>
    <style>
        .error-message {
            color: red;
            margin-top: 5px;
        }
        body{
            background-image: url(image/bc.jpg);
        }
        .logo img{
            height: 200px;
            margin-top: -50px;
        }
        .titre{
            margin-left: 450px;
            margin-top: -80px;
        }
        .Titre .t1{
            margin-left: 80px;
        }
        .login{
            height: 400px;
            margin-top: -150px;
        }
        #myForm{
            padding-top: 50px;
        }
        .Titre{
            margin-top: 5px;
        }
        .Titre .t1{
            font-family: 'Oswald', sans-serif;
        text-transform: uppercase;
        }
        h1{
        font-family: 'Oswald', sans-serif;
        text-transform: uppercase;
        font-size: 64px;
        text-align: center;
        margin-top: -10px;
        }

        #culture-title {
            color: #333; 
            transition: color 1s ease; 
        }
    </style>
    <title>Page Connexion</title>
</head>
<body>
<h1 id="culture-title">Test de culture générale</h1>
    <script src="script.js"></script>
  
    <div class="logo"><img src="image/logo.png" alt="" ></div>
    <div class="login">
        <form action="" method="post"  id="myForm">
            <div class="Titre">
                <p class="t1">BIENVENUE SUR QUIZZ IAM 2023-2024</p>
            </div><br>
            <div class="Email">
                <input type="text" name="Email" id="email" placeholder="Adresse mail" value="<?= $login ?>" required>
            </div>
            <div class="Passwd">
                <input type="password" name="passwd" id="passwd" placeholder="Password" required>
            </div>
            <div class="error-message" id="error-message"><?= isset($error) ? $error : "" ?></div>
            <div>
                <button class="button" id="envoyer" type="submit" name="button">Connexion</button>
                <div class="inscription"><a href="inscription.php">Créer un compte !</a></div>
            </div>
        </form>
    </div>
    <script>
        const form = document.getElementById('myForm');
        const email = document.getElementById('email');
        const passwd = document.getElementById('passwd');
        const errorsDiv = document.getElementById('error-message');
        const button = document.getElementById('envoyer');

        form.addEventListener('input', validateForm);

        function resetForm() {
        form.reset();
        }

        function validateForm() {
        errorsDiv.innerHTML = '';
        let hasErrors = false;

        if (email.value === '') {
            displayError('Le champ email est obligatoire.');
            hasErrors = true;
        }

        if (passwd.value === '') {
            displayError('Le champ mots de passe est obligatoire.');
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
</body>
</html>

