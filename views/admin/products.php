<?php 

require __DIR__ . '/header.php'; 
require __DIR__ . '/../db.php';
require __DIR__ . '/../../csrf.php';
require __DIR__ . '/util.php';

$items;
$categories;
$edit = false;


if(isset($_POST['submit']) && CSRF::validateToken($_POST['token'])) {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    if(isset($_POST['titre'])) {
        $statement = $pdo->prepare("UPDATE produits SET titre=? WHERE id=?");
        $statement->execute(array(filter_input(INPUT_POST, 'titre'), $id));
    }
    if(isset($_POST['prix'])) {
        $statement = $pdo->prepare("UPDATE produits SET prix=? WHERE id=?");
        $statement->execute(array(filter_input(INPUT_POST, 'prix'), $id));
    }
    if(isset($_POST['description'])) {
        $statement = $pdo->prepare("UPDATE produits SET description=? WHERE id=?");
        $statement->execute(array(filter_input(INPUT_POST, 'description'), $id));
    }
    if(isset($_POST['category'])) {
        $statement = $pdo->prepare("SELECT * FROM categories WHERE titre=?");
        $statement->execute(array(filter_input(INPUT_POST, 'category')));
        if(!$statement->rowCount() > 0) {
            $statement = $pdo->prepare("INSERT INTO categories(titre) VALUES (?)");
            $statement->execute(array(filter_input(INPUT_POST, 'category')));
        }
        $statement = $pdo->prepare("UPDATE produits SET categorie=? WHERE id=?");
        $statement->execute(array(filter_input(INPUT_POST, 'category'), $id));
    }
    if(isset($_FILES['files'])) {
        $path = serialize(uploadImages());
        $statement = $pdo->prepare("UPDATE produits SET images=? WHERE id=?");
        $statement->execute(array($path, $id));
    }
}

if(isset($_GET['id'])) {
    $edit = true;
    $statement = $pdo->prepare("SELECT * FROM produits WHERE id=?");
    $statement->execute(array(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT)));
    if($statement->rowCount() > 0) {
        $items = $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    $statement = $pdo->prepare("SELECT * FROM categories");
    $statement->execute();
    $categories = $statement->fetchAll(PDO::FETCH_ASSOC);
} else {
    if(isset($_POST['delete']) ){
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $statement = $pdo->prepare("DELETE FROM produits WHERE id=?");
        $statement->execute(array($id));
    }
    
    $statement = $pdo->prepare("SELECT * FROM produits");
    $statement->execute();
    if($statement->rowCount() > 0) {
        $items = $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}

$statement = $pdo->prepare("SELECT * FROM categories");
$statement->execute();
$categories = $statement->fetchAll(PDO::FETCH_ASSOC);

?>
<div class="container">
    <div class="page-titre">
        <h3>produits
        <a href="./create-product.php" class="btn btn-sm btn-outline-primary float-end"><i class="fas fa-plus"></i> Ajouter</a>
        </h3>
    </div>
    <?php if($edit): ?>
        <div class="card">
            <div class="card-header">Créer un produit</div>
            <div class="card-body">
                <div class="col-md-6">
                    <form action="./products.php" method="post" enctype="multipart/form-data">
                        <?php CSRF::csrfInputField() ?>
                        <div class="mb-3">
                            <label class="form-label">Nom</label>
                            <input type="text" name="name" class="form-control" value="<?= $items[0]['titre'] ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Prix</label>
                            <input type="number" name="prix" class="form-control" value="<?= $items[0]['prix'] ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" style="resize:none"><?= $items[0]['description'] ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="language" class="form-label">Catégorie</label>
                            <div class="input-group mb3">
                        	    <div class="dropdown input-group-prepend">
                            	  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            		Choisir
                            	  </button>
                            	  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            		<?php foreach($categories as $category): ?>
                            		    <li><a class="dropdown-item"><?= $category['titre'] ?></a></li>
                            		    <div role="separator" class="dropdown-divider"></div>
                            		<?php endforeach; ?>
                            	  </ul>
                        	    </div>
                            	<input id="category" type="text" name="category" class="form-control" aria-label="Text input with dropdown button" value="<?= $items[0]['categorie'] ?>">
                        	</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Images</label>
                            <input class="form-control" name="files[]" type="file" id="formFile1" multiple>
                            <small class="text-muted">Sélectionnez des images de produits</small>
                        </div>
                        <div class="mb-3 text-end">
                            <input type="text" name="id" value="<?= $items[0]['id'] ?>" hidden>
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
                            <th>Titre</th>
                            <th>Prix</th>
                            <th>Description</th>
                            <th>Catégorie</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($items)): ?>
                            <?php foreach($items as $item): ?>
                                <tr>
                                    <td><?= $item['titre'] ?></td>
                                    <td>DT <?= number_format($item['prix'], 2) ?></td>
                                    <td><?= $item['description'] ?></td>
                                    <td><?= $item['categorie'] ?></td>
                                    <td class="text-end">
                                        <form action="./products.php" method="post">
                                            <?php CSRF::csrfInputField() ?>
                                            <input type="text" name="id" value="<?= $item['id'] ?>" hidden>
                                            <a href="./products.php?id=<?= $item['id']; ?>" class="btn btn-outline-info btn-rounded"><i class="fas fa-pen"></i></a>
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