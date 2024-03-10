<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'accueil de l'administrateur</title>
    <link rel="stylesheet" href="admin.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        table {
            width: 50%;
            border-collapse: collapse;
            margin-top: -500px;
            margin-left: 500px;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination a {
            padding: 8px 16px;
            margin: 0 5px;
            text-decoration: none;
            background-color: #4CAF50;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }

        .pagination a:hover {
            background-color: #45a049;
        }
        form{
            margin-left: 600px;
            margin-top: -450px;
        }
        .gere img{
            border: 3px solid black;
            width: 300px;
            margin-left: 220px; 
        }
        .actions-form {
            margin-top: 20px;
        }

        .actions-form form {
            flex-direction: column;
            align-items: center;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .actions-form button {
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .actions-form button:hover {
            background-color: #45a049;
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
        <p>Balla BEYE <img src="image/profils.jpg"></p>
    </div>
    <div class="logo">
        <img src="image/logo.png">
        <ul>
            <li><a href="admin.php">Menu</a></li>
            <li><a href="parametre.php">Paramètres</a></li>
            <li><a href="profils.php">Profil</a></li>
            <li><a href="index.php" onclick="return(confirm('Vous vous déconnectez ?'));"><button type="submit"  class="disconnect">Déconnexion</button></a></li>
        </ul>
    </div>
    <div class="actions-form">
        <form action="" method="post">
        <a href="javascript:history.go(-1)">RETOUR</a>

            <h3>Veillez choisir l'option que vous voulez !</h3>
            <input type="radio" name="action" id="ajouter" value="ajouter" required>
            <label for="ajouter">Ajouter</label><br><br>
            <input type="radio" name="action" id="supprimer" value="supprimer">
            <label for="supprimer">Supprimer</label><br><br>
            <input type="radio" name="action" id="modifier" value="modifier">
            <label for="modifier">Masquer</label><br><br>

            <button type="submit">Valider</button>
        </form>
    </div>
    <?php
        include 'connexion.php';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = isset($_POST['action']) ? $_POST['action'] : '';

            switch ($action) {
                case 'ajouter':
                    header('Location: ajoute_question.php');
                    exit;
                case 'supprimer':
                    header('Location: Mas_Supp.php');
                    break;
                case 'modifier':
                    header('Location: Mas_Supp.php');
                    break;
                default:
                    break;
            }
        }

    ?>
    <footer class="footer1">
        <p class="pieds">LesTroisFantastiques  © copyright iam big 2024</p>
    </footer>

</body>
</html>