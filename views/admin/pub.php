<?php 

require __DIR__ . '/header.php'; 
require __DIR__ . '/../db.php';
require __DIR__ . '/../../csrf.php';
require __DIR__ . '/util.php';

$items;
$categories;
$edit = false;

// $id_investor = $_SESSION['id'];

if(isset($_POST['submit']) && CSRF::validateToken($_POST['token'])) {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    if(isset($_POST['title'])) {
        $statement = $pdo->prepare("UPDATE pub SET nom_ste=? WHERE id=?");
        $statement->execute(array(filter_input(INPUT_POST, 'title'), $id));
    }
    if(isset($_POST['id_investor'])) {
        $statement = $pdo->prepare("UPDATE pub SET id_investisseur=? WHERE id=?");
        $statement->execute(array(filter_input(INPUT_POST, 'id_investor'), $id));
    }
    if(isset($_POST['dateadd'])) {
        $statement = $pdo->prepare("UPDATE pub SET dateajout=? WHERE id=?");
        $statement->execute(array(filter_input(INPUT_POST, 'dateadd'), $id));
    }
    
    if(isset($_FILES['files'])) {
        $path = serialize(uploadImages());
        $statement = $pdo->prepare("UPDATE pub SET image=? WHERE id=?");
        $statement->execute(array($path, $id));
    }
}
// $edit = true;
//     $statement = $pdo->prepare("SELECT * FROM pub WHERE id=?");
//     $statement->execute(array(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT)));
//     if($statement->rowCount() > 0) {
//         $items = $statement->fetchAll(PDO::FETCH_ASSOC);
//     }
if(isset($_POST['accept']) ) {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    // print_r($id);die();
    // Update the statut of the pub entry to "accepted"
    $statement = $pdo->prepare("UPDATE pub SET statut='Accepter' WHERE id=?");
    $statement->execute(array($id));
    // Add any additional actions you need here after accepting the pub entry
    
    // Redirect to the same page
    header("Location: {$_SERVER['PHP_SELF']}");
    exit();
} elseif(isset($_POST['refuse']) ) {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    // Update the statut of the pub entry to "refused"
    $statement = $pdo->prepare("UPDATE pub SET statut='Refuser' WHERE id=?");
    $statement->execute(array($id));
    // Add any additional actions you need here after refusing the pub entry
    
    // Redirect to the same page
    header("Location: {$_SERVER['PHP_SELF']}");
    exit();
} else {
    if(isset($_POST['delete']) ) {
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $statement = $pdo->prepare("DELETE FROM pub WHERE id=?");
        $statement->execute(array($id));
    }
    
    $statement = $pdo->prepare("SELECT * FROM pub");
    $statement->execute();
    if($statement->rowCount() > 0) {
        $items = $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}



?>
<div class="container">
    <div class="page-title">
        <h3>pub
        <a href="./create-pub.php" class="btn btn-sm btn-outline-primary float-end"><i class="fas fa-plus"></i> Ajouter</a>
        </h3>
    </div>
    <?php if($edit): ?>
        <div class="card">
            <div class="card-header">Modifier un pub</div>
            <div class="card-body">
                <div class="col-md-6">
                    <form action="./pub.php" method="post" enctype="multipart/form-data">
                        <?php CSRF::csrfInputField() ?>
                        <div class="mb-3">
                            <label class="form-label">Nom Ste</label>
                            <input type="text" name="title" class="form-control" value="<?= $items[0]['nom_ste'] ?>">
                        </div>
                        
                                                
                        <div class="mb-3">
                            <label class="form-label">Image</label>
                            <input class="form-control" name="files[]" type="file" id="formFile1">
                            <small class="text-muted">Sélectionnez une image de pub</small>
                        </div>
                        <div class="mb-3 text-end">
                            <input type="text" name="id" value="<?= $items[0]['id'] ?>" hidden>
                            <input type="text" name="id_investor" value="<?= $items[0]['id_investor'] ?>" hidden>
                            <input type="text" name="dateadd" value="<?= $items[0]['dateadd'] ?>" hidden>
                            <button name="submit" type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Sauvegarder</button>
                        </div>
                    </form>
                </div>
            </div>
        </div> 
    <?php else: ?>
        <div class="box box-primary">
            <div class="box-body">
                <table width="100%" class="table table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Nom Ste</th>
                            <th>Date ajout</th>
                            <th>Statut</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($items)): ?>
                            <?php foreach($items as $item): ?>
                                <tr>
                                    <td><img src="../../uploads/<?= htmlspecialchars(unserialize($item['image'])[0]) ?>"style="width: 150px;"></td>
                                    
                                    <td><?= $item['nom_ste'] ?></td>
                                    <td><?= $item['dateajout'] ?></td>
                                    <td style="color: <?= $item['statut'] === 'Accepter' ? 'green' : ($item['statut'] === 'En attente' ? 'orange' : 'red') ?>"><?= $item['statut'] ?></td>
                                    <td class="text-end">
                                        <form action="./pub.php" method="post">
                                            <?php CSRF::csrfInputField() ?>
                                            <input type="text" name="id" value="<?= $item['id'] ?>" hidden>
                                            <button name="accept" type="submit" class="btn btn-outline-success btn-rounded"><i class="fas fa-check"></i> Accept</button>

                                            <button name="refuse" type="submit" class="btn btn-outline-danger btn-rounded"><i class="fas fa-times"></i> Refuse</button>

                                            <button name="delete" type="submit" class="btn btn-outline-danger btn-rounded"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif ?>
</div>

<?php require __DIR__ . '/footer.php'; ?>
<script>
    $('.dropdown-item').click(function() {
        $('#category').val($(this).text())
    })
</script>