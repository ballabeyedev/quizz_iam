<?php

require_once("connexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['nom'], $_POST['prenom'], $_POST['login'], $_POST['passwd'], $_POST['confirm_passwd'])) {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $login = $_POST['login'];
        $passwd = $_POST['passwd'];
        $confirm_passwd = $_POST['confirm_passwd'];

        if ($passwd !== $confirm_passwd) {
            echo "Les mots de passe ne correspondent pas.";
        } else {
            $query = $connect->prepare("INSERT INTO joueur (nom_joueur, prenom_joueur, login_joueur, passwd_joueur) VALUES (?, ?, ?, ?)");
            $testquery = $query->execute([$nom, $prenom, $login, $passwd]);

            if ($testquery) {
                header("Location: index.php");
            } else {
                echo "Erreur lors de l'insertion";
            }
        }
    } else {
        echo "Les données nécessaires ne sont pas définies";
    }
}

$query = $connect->query("SELECT * FROM joueur");
$list = $query->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="inscription.css">
    <style>
    .h3 {
        text-decoration: underline;
        margin-left: 450px;
    }
    </style>
</head>

<body>
    <div class="header">
        <img src="image/logo.png" alt="">
    </div>
    <a href="javascript:history.go(-1)">RETOUR</a>
    <hr class="hr">
    <h3 class="h3">S'INSCRIRE COMME JOUEUR </h3>
    <div class="ins"><img src="image/insc.jpg" alt=""></div>
    <form class="login" method="post">
        <input type="text" name="nom" id="nom" placeholder="Nom" required>
        <br>
        <input type="text" name="prenom" id="prenom" placeholder="Prénom" required>
        <br>
        <input type="text" name="login" id="login" placeholder="Adresse mail" required>
        <br>
        <input type="password" name="passwd" id="passwd" placeholder="Mot de Passe" required>
        <br>
        <input type="password" name="confirm_passwd" id="confirm_passwd" placeholder="Confirmer le Mot de Passe"
            required>
        <br>
        <div id="error-message"></div>
        <button type="submit" id="envoyer">S'Inscrire →</button>
    </form>
    <script>
    const form = document.querySelector('.login');
    const nom = document.getElementById('nom');
    const prenom = document.getElementById('prenom');
    const login = document.getElementById('login');
    const passwd = document.getElementById('passwd');
    const confirmPasswd = document.getElementById('confirm_passwd');
    const profils_joueur = document.getElementById('profils_joueur');
    const errorsDiv = document.getElementById('error-message');
    const button = document.getElementById('envoyer');

    form.addEventListener('input', validateForm);

    function resetForm() {
        form.reset();
    }

    function validateForm() {
        errorsDiv.innerHTML = '';
        let hasErrors = false;

        if (nom.value === '') {
            displayError('Le champ nom est obligatoire.');
            hasErrors = true;
        }

        if (prenom.value === '') {
            displayError('Le champ prénom est obligatoire.');
            hasErrors = true;
        }

        if (login.value === '') {
            displayError('Le champ login est obligatoire.');
            hasErrors = true;
        }

        if (passwd.value === '') {
            displayError('Le champ mot de passe est obligatoire.');
            hasErrors = true;
        }

        if (confirmPasswd.value === '') {
            displayError('Le champ de confirmation du mot de passe est obligatoire.');
            hasErrors = true;
        }

        if (passwd.value !== confirmPasswd.value) {
            displayError('Les mots de passe ne correspondent pas.');
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