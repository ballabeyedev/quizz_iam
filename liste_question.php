<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de Questions</title>
    <link rel="stylesheet" href="admin.css">
    <style>
        form {
            background-color: white;
            padding: 20px;
            border-radius: 13px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-left: 200px;
            margin-top: -500px;
            width: 300px;
        }

        label {
            font-size: 16px;
            color: #333;
        }

        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            margin-bottom: 20px;
            border-radius: 4px;
            border: 1px solid #ccc;
            box-sizing: border-box; 
        }

        button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3;
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
        .q2{
            background-color: #14B987;
            width: 600px;
            margin-left: 300px;
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
    <div class="q2">
        <form action="process.php" method="post">
            <a href="javascript:history.go(-1)">RETOUR</a>
            <h1 class="titre">NOMBRES DE QUESTION A VOIR</h1>
            <label for="numQuestions">Nombre de questions :</label>
            <input type="number" name="numQuestions" required>
            <button type="submit">Afficher</button>
        </form>
    </div>
    <footer class="footer1">
        <p class="pieds">LesTroisFantastiques  © copyright iam big 2024</p>
    </footer>
</body>
</html>
