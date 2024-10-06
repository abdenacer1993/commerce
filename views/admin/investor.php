<?php 

require __DIR__ . '/header.php';
require __DIR__ . '/../db.php';
require __DIR__ . '/../../csrf.php';

$customers;
$edit = false;

if(isset($_POST['submit']) && CSRF::validateToken($_POST['token'])) {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    if(isset($_POST['nom'])) {
        $statement = $pdo->prepare("UPDATE personnes SET nom=? WHERE id=?");
        $statement->execute(array(filter_input(INPUT_POST, 'nom'), $id));
    }
    if(isset($_POST['prenom'])) {
        $statement = $pdo->prepare("UPDATE personnes SET prenom=? WHERE id=?");
        $statement->execute(array(filter_input(INPUT_POST, 'prenom'), $id));
    }
    if(isset($_POST['telephone'])) {
        $statement = $pdo->prepare("UPDATE personnes SET telephone=? WHERE id=?");
        $statement->execute(array(filter_input(INPUT_POST, 'telephone'), $id));
    }
    if(isset($_POST['addresse'])) {
        $statement = $pdo->prepare("UPDATE personnes SET addresse=? WHERE id=?");
        $statement->execute(array(filter_input(INPUT_POST, 'addresse'), $id));
    }
    if(isset($_POST['email'])) {
        $statement = $pdo->prepare("UPDATE personnes SET email=? WHERE id=?");
        $statement->execute(array(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL), $id));
    }
    if(isset($_POST['mot_passe'])) {
        $statement = $pdo->prepare("UPDATE personnes SET mot_passe=? WHERE id=?");
        $statement->execute(array(password_hash(filter_input(INPUT_POST, 'mot_passe'), PASSWORD_DEFAULT), $id));
    }
}

if(isset($_GET['id'])) {
    $edit = true;
    $statement = $pdo->prepare("SELECT * FROM personnes WHERE id=?");
    $statement->execute(array(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT)));
    if($statement->rowCount() > 0) {
        $customers = $statement->fetchAll(PDO::FETCH_ASSOC);
    }
} else {
    if(isset($_POST['delete']) && CSRF::validateToken($_POST['token'])) {
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $statement = $pdo->prepare("DELETE FROM personnes WHERE id=?");
        $statement->execute(array($id));
    }
    
    $statement = $pdo->prepare("SELECT * FROM personnes where role='investisseur'");
    $statement->execute();
    if($statement->rowCount() > 0) {
        $customers = $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>
<div class="container">
    <div class="page-title">
        <h3>Investisseurs
        <a href="./create-investor.php" class="btn btn-sm btn-outline-primary float-end"><i class="fas fa-plus"></i> Ajouter</a>
        </h3>
    </div>
    <?php if($edit): ?>
        <div class="card">
            <div class="card-header">Modifier l'investisseur'</div>
            <div class="card-body">
                <form accept-charset="utf-8" method="post" action="<?= $_SERVER['REQUEST_URI'] ?>">
                    <?php CSRF::csrfInputField() ?>
                    <div class="row g-2">
                        <div class="mb-3 col-md-4">
                            <input type="text" name="nom" class="form-control" placeholder="Nom" value="<?= $customers[0]['nom'] ?>">
                        </div>
                        <div class="mb-3 col-md-4">
                            <input type="text" name="prenom" class="form-control" placeholder="Prenom" value="<?= $customers[0]['prenom'] ?>">
                        </div>
                        <div class="mb-3 col-md-4">
                            <input type="tel" name="telephone" class="form-control" placeholder="Telephone" value="<?= $customers[0]['telephone'] ?>">
                        </div>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" name="addresse" placeholder="Addressee" value="<?= $customers[0]['addresse'] ?>">
                    </div>
                    <div class="row g-2">
                        <div class="mb-3 col-md-6">
                            <input type="email" class="form-control" name="email" placeholder="Email" value="<?= $customers[0]['email'] ?>">
                        </div>
                        <div class="mb-3 col-md-6">
                            <input type="mot_passe" class="form-control" name="mot_passe" placeholder="Mot de passe ">
                        </div>
                    </div>
                    <input type="text" name="id" value="<?= $customers[0]['id'] ?>" hidden>
                    <button name="submit" type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Sauvegarder</button>
                </form>
            </div>
        </div>
    <?php else: ?>
        <div class="box box-primary">
            <div class="box-body">
                <table width="100%" class="table table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>Nom & prenom</th>
                            <th>Email</th>
                            <th>Telephone</th>
                            <th>Addresse</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($customers)): ?>
                            <?php foreach($customers as $customer): ?>
                                <tr>
                                    <td><?= $customer['prenom'] . ' ' . $customer['nom'] ?></td>
                                    <td><?= $customer['email'] ?></td>
                                    <td><?= $customer['telephone'] ?></td>
                                    <td><?= $customer['addresse'] ?></td>
                                    <td class="text-end">
                                        <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="post">
                                            <?php CSRF::csrfInputField() ?>
                                            <input type="text" name="id" value="<?= $customer['id'] ?>" hidden>
                                            <a href="./customers.php?id=<?= $customer['id']; ?>" class="btn btn-outline-info btn-rounded"><i class="fas fa-pen"></i></a>
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