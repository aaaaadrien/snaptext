<?php
require '../includes/init.php'; // Inclusion du fichier de connexion à la base de données

// Initialiser les variables
$success_message = '';
$error_message = '';

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Remplacer les sauts de ligne par <br>
    $text_content = htmlspecialchars($_POST['text_content']);
    $expiration_days = (int) $_POST['expiration_days']; // Durée en jours
    $max_views = (int) $_POST['max_views']; // Nombre de vues maximum

    // Générer un hash unique pour le lien
    $link_hash = bin2hex(random_bytes(16));

    // Calculer la date d'expiration
    $expiration_date = new DateTime();
    $expiration_date->modify("+$expiration_days days");

    // Insérer le texte dans la base de données
    $pdo = getDBConnection();
    $stmt = $pdo->prepare("INSERT INTO texts (text_content, link_hash, expiration_date, max_views) VALUES (?, ?, ?, ?)");
    $stmt->execute([$text_content, $link_hash, $expiration_date->format('Y-m-d H:i:s'), $max_views]);

    // Générer le lien
    $link = "http://" . $_SERVER['HTTP_HOST'] . "/view.php?link=$link_hash";

    $success_message = "Votre texte a été enregistré. Voici le lien : <a href='$link' target='_blank'>$link</a>";

    // Supprimer les messages qui ont expiré
    $stmt = $pdo->prepare("DELETE FROM texts WHERE expiration_date < NOW() OR max_views <= 0");
    $stmt->execute();
}
?>

<?php include '../includes/header.php'; ?> <!-- Inclusion de l'en-tête -->
<div class="container">
<h2><?php echo $app_title; ?></h2>
    
    <form action="" method="post">
        <div>
            <label for="text_content">Texte à partager :</label>
            <textarea name="text_content" id="text_content" rows="5" required></textarea>
        </div>
        <div>
            <label for="expiration_days">Durée de validité (en jours) :</label>
	    <input type="number" name="expiration_days" id="expiration_days" value="<?php echo $def_days; ?>" required>
        </div>
        <div>
            <label for="max_views">Nombre maximum de vues :</label>
	    <input type="number" name="max_views" id="max_views" value="<?php echo $def_views; ?>" required>
        </div>
        <div>
            <button type="submit">Envoyer</button>
        </div>
    </form>

    <?php if ($success_message): ?>
        <div class="success-message">
            <?php echo $success_message; ?>
        </div>
        <button onclick="copyToClipboard('<?php echo $link; ?>')">Copier le lien</button>
    <?php endif; ?>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        alert('Lien copié dans le presse-papiers !');
    }).catch(err => {
        console.error('Erreur lors de la copie : ', err);
    });
}
</script>

<?php include '../includes/footer.php'; ?> <!-- Inclusion du pied de page -->

