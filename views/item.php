<?php


if(!isset($_GET['id'])) {
    header('Location: ./404.php');
}
session_start();


$inCart = false;

require __DIR__ . '/header.php';
require __DIR__ . '/db.php';
require __DIR__ . '/../csrf.php';
// require_once '../csrf.php';

if(isset($_POST['cart']) && CSRF::validateToken($_POST['token'])) {
    $_SESSION['cart'][$_POST['id']] = array(
        'id' => $_POST['id'],
        'title' => $_POST['title'],
        'price' => $_POST['price'],
        'description' => $_POST['description'],
        'category' => $_POST['category'],
        'quantity' => $_POST['quantity'],
        'image' => $_POST['image']
    );
    foreach($_SESSION['cart'] as $item) {
        if($item['id'] == $_GET['id']) {
            $inCart = true;
            break;
        }
    }
}





$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$statement = $pdo->prepare("SELECT * FROM produits WHERE id=?");
$statement->execute(array($id));
$statement->execute(array($id));

// Check the count of the fetched data
$count = $statement->rowCount();

// If no data is found (count is zero), redirect to the 404 page
if ($count === 0) {
    // Redirect to the 404 page
    header('Location: ./400.php');
    // Ensure that no other output is sent before the redirect
    exit();
}
$item = $statement->fetchAll(PDO::FETCH_ASSOC);
$images = unserialize($item[0]['images']);

$statement = $pdo->prepare("SELECT * FROM produits WHERE categorie=? ORDER BY rand() LIMIT 4");
$statement->execute(array($item[0]['categorie']));
$relatedItems = $statement->fetchAll(PDO::FETCH_ASSOC);
?>
<section class="single-product">
    <div class="container">
        <div class="row">
			<div class="col-md-6">
				<ol class="breadcrumb">
					<li><a href="./home.php">Accueil</a></li>
					<li><a href="./products.php">Boutique</a></li>
					<li class="active"><?= htmlspecialchars($item[0]['categorie']); ?></li>
				</ol>
			</div>
		</div>
        <div class="row mt-20">
            <div class="col-md-5">
                <div class="single-product-slider">
                    <div id='carousel-custom' class='carousel slide' data-ride='carousel'>
                        <div class='carousel-outer'>
                            <!-- me art lab slider -->
                            <div class='carousel-inner '>
                                <?php if(count($images) > 1): ?>
                                    <div class='item active'>
                                        <img src='../uploads/<?= htmlspecialchars($images[0]) ?>' alt='' data-zoom-image="../uploads/<?= htmlspecialchars($images[0]) ?>" style="width: -webkit-fill-available;"/>
                                    </div>
                                    <?php 
                                        foreach($images as $key=>$image){
                                            if($key == 0) {
                                                continue;
                                            }
                                          echo "<div class='item'>";
                                          echo "<img src='../uploads/" . htmlspecialchars($image) . "' alt='' data-zoom-image='../uploads/" . htmlspecialchars($image) . "' />";
                                          echo "</div>";
                                        }
                                    ?>
                                <?php else: ?>
                                    <div class='item active'>
                                        <img src='../uploads/<?= htmlspecialchars($images[0]) ?>' alt='' data-zoom-image="../uploads/<?= htmlspecialchars($images[0]) ?>" />
                                    </div>  
                                <?php endif ?>

                                
                            </div>
                            
                            <!-- sag sol -->
                            <a class='left carousel-control' href='#carousel-custom' data-slide='prev'>
                                <i class="tf-ion-ios-arrow-left"></i>
                            </a>
                            <a class='right carousel-control' href='#carousel-custom' data-slide='next'>
                                <i class="tf-ion-ios-arrow-right"></i>
                            </a>
                        </div>
                        
                        <!-- thumb -->
                        <ol class='carousel-indicators mCustomScrollbar meartlab'>
                            <?php foreach($images as $image): ?>
                                <li data-target='#carousel-custom' data-slide-to='0' class='active'>
                                    <img src='../uploads/<?= htmlspecialchars($image) ?>' alt='' style="height: 42px;"/>
                                </li>
                            <?php endforeach; ?>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <form action="./item.php?id=<?= htmlspecialchars($item[0]['id']) ?>" method="post">
                    <div class="single-product-details">
                        <h2><?= htmlspecialchars($item[0]['titre']) ?></h2>
                        <?php CSRF::csrfInputField() ?>
                        <input type="text" name="title" value="<?= htmlspecialchars($item[0]['titre']) ?>" hidden>
                        <p class="product-price">DT<?= number_format($item[0]['prix'], 2) ?></p>
                        <input type="text" name="price" value="<?= htmlspecialchars($item[0]['prix']) ?>" hidden>
                        <input type="text" name="image" value="<?= htmlspecialchars(unserialize($item[0]['images'])[0]) ?>" hidden>
                        <p class="product-description mt-20">
                            <?= htmlspecialchars($item[0]['description']) ?>
                            <input type="text" name="description" value="<?= htmlspecialchars($item[0]['description']) ?>" hidden>
                        </p>
                        <div class="product-quantity">
                            <span>Quantity:</span>
                            <div class="product-quantity-slider">
                                <input id="product-quantity" type="number" min=1 value="1" name="quantity">
                            </div>
                        </div>
                        <div class="product-category">
                            <span>Categories:</span>
                            <ul>
                                <li><a href="/products.php?c=<?= htmlspecialchars($item[0]['categorie']) ?>"><?= htmlspecialchars($item[0]['categorie']) ?></a></li>
                                <input type="text" name="category" value="<?= htmlspecialchars($item[0]['categorie']) ?>" hidden>
                            </ul>
                        </div>
                        <input type="text" name="id" value="<?= isset($item[0]['id']) ? htmlspecialchars($item[0]['id']) : '' ?>" hidden>
                        <?php if(!isset($_SESSION['name']) || $_SESSION['name'] == ""): ?>
                            <a href="./login.php" name="cart" class="btn btn-main text-center">Veuillez vous connecter</a>
                        <?php elseif($inCart): ?>
                            <button name="cart" type="submit" class="btn btn-main text-center" disabled>Ajouter au panier</button>
                        <?php elseif(isset($_SESSION['role']) && $_SESSION['role'] == 'investor'): ?>
                            <button name="cart" type="submit" class="btn btn-main text-center" disabled>Désactivé pour les investisseurs</button>
                        <?php else: ?>
                            <button name="cart" type="submit" class="btn btn-main text-center">Ajouter au panier</button>
                        <?php endif ?>



                    </div>
                </form>
            </div>
         </div>
    </div>
