<?php

require __DIR__ . '/header.php';
require __DIR__ . '/db.php';
require __DIR__ . '/../csrf.php';
require __DIR__ . '/util.php';
// session_start();
$id_investor = $_SESSION['id'];
// print_r($id_investor);die();
$date = date('Y-m-d');
if(isset($_POST['submit']) && CSRF::validateToken($_POST['token'])) {
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING); // Corrected filtering
    
    
    $status ='En attente';
    
    // Corrected image path handling
    $paths = serialize(uploadImages());
    
    $statement = $pdo->prepare("INSERT INTO pub(nom_ste, id_investisseur, dateajout, image,statut) VALUES (?, ?, ?, ?, ?)");
    // print($statement);die();
    $statement->execute(array($title, $id_investor, $date, $paths, $status));
    // Check the count of affected rows
    $count = $statement->rowCount();

    // If no rows were affected (count is zero), redirect to the 400 page
    if ($count === 0) {
        // Redirect to the 400 page
        header('Location: ./400.php');
        // Ensure that no other output is sent before the redirect
        exit();
    }else{
        
        header('Location: ./pub.php');
    }
    
    
}

$statement = $pdo->prepare("SELECT * FROM categories");
$statement->execute();
$categories = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="container">
    <div class="row">
        <div class="card">
            <div class="card-header">Créer un produit</div>
            <div class="card-body">
                <div class="col-md-6">
                    <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="post" enctype="multipart/form-data">
                        <?php CSRF::csrfInputField() ?>
                        <div class="mb-3">
                            <label class="form-label">Nom ste</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        
                        <!-- Add input fields for other form elements as needed -->

                        <div class="mb-3">
                            <label class="form-label">Image</label>
                            <input class="form-control" name="files[]" type="file" id="formFile1" multiple required>
                            <small class="text-muted">Sélectionnez une image de pub</small>
                        </div>
                        <div class="mb-3 text-end">
                            <button name="submit" type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Sauvegarder</button>
                        </div>
                    </form>
                </div>
            </div>
        </div> 
    </div>
</div>

<?php require __DIR__ . '/footer.php'; ?>

