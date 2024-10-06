<?php

require __DIR__ . '/header.php';
require __DIR__ . '/../db.php';
require __DIR__ . '/../../csrf.php';

$error = false;

if(isset($_POST['submit']) && CSRF::validateToken($_POST['token'])) {
    $prenom = filter_input(INPUT_POST, 'prenom'); 
    $nom = filter_input(INPUT_POST, 'nom');
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $telephone = filter_input(INPUT_POST, 'telephone');
    $address = filter_input(INPUT_POST, 'addresse');
    $password = password_hash(filter_input(INPUT_POST, 'password'), PASSWORD_DEFAULT);
    $created = time(); // Current timestamp
    $role = "investisseur";
    // Check if email already exists
    $emailCheck = $pdo->prepare("SELECT COUNT(*) FROM personnes WHERE email = ?");
    $emailCheck->execute([$email]);
    $emailExists = $emailCheck->fetchColumn();

    if($emailExists) {
        $error = true; // Set error flag to true if email already exists
    } else {
        $statement = $pdo->prepare("INSERT INTO personnes (nom, prenom, email, telephone, addresse, mot_passe, role, date_creation) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $statement->execute(array($nom, $prenom, $email, $telephone, $address, $password, $role, $created));
        header('Location: ./investor.php');
        exit(); // Ensure script stops executing after redirect
    }
}

?>

<div class="container">
    <div class="row">
        <?php if($error): ?>
            <div class="row mt-30">
                <div class="col-xs-12">
                    <div class="alertPart">
                        <div class="alert alert-danger alert-common" role="alert"><i class="tf-ion-close-circled"></i><span>Échec de l'enregistrement!</span> Email déjà enregistré</div>
                    </div>
                </div>		
            </div>
        <?php endif ?>
        
        <div class="card">
            <div class="card-header">Créer un investisseur</div>
            <div class="card-body">
                <form class="needs-validation" novalidate accept-charset="utf-8" method="post" action="<?= $_SERVER['REQUEST_URI'] ?>">
                    <?php CSRF::csrfInputField() ?>
                    <div class="row g-2">
                        <div class="mb-3 col-md-4">
                            <input type="text" name="nom" class="form-control" placeholder="Nom" required>
                        </div>
                        <div class="mb-3 col-md-4">
                            <input type="text" name="prenom" class="form-control" placeholder="Prenom" required>
                        </div>
                        <div class="mb-3 col-md-4">
                            <input type="tel" name="telephone" class="form-control" placeholder="Telephone" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" name="addresse" placeholder="Addresse" required>
                    </div>
                    <div class="row g-2">
                        <div class="mb-3 col-md-6">
                            <input type="email" class="form-control" name="email" placeholder="Email" required>
                        </div>
                        <div class="mb-3 col-md-6">
                            <input type="password" class="form-control" name="password" placeholder="Mot de passe" required>
                        </div>
                    </div>
                    <button name="submit" type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Sauvegarder</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/footer.php'; ?>
