
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'accueil de l'administrateur</title>
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
            margin-left: -60px;
        }

        .pieds {
            margin: 0;
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
            <li><a href="admin.php">Menu</a></li>
            <li><a href="parametre.php">Paramètres</a></li>
            <li><a href="profil.php">Profil</a></li>
            <li><a href="deconnexion.php" onclick="return(confirm('Vous vous déconnectez ?'));"><button type="submit"  class="disconnect">Déconnexion</button></a></li>
        </ul>
    </div>
    <div class="container">
        <a href="javascript:history.go(-1)">RETOUR</a>
        <h1>Bienvenue sur la page d'acceuil <br> ADMINISTRATEUR</h1>
        <ul class="nav-links">
            <li><a href="liste_question.php">Liste des Questions</a></li>
            <li><a href="liste_joueur.php">Liste des Joueurs</a></li>
            <li><a href="ajoute_admin.php">Créer un Administrateur</a></li>
            <li><a href="gere.php">Gerer une Question</a></li>
            <li><a href="tb.php">Tableau de bord</a></li>
        </ul>
        <div class="img_admin"><img src="image/admin.webp" alt=""></div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.nav-links a').on('click', function(e) {
                e.preventDefault();
                const pageUrl = $(this).attr('href');
                window.location.href = pageUrl;
            });
        });
    </script>
    <footer class="footer1">
        <p class="pieds">LesTroisFantastiques  © copyright iam big 2024</p>
</footer>
</body>
</html>
