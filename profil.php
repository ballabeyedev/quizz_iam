<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'accueil de l'administrateur</title>
    <link rel="stylesheet" href="admin.css">
    <style>
        .profil img{
            height: 100px;
            border: 3px solid black;
            border-radius: 50px;
        }
        .profil{
            border: 3px solid black;  
            padding: 10px;
            width: 300px;
            margin-left: 250px;
            margin-top: -560px;
        }
        .profil h3{
            text-decoration: underline;
        }
        .div1 img {
            margin-left: 70px;
        }
        .div1 p {
            margin-left: 80px;
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
        .div2{
            border: 2px solid black;
            width:500px;
            margin-left: 600px;
            margin-top: -250px;
            padding-left: 10px;
        }

        .pieds {
            margin: 0;
        }
        .card {
            max-width: 400px;
            margin: auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        .list-group-item {
            border: none;
            border-bottom: 1px solid #e0e0e0;
        }
        .list-group-item:last-child {
            border-bottom: none;
        }

        .icon-inline {
            width: 24px;
            height: 24px;
            margin-right: 8px;
        }

        .text-secondary {
            color: #6c757d;
        }

        .card {
            padding: 16px;
            background-color: #ffffff;
        }
        .list-group {
            padding: 0;
        }
        .list-group-item:hover {
            background-color: #f8f9fa;
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
            <li><a href="index.php" onclick="return(confirm('Vous vous déconnectez ?'));"><button type="submit"  class="disconnect">Déconnexion</button></a></li>
        </ul>
    </div>
    <div class="profil">
    <a href="javascript:history.go(-1)">RETOUR</a>
        <h3>PROFILS ADMINISTRATEUR</h3>
        <div class="div1">
            <img src="image/balla_admin.jpg">
            <p>Balla BEYE </p>
        </div>
        </div>   
        <div class="div2">
            <hr>
            <pre>NOM COMPLET                    Balla BEYE </pre>
            <hr>
            <pre>EMAIL                          beyeballa04@gmail.com</pre>
            <hr>
            <pre>TELEPHONE                      +221773071639</pre>
            <hr>
            <pre>PROFIL                         Admin</pre>
            <hr>
            <pre>ADRESSE                        Liberte 6 Extension</pre>
        </div>
        <div class="div3">
            <a href="">Watchapp</a>
            <a href=""></a>
        </div>
        
    <footer class="footer1">
        <p class="pieds">LesTroisFantastiques  © copyright iam big 2024</p>
    </footer>
</body>
</html>
