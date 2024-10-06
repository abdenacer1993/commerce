<?php

require __DIR__ . '/header.php';
require __DIR__ . '/../db.php';
require __DIR__ . '/../../csrf.php';
require __DIR__ . '/util.php';

if(isset($_POST['submit']) && CSRF::validateToken($_POST['token'])) {
    $title = filter_input(INPUT_POST, 'title');
    $description = filter_input(INPUT_POST, 'description');
    $price = filter_input(INPUT_POST, 'price');
    $category = filter_input(INPUT_POST, 'category');
    $statement = $pdo->prepare("SELECT count(*) FROM categories WHERE title=?");
    $statement->execute(array($category));
    if(!$statement->fetchColumn() > 0) {
        $statement = $pdo->prepare("INSERT INTO categories(title) VALUES (?)");
        // print($statement);die();
        $statement->execute(array($category));
    }
    $paths = serialize(uploadImages());
    $statement = $pdo->prepare("INSERT INTO produits(titre, prix, description, categorie, images) VALUES (?, ?, ?, ?, ?)");
    
    $statement->execute(array($title, $price, $description, $category, $paths));
    // print($statement);die();
    header('Location: ./products.php');
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
                            <label class="form-label">Nom</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Prix</label>
                            <input type="number" name="price" class="form-control" min=0 step=0.01 required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" style="resize:none" required></textarea>
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
            <li><a class="dropdown-item" href="#"><?= $category['title'] ?></a></li>
            <div role="separator" class="dropdown-divider"></div>
        <?php endforeach; ?>
    </ul>
</div>
<input id="category" type="text" name="category" class="form-control" aria-label="Text input with dropdown button" value="<?= isset($items[0]['category']) ? $items[0]['category'] : '' ?>">
</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Images</label>
                            <input class="form-control" name="files[]" type="file" id="formFile1" multiple required>
                            <small class="text-muted">Sélectionnez des images de produits</small>
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
<!-- Example of including jQuery from a CDN -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
   
    // jQuery is assumed to be available for this example
$(document).ready(function() {
    $('.dropdown-item').on('click', function() {
        var selectedCategory = $(this).text(); // Get the text of the selected category
        $('#category').val(selectedCategory); // Set the input field value to the selected category
    });
});

</script>