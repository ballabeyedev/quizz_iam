<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les questions</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        table {
            border-collapse: collapse;
            width: 50%;
            margin-left: 400px;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
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

        tr.blocked {
            background-color: #ff9999;
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

        .titre {
            color: blue;
            margin-top: -500px;
            margin-left: 280px;
            text-decoration: underline;
            cursor: pointer;
        }

        .pagination {
            margin-top: 20px;
            margin-left: 550px;
        }

        .pagination a {
            display: inline-block;
            padding: 8px 16px;
            text-decoration: none;
            color: black;
            background-color: #f2f2f2;
            border: 1px solid #ddd;
            margin: 0 4px;
        }

        .pagination a.active {
            background-color: #3498db;
            color: white;
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
            <li><a href="profil.php">Profil</a></li>
            <li>
                <a href="index.php" onclick="return(confirm('Vous vous déconnectez ?'))">
                    <button type="submit" class="disconnect">Déconnexion</button>
                </a>
            </li>
        </ul>
    </div>
    <div class="titre">
        <h1>Masquer ou supprimer une question</h1>
        <a href="javascript:history.go(-1)">RETOUR</a>
    </div>

    <?php
        $servername = "mysql-balla.alwaysdata.net";
        $username = "balla_db_iam";
        $password = "1234567890BALLA";
        $dbname = "balla_db_iam";
  
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("La connexion a échoué : " . $conn->connect_error);
        }

        $limit = 3; 
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 1;
        }
        $start = ($page-1) * $limit;

        $result1 = $conn->query("SELECT COUNT(id_question) AS id FROM question");
        $joueurRow = $result1->fetch_assoc();
        $total_joueurs = $joueurRow['id'];
        $pages = ceil($total_joueurs / $limit);

        $sql = "SELECT id_question, libelle, nombre_point, theme FROM question LIMIT $start, $limit";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table><tr><th>Libelle</th><th>Nombre Point</th><th>Theme</th><th>Actions</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr data-id='" . $row["id_question"] . "'><td>" . $row["libelle"] . "</td><td>" . $row["nombre_point"] . "</td><td>" . $row["theme"] . "</td><td>
                    "; 
                echo "<form method='post'>
                        <button name='btn' value=" .$row['id_question']." >Supprimer</button>
                        <button name='btn1' value=" .$row['id_question']." >Masquer</button>
                     </form>";
            }
            echo "</table>";
            if(isset($_POST)) {
                if(isset($_POST["btn"])){
                    supprimerquestion($_POST["btn"]);
                }
            }
        } else {
            echo "Aucun résultat trouvé.";
        }

        echo "<div class='pagination'>";
        for ($i = 1; $i <= $pages; $i++) {
            echo "<a href='?page=$i'" . ($page == $i ? " class='active'" : "") . ">$i</a>";
        }
        echo "</div>";

        $conn->close();
    ?>
        <?php
            function supprimerquestion($id) {
            $servername = "mysql-balla.alwaysdata.net";
            $username = "balla_db_iam";
            $password = "1234567890BALLA";
            $dbname = "balla_db_iam";
  
            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
            die("La connexion a échoué : " . $conn->connect_error);
            }

            $sql = "DELETE FROM reponses WHERE id_question = $id";
            if (!$conn->query($sql)) {
            echo "Erreur lors de la suppression des réponses: " . $conn->error;
            return; 
            }

            $sql = "DELETE FROM question WHERE id_question = $id";
            if ($conn->query($sql)) {
                echo "Question et réponses associées supprimées avec succès.";
            } else {
                echo "Erreur lors de la suppression de la question: " . $conn->error;
            }

        $conn->close();
        }
        
        ?>
    <footer class="footer1">
        <p class="pieds">LesTroisFantastiques © copyright iam big 2024</p>
    </footer>
</body>
</html>
