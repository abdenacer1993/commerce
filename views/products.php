<?php 

include './header.php';
include '../csrf.php';
include './db.php';

$products;
$searchEmpty = false;
$page = 1;
$results_per_page = 10;
$page_first_result;
$number_of_pages;

$statement = $pdo->prepare("SELECT * FROM categories ORDER BY title");
$statement->execute();
$categories = $statement->fetchAll(PDO::FETCH_ASSOC);

if(!isset($_GET['p'])) {
	$page = 1;
} else {
	$page = filter_input(INPUT_GET, 'p', FILTER_SANITIZE_NUMBER_INT);
}

if(isset($_POST['q']) && isset($_GET['c']) && CSRF::validateToken($_POST['token'])) {
	$query = filter_input(INPUT_POST, 'q');
	$category = filter_input(INPUT_GET, 'c');
	$statement = $pdo->prepare("SELECT * FROM produits WHERE categorie='$category' AND CONCAT(`titre`, `prix`, `description`, `categorie`) LIKE '%$query%'");
	$statement->execute();
	if($statement->rowCount() > 0){
		$products = $statement->fetchAll(PDO::FETCH_ASSOC);
	} else {
		$searchEmpty = true;
	}
} elseif(isset($_POST['q']) && CSRF::validateToken($_POST['token'])) {
	$query = filter_input(INPUT_POST, 'q');
	$statement = $pdo->prepare("SELECT * FROM produits WHERE CONCAT(`titre`, `prix`, `description`, `categorie`) LIKE '%$query%'");
	$statement->execute();
	if($statement->rowCount() > 0){
		$products = $statement->fetchAll(PDO::FETCH_ASSOC);
	} else {
		$searchEmpty = true;
	}
} elseif(isset($_GET['c'])) {
	$page_first_result = ($page - 1) * $results_per_page;
	$statement = $pdo->prepare("SELECT count(*) FROM produits WHERE categorie=?");
	$statement->execute(array(filter_input(INPUT_GET, 'c')));
	$number_of_result = $statement->fetchColumn();
	$number_of_pages = ceil($number_of_result / $results_per_page);

	$statement = $pdo->prepare("SELECT * FROM produits WHERE categorie=? LIMIT $page_first_result, $results_per_page");
	$statement->execute(array(filter_input(INPUT_GET, 'c')));
	if($statement->rowCount() > 0) {
		$products = $statement->fetchAll(PDO::FETCH_ASSOC);
	}
} else {
	$page_first_result = ($page - 1) * $results_per_page;
	$statement = $pdo->prepare("SELECT count(*) FROM produits");
	$statement->execute();
	$number_of_result = $statement->fetchColumn();
	$number_of_pages = ceil($number_of_result / $results_per_page);
	$statement = $pdo->prepare("SELECT * FROM produits LIMIT $page_first_result, $results_per_page");
	$statement->execute();
	if($statement->rowCount() > 0) {
		$products = $statement->fetchAll(PDO::FETCH_ASSOC);
	}
}




?>
<section class="products section">
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<div class="widget product-category">
					<h4 class="widget-title">Categories</h4>
					<div class="panel-group commonAccordion" id="accordion" role="tablist" aria-multiselectable="true">
					  	<div class="panel panel-default">
							<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
								<div class="panel-body">
									<ul>
										<li><a href="./products.php">Tous</a></li>
										<?php foreach($categories as $category): ?>
											<li><a href="./products.php?c=<?= htmlspecialchars($category['title']); ?>"><?= htmlspecialchars($category['title']); ?></a></li>
										<?php endforeach; ?>
									</ul>
								</div>
							</div>
					  	</div>
						<br>
						<?php if(isset($_GET['c'])): ?>
							<form action="./products.php?c=<?= filter_input(INPUT_GET, 'c') ?>" method="post">
								<?php CSRF::csrfInputField() ?>
							    <div class="form-group">
								    <input name="q" type="search" class="form-control" placeholder="Recherche...">
						<?php else: ?>
							<form action="./products.php" method="post">
								<?php CSRF::csrfInputField() ?>
							    <div class="form-group">
								    <input name="q" type="search" class="form-control" placeholder="Recherche...">
						<?php endif ?>
							    </div>
							<div class="text-center">
								<button name="search" type="submit" class="btn btn-main btn-small">Recherche</button>
							</div>
						</form>
					</div>
					
				</div>
			</div>
			<div class="col-md-9">
			<?php
// Suppose que $products est défini et initialisé avant d'inclure products.php

// Inclure d'autres fichiers ou récupération des données des produits depuis la source de données

