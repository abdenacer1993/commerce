<?php
// Activer l'affichage des erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require __DIR__ . '/header.php';
require __DIR__ . '/../db.php';
require __DIR__ . '/../../csrf.php';

// Function to update a specific field in the contact table
function updateContactField($pdo, $fieldName, $fieldValue) {
    $statement = $pdo->prepare("UPDATE contact SET valeur=? WHERE nom=?");
    $statement->execute([$fieldValue, $fieldName]);
}

// Function to update the privacy policy
function updatePrivacyPolicy($pdo) {
    if (isset($_POST['policy-submit']) && CSRF::validateToken($_POST['token'])) {
        try {
            $statement = $pdo->prepare("UPDATE politique SET politique=? WHERE id=1");
            $statement->execute([filter_input(INPUT_POST, 'policy')]);
        } catch (PDOException $e) {
            echo "Error updating privacy policy: " . $e->getMessage();
        }
    }
}

// Function to update the about section
function updateAboutSection($pdo) {
    if (isset($_POST['about-submit'])) {
        try {
            $statement = $pdo->prepare("UPDATE propos SET propos=? WHERE id=1");
            $statement->execute([filter_input(INPUT_POST, 'about')]);
        } catch (PDOException $e) {
            echo "Error updating about section: " . $e->getMessage();
        }
    }
}

// Function to update contact information
function updateContactInfo($pdo) {
    if (isset($_POST['contact-submit'])) {
        try {
            $contactFields = ['address', 'email', 'phone', 'facebook', 'twitter', 'instagram'];
            foreach ($contactFields as $field) {
                if (isset($_POST[$field])) {
                    updateContactField($pdo, $field, filter_input(INPUT_POST, $field));
                }
            }
        } catch (PDOException $e) {
            echo "Error updating contact information: " . $e->getMessage();
        }
    }
}


// Call the update functions based on the submitted action
updatePrivacyPolicy($pdo);
updateAboutSection($pdo);
updateContactInfo($pdo);

// Fetch data for display
$statement = $pdo->prepare("SELECT * FROM politique");
$statement->execute();
$privacyPolicy = $statement->fetch(PDO::FETCH_ASSOC);

$statement = $pdo->prepare("SELECT * FROM propos");
$statement->execute();
$about = $statement->fetch(PDO::FETCH_ASSOC);

// Fetch contact information
$contactFields = ['address', 'email', 'phone', 'facebook', 'twitter', 'instagram'];
$contactInfo = [];
foreach ($contactFields as $field) {
    $statement = $pdo->prepare("SELECT * FROM contact WHERE nom=?");
    $statement->execute([$field]);
    $contactInfo[$field] = $statement->fetch(PDO::FETCH_ASSOC);
}
?>

<div class="container">
    <div class="page-title">
        <h3>Paramètres</h3>
    </div>
    <div class="box box-primary">
        <div class="box-body">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="general-tab" data-bs-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true">À propos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="system-tab" data-bs-toggle="tab" href="#system" role="tab" aria-controls="system" aria-selected="false">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="attributions-tab" data-bs-toggle="tab" href="#attributions" role="tab" aria-controls="attributions" aria-selected="false">Politique de confidentialité</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade active show" id="general" role="tabpanel" aria-labelledby="general-tab">
                    <div class="col-md-6">
                        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                            <?php CSRF::csrfInputField() ?>
                            <div class="mb-3">
                                <textarea class="form-control" style="resize:none" required rows="20" name="about"><?= $about['propos'] ?></textarea>
                            </div>
                            <div class="mb-3 text-end">
                                <button name="about-submit" class="btn btn-success" type="submit"><i class="fas fa-check"></i> Mise à jour</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="tab-pane fade" id="system" role="tabpanel" aria-labelledby="system-tab">
                    <div class="col-md-6">
                        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                            <?php CSRF::csrfInputField() ?>
                            <div class="mb-3">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-home"></i></span>
                                    <input type="text" name="address" class="form-control" value="<?= $contactInfo['address']['valeur'] ?>">
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon2"><i class="fas fa-envelope"></i></span>
                                    <input type="email" name="email" class="form-control" value="<?= $contactInfo['email']['valeur'] ?>">
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon3"><i class="fas fa-phone"></i></span>
                                    <input type="tel" name="phone" class="form-control" value="<?= $contactInfo['phone']['valeur'] ?>">
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon4"><i class="fab fa-facebook"></i></span>
                                    <input type="text" name="facebook" class="form-control" value="<?= $contactInfo['facebook']['valeur'] ?>">
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon5"><i class="fab fa-twitter"></i></span>
                                    <input type="text" name="twitter" class="form-control" value="<?= $contactInfo['twitter']['valeur'] ?>">
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon6"><i class="fab fa-instagram"></i></span>
                                    <input type="text" name="instagram" class="form-control" value="<?= $contactInfo['instagram']['valeur'] ?>">
                                </div>
                            </div>
                            <div class="mb-3 text-end">
                                <button class="btn btn-success" name="contact-submit" type="submit"><i class="fas fa-check"></i> Mise à jour</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="tab-pane fade" id="attributions" role="tabpanel" aria-labelledby="attributions-tab">
                    <h4 class="mb-0">Mention légale</h4>
                    <p class="text-muted">Copyright (c) <script>document.write(new Date().getFullYear());</script> AlGiNET. All rights reserved.</p>
                    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                        <?php CSRF::csrfInputField() ?>
                        <textarea class="form-control" name="policy" style="resize:none" required rows="20"><?= $privacyPolicy['politique'] ?></textarea>            
                        <div class="mb-3 text-end">
                            <button class="btn btn-success" name="policy-submit" type="submit"><i class="fas fa-check"></i> Mise à jour</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<?php require __DIR__ . '/footer.php'; ?>
