<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des hôtels</title>
    <link rel="stylesheet" href="styles/hotels.css">
</head>
<body>
        <nav class="menu">
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="hotels.php">Liste des hôtels</a></li>
                <li><a href="reservation.php">Réserver une chambre</a></li>
            </ul>
        </nav>
    <div class="hotels-titre">
            <h1 class="hotels-titre-h1">Liste des hôtels</h1>
    </div>
    <?php
    require_once 'classes/Database.php';
    $db = new Database();
    $pdo = $db->getConnection();
    $stmt = $pdo->query('SELECT nom, adresse FROM hotel');
    $hotels = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($hotels) > 0) {
            echo '<ul class="hotels-list">';
        $stmtId = $pdo->query('SELECT id FROM hotel ORDER BY id ASC');
        $ids = $stmtId->fetchAll(PDO::FETCH_COLUMN);
        foreach ($hotels as $i => $hotel) {
            $hotelId = $ids[$i];
            echo '<li><strong>' . htmlspecialchars($hotel['nom']) . '</strong> — ' . htmlspecialchars($hotel['adresse']) .
                ' <a href="reservation.php?hotel_id=' . $hotelId . '">Réserver</a></li>';
        }
        echo '</ul>';
    } else {
        echo '<p>Aucun hôtel enregistré.</p>';
    }
    ?>
    <footer>
        &copy; <?php echo date('Y'); ?> Réservation Hôtel - Tous droits réservés
    </footer>
</body>
</html>
