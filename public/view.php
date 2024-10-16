<?php
require '../includes/init.php'; // Inclusion du fichier de connexion à la base de données

// Récupération du lien
$link_hash = $_GET['link'] ?? null;

if ($link_hash) {
    // Vérifier si le lien existe dans la base de données
    $pdo = getDBConnection();
    $stmt = $pdo->prepare("SELECT * FROM texts WHERE link_hash = ? AND expiration_date > NOW()");
    $stmt->execute([$link_hash]);
    $text = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($text) {
        // Vérifier le nombre de vues restantes
        if ($text['max_views'] > 0) {
            // Décrémenter le nombre de vues
            $stmt = $pdo->prepare("UPDATE texts SET max_views = max_views - 1 WHERE link_hash = ?");
            $stmt->execute([$link_hash]);

            // Afficher le texte
            $text_content = nl2br($text['text_content']);
        } else {
            $error_message = "Ce lien a expiré ou a atteint le nombre maximum de vues.";
        }
    } else {
        $error_message = "Ce lien a expiré ou n'existe pas.";
    }
} else {
    $error_message = "Aucun lien spécifié.";
}
?>

<?php include '../includes/header.php'; ?> <!-- Inclusion de l'en-tête -->
<div class="container">
    <h2><?php echo $view_title; ?></h2>
    
    <?php if (isset($error_message)): ?>
        <div class="error-message">
            <?php echo $error_message; ?>
        </div>
    <?php elseif (isset($text_content)): ?>
        <div class="text-content">
            <p><?php echo $text_content; ?></p> <!-- Les sauts de ligne seront présents -->
        </div>
    <?php endif; ?>
</div>
<?php include '../includes/footer.php'; ?> <!-- Inclusion du pied de page -->

