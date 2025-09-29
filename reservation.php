<?php
require_once 'classes/Database.php';
require_once 'classes/Client.php';
require_once 'classes/Chambre.php';
require_once 'classes/Booking.php';

$message = '';
// Récupération de l'hôtel sélectionné
$hotelId = isset($_GET['hotel_id']) ? intval($_GET['hotel_id']) : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'] ?? '';
    $email = $_POST['email'] ?? '';
    $dateDebut = $_POST['date_debut'] ?? '';
    $dateFin = $_POST['date_fin'] ?? '';
    $hotelId = $_POST['hotel_id'] ?? $hotelId;

    $db = new Database();
    $pdo = $db->getConnection();

    // 1. Enregistre le client (ou récupère son id si déjà existant)
    $stmt = $pdo->prepare('SELECT id FROM client WHERE email = ?');
    $stmt->execute([$email]);
    $clientId = $stmt->fetchColumn();
    if (!$clientId) {
        $stmt = $pdo->prepare('INSERT INTO client (nom, email) VALUES (?, ?)');
        $stmt->execute([$nom, $email]);
        $clientId = $pdo->lastInsertId();
    }

    // 2. Trouve la première chambre disponible de l'hôtel sélectionné
    if ($hotelId) {
        $stmt = $pdo->prepare('SELECT id FROM chambre WHERE hotel_id = ? ORDER BY id ASC');
        $stmt->execute([$hotelId]);
    } else {
        $stmt = $pdo->query('SELECT id FROM chambre ORDER BY id ASC');
    }
    $chambres = $stmt->fetchAll(PDO::FETCH_COLUMN);
    $chambreDisponible = null;
    foreach ($chambres as $chambreId) {
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM booking WHERE chambre_id = ? AND NOT (date_fin <= ? OR date_debut >= ?)');
        $stmt->execute([$chambreId, $dateDebut, $dateFin]);
        $nb = $stmt->fetchColumn();
        if ($nb == 0) {
            $chambreDisponible = $chambreId;
            break;
        }
    }

    if ($chambreDisponible) {
        // 3. Sauvegarde la réservation
        $stmt = $pdo->prepare('INSERT INTO booking (client_id, chambre_id, date_debut, date_fin, date_creation) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$clientId, $chambreDisponible, $dateDebut, $dateFin, date('Y-m-d')]);
        $message = "Réservation confirmée ! Chambre n°$chambreDisponible vous est attribuée.";
    } else {
        $message = "Aucune chambre disponible pour cette période.";
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réserver une chambre</title>
    <link rel="stylesheet" href="styles/reservation.css">
</head>
<body>
            <nav class="menu">
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="hotels.php">Liste des hôtels</a></li>
                <li><a href="reservation.php">Réserver une chambre</a></li>
            </ul>
        </nav>
    <h1>Formulaire de réservation</h1>
    <?php if (!empty($message)) : ?>
        <p style="color: #54665a;font-weight:bold;"> <?= htmlspecialchars($message) ?> </p>
    <?php endif; ?>
    <form method="post" action="reservation.php<?php echo $hotelId ? '?hotel_id=' . $hotelId : ''; ?>">
        <label for="hotel_id">Choisissez un hôtel :</label><br>
        <select name="hotel_id" id="hotel_id" required>
            <option value="">-- Sélectionnez un hôtel --</option>
            <?php
            $db = new Database();
            $pdo = $db->getConnection();
            $stmt = $pdo->query('SELECT id, nom, adresse FROM hotel ORDER BY nom ASC');
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $selected = ($hotelId && $hotelId == $row['id']) ? 'selected' : '';
                echo '<option value="' . $row['id'] . '" ' . $selected . '>' . htmlspecialchars($row['nom']) . ' — ' . htmlspecialchars($row['adresse']) . '</option>';
            }
            ?>
        </select><br><br>
        <label>Nom :</label><br>
        <input type="text" name="nom" required><br>
        <label>Prénom :</label><br>
        <input type="text" name="prenom" required><br>
        <label>Email :</label><br>
        <input type="email" name="email" required><br>
        <label>Date de début :</label><br>
        <input type="date" name="date_debut" required><br>
        <label>Date de fin :</label><br>
        <input type="date" name="date_fin" required><br>
        <button type="submit">Réserver</button>
    </form>
    <footer>
        &copy; <?php echo date('Y'); ?> Réservation Hôtel - Tous droits réservés
    </footer>
</body>
</html>
