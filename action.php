<?php
$servername = "mysql-balla.alwaysdata.net";
$username = "balla_db_iam";
$password = "1234567890BALLA";
$dbname = "balla_db_iam";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $id_joueur = $_GET['id'];

    if ($action == 'supprimer') {
        $sql = "DELETE FROM joueur WHERE id_joueur = $id_joueur";

        if ($conn->query($sql) === TRUE) {
            echo "Joueur supprimé avec succès";
        } else {
            echo "Erreur lors de la suppression du joueur : " . $conn->error;
        }
    } elseif ($action == 'bloquer') {
        $sql = "UPDATE joueur SET statut = 'bloque' WHERE id_joueur = $id_joueur";

        if ($conn->query($sql) === TRUE) {
            echo "Joueur bloqué avec succès";
        } else {
            echo "Erreur lors du blocage du joueur : " . $conn->error;
        }
    } elseif ($action == 'debloquer') {
        $sql = "UPDATE joueur SET statut = 'actif' WHERE id_joueur = $id_joueur";

        if ($conn->query($sql) === TRUE) {
            echo "Joueur débloqué avec succès";
        } else {
            echo "Erreur lors du déblocage du joueur : " . $conn->error;
        }
    }
}

$conn->close();
?>