</section>
<section class="products related-products section">
	<div class="container">
		<div class="row">
			<div class="title text-center">
				<h2>Related Products</h2>
			</div>
		</div>
		<div class="row">
			<?php foreach($relatedItems as $item): ?>
    			<div class="col-md-3">
    				<div class="product-item">
    					<div class="product-thumb">
    						<img class="img-responsive" src="../uploads/<?= htmlspecialchars(unserialize($item['images'])[0]) ?>" alt="<?= htmlspecialchars($item['titre']) ?>" />
    						<div class="preview-meta">
    							<ul>
    								<li>
    									<span  data-toggle="modal" data-target="#product-modal">
    										<i class="tf-ion-ios-search"></i>
    									</span>
    								</li>
    								<li>
    			                        <a href="#" ><i class="tf-ion-ios-heart"></i></a>
    								</li>
    								<li>
    									<a href="#!"><i class="tf-ion-android-cart"></i></a>
    								</li>
    							</ul>
                          	</div>
    					</div>
    					<div class="product-content">
    						<h4><a href="./item.php?id=<?= htmlspecialchars($item['id']) ?>"><?= htmlspecialchars($item['titre']) ?></a></h4>
    						<p class="price">DT <?= number_format($item['prix'], 2) ?></p>
    					</div>
    				</div>
    			</div>
			<?php endforeach; ?>

		</div>
	</div>
</section>

<?php require __DIR__ . '/footer.php'; ?>

<!-- Bootstrap CSS -->
<link href="./plugins/css/bootstrap.min.css" rel="stylesheet">

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Bootstrap JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