// Assurez-vous que $products est défini et initialisé
if (isset($products)) {
    ?>
    <div class="row">
        <?php if(!$searchEmpty): ?>
            <?php foreach($products as $product): ?>
                <div class="col-md-4">
                    <div class="product-item">
                        <div class="product-thumb">
                            <!--<span class="bage">Sale</span>-->
                            <img class="img-responsive" src="../uploads/<?= htmlspecialchars(unserialize($product['images'])[0]) ?>" alt="product-img" style="height: 263px;"/>
                        </div>
                        <div class="product-content">
                            <h4><a href="./item.php?id=<?= htmlspecialchars($product['id']) ?>"><?= htmlspecialchars($product['titre']) ?></a></h4>
                            <p class="price">DT <?= number_format($product['prix'], 2) ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-md-6 col-md-offset-3">
                <div class="block text-center">
                    <i class="tf-ion-ios-cart-outline"></i>
                    <h2 class="text-center">No items found.</h2>
                    <a href="./products.php" class="btn btn-main mt-20">Return to shop</a>
                </div>
            </div>
        <?php endif ?>
    </div>
    <?php
} else {
    // Gérer le cas où $products n'est pas défini ou vide
    echo "No products available";
}
?>
		
			</div>
		
		</div>
		<?php if(!isset($_POST['q'])): ?>
			<div class="row">
				<div class="col-sm-12 text-center">
					<?php
						if(isset($_GET['c'])){
							if($page == 1) {
								for($i = $page; $i <= $number_of_pages; $i++) {
									echo '<a href="./products.php?c=' . filter_input(INPUT_GET, 'c') . '&p=' . $i . '">' . $i . '</a>';
									if($i == 3) {
										break;
									}
								}
							} elseif($page == $number_of_pages) {
								if($page - 3 > 0) {
									echo '<a href="./products.php?c=' . filter_input(INPUT_GET, 'c') . '&p=' . $page - 2 . '">' . $page - 2 . ' </a>';
									echo '<a href="./products.php?c=' . filter_input(INPUT_GET, 'c') . '&p=' . $page - 1 . '">  ' . $page - 1 . ' </a>';
									echo '<a href="./products.php?c=' . filter_input(INPUT_GET, 'c') . '&p=' . $page  . '">  ' . $page . '</a>';
								} elseif($page - 2 > 0) {
									echo '<a href="./products.php?c=' . filter_input(INPUT_GET, 'c') . '&p=' . $page - 1 . '">  ' . $page - 1 . ' </a>';
									echo '<a href="./products.php?c=' . filter_input(INPUT_GET, 'c') . '&p=' . $page . '">  ' . $page . ' </a>';
								} else {
									echo '<a href="./products.php?c=' . filter_input(INPUT_GET, 'c') . '&p=' . $page . '">  ' . $page . ' </a>';
								}
							} else {
								echo '<a href="./products.php?c=' . filter_input(INPUT_GET, 'c') . '&p=' . $page - 1 . '">  ' . $page - 1 . ' </a>';
								echo '<a href="./products.php?c=' . filter_input(INPUT_GET, 'c') . '&p=' . $page . '">  ' . $page . ' </a>';
								echo '<a href="./products.php?c=' . filter_input(INPUT_GET, 'c') . '&p=' . $page + 1 . '">  ' . $page + 1 . ' </a>';
							}
						} else {
							if($page == 1) {
								for($i = $page; $i <= $number_of_pages; $i++) {
									echo '<a href="./products.php?p=' . $i . '">' . $i . '</a>';
									if($i == 3) {
										break;
									}
								}
							} elseif($page == $number_of_pages) {
								if($page - 3 > 0) {
									echo '<a href="./products.php?p=' . $page - 2 . '">  ' . $page - 2 . ' </a>';
									echo '<a href="./products.php?p=' . $page - 1 . '">  ' . $page - 1 . ' </a>';
									echo '<a href="./products.php?p=' . $page  . '">  ' . $page . '</a>';
								} elseif($page - 2 > 0) {
									echo '<a href="./products.php?p=' . $page - 1 . '">  ' . $page - 1 . ' </a>';
									echo '<a href="./products.php?p=' . $page . '">  ' . $page . ' </a>';
								} else {
									echo '<a href="./products.php?p=' . $page . '">  ' . $page . ' </a>';
								}
							} else {
								echo '<a href="./products.php?p=' . $page - 1 . '">  ' . $page - 1 . ' </a>';
								echo '<a href="./products.php?p=' . $page . '">' . $page . ' </a>';
								echo '<a href="./products.php?p=' . $page + 1 . '">  ' . $page + 1 . ' </a>';
							}   
						}
					?>
				</div>
			</div>
		<?php endif ?>
	</div>
</section>
<?php require __DIR__ . '/footer.php'; ?>