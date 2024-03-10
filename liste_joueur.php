<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Joueurs</title>
    <style>
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
        .titre{
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
            <li><a href="index.php" onclick="return(confirm('Vous vous déconnectez ?'));"><button type="submit" class="disconnect">Déconnexion</button></a></li>
        </ul>
    </div>
    <div class="titre">
        <h1>Supprimer, BLOQUER OU DEBLOQUER UN JOUEUR !</h1>
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

        $result1 = $conn->query("SELECT COUNT(id_joueur) AS id FROM joueur");
        $joueurRow = $result1->fetch_assoc();
        $total_joueurs = $joueurRow['id'];
        $pages = ceil($total_joueurs / $limit);

        $sql = "SELECT id_joueur, nom_joueur, prenom_joueur, score_joueur FROM joueur LIMIT $start, $limit";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table><tr><th>Nom</th><th>Prénom</th><th>Score</th><th>Actions</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr data-id='" . $row["id_joueur"] . "'><td>" . $row["nom_joueur"] . "</td><td>" . $row["prenom_joueur"] . "</td><td>" . $row["score_joueur"] . "</td><td>
                    <button onclick='supprimerJoueur(" . $row['id_joueur'] . ")'>Supprimer</button>
                    <button onclick='bloquerJoueur(" . $row['id_joueur'] . ")'>Bloquer</button>
                    <button onclick='debloquerJoueur(" . $row['id_joueur'] . ")'>Débloquer</button></td></tr>";
            }
            echo "</table>";
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

    <script>
        function supprimerJoueur(id) {
            if (confirm("Voulez-vous vraiment supprimer ce joueur ?")) {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        location.reload();
                    }
                };
                xhttp.open("GET", "action.php?action=supprimer&id=" + id, true);
                xhttp.send();
            }
        }

        function bloquerJoueur(id) {
            if (confirm("Voulez-vous vraiment bloquer ce joueur ?")) {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        markAsBlocked(id);
                    }
                };
                xhttp.open("GET", "action.php?action=bloquer&id=" + id, true);
                xhttp.send();
            }
        }

        function debloquerJoueur(id) {
            if (confirm("Voulez-vous vraiment débloquer ce joueur ?")) {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        location.reload();
                    }
                };
                xhttp.open("GET", "action.php?action=debloquer&id=" + id, true);
                xhttp.send();
            }
        }

    function markAsBlocked(id) {
        var row = document.querySelector('tr[data-id="' + id + '"]');
        if (row) {
            row.classList.add('blocked');
        }
    }
    </script>
    <footer class="footer1">
        <p class="pieds">LesTroisFantastiques  © copyright iam big 2024</p>
</footer>
</body>
</html>
