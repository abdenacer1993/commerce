<?php 

require __DIR__ . '/header.php'; 
require __DIR__ . '/db.php';

$items;
$statement = $pdo->prepare("SELECT * FROM produits ORDER BY rand() LIMIT 9");
$statement->execute();
if($statement->rowCount() > 0) {
    $items = $statement->fetchAll(PDO::FETCH_ASSOC);
}

$pubs = $pdo->prepare("SELECT * FROM pub where statut='Accepter' ORDER BY rand() LIMIT 9");
$pubs->execute();
if($statement->rowCount() > 0) {
    $pub = $pubs->fetchAll(PDO::FETCH_ASSOC);
	// print_r($pub);die();
}

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
<section class="products section bg-gray"style="padding:0px">
<img id="image" src="./images/cov/1.jpg" alt="" style="width: -webkit-fill-available;">
	<div class="container">
       
            
        
		<div class="row">
			<div class="title text-center">
				<h2>Que voudriez-vous aujourd’hui ?</h2>
			</div>
		</div>
		<div class="row">
		    <?php if(isset($items)): ?>
    			<?php foreach($items as $item): ?>
                    <div class="col-md-4">
                        <div class="product-item">
                            <div class="product-thumb">
							<?php
							if (!empty(unserialize($item['images']))) {
								$images = unserialize($item['images']);
								// print_r($images);die() ;
								if (!empty($images[0])) {
							?>
									<img class="img-responsive" src="../uploads/<?= htmlspecialchars($images[0]) ?>" alt="<?= htmlspecialchars($item['titre']) ?>" style="height:407px"/>
							<?php
								}
							}
							?>

                            </div>
                            <div class="product-content">
                                <h4><a href="item.php?id=<?= htmlspecialchars($item['id']) ?>"><?= htmlspecialchars($item['titre']) ?></a></h4>
                                <p class="price">DT <?= number_format($item['prix'], 2) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif ?>

		</div>
	</div>
</section>

<section class="call-to-action bg-gray section" style="padding :20px 0" >
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="owl-carousel owl-theme" id="image-carousel" style="display: flex;text-align: center">
                    <?php 
                        
                        foreach ($pub as $key => $item) :
                            
                            $images = unserialize($item['image']);
                            $first_image = reset($images);
                    ?>
                        <div class="item"style="width:180px;text-align: left">
                            <img src="../uploads/<?= $first_image; ?>" alt="" style="max-height: 120px;">
                        </div>
                    <?php 
                        
                        endforeach; 
                    ?>
                </div>
            </div>
        </div> <!-- End row -->
    </div> <!-- End container -->
</section> <!-- End section -->


<!--
Start Call To Action
==================================== -->
<section class="call-to-action bg-gray section">
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center">
				<div class="title">
					<h2>S'INSCRIRE À LA NEWSLETTER</h2>
				</div>
				<div class="col-lg-6 col-md-offset-3">
				    <div class="input-group subscription-form">
				      <input type="text" class="form-control" placeholder="Enter Your Email Address">
				      <span class="input-group-btn">
				        <button class="btn btn-main" type="button">Abonnez-vous maintenant!</button>
				      </span>
				    </div><!-- /input-group -->
			  </div><!-- /.col-lg-6 -->

			</div>
		</div> 		<!-- End row -->
	</div>   	<!-- End container -->
</section>   <!-- End section -->

<?php require __DIR__ . '/footer.php'; ?>

<!-- Add jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Add Owl Carousel JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<!-- Add your custom JavaScript code here -->
<script>
    // JavaScript to control the carousel
    $(document).ready(function(){
        $('#image-carousel').owlCarousel({
            loop: true,
            autoplay: true,
            autoplayTimeout: 2000, // Change image every 2 seconds
            autoplayHoverPause: true,
            items: 4,
            dots: true,
            nav: true
        });
    });

    <?php
// Récupère tous les fichiers dans un dossier
$images = glob('./images/cov/*.{jpg,jpeg}', GLOB_BRACE);
?>


    var images = <?php echo json_encode($images); ?>;
    var index = 0;

    function changerImageAutomatiquement() {
        var image = document.getElementById('image');
        image.src = images[index];
        index = (index + 1) % images.length;
    }

    setInterval(changerImageAutomatiquement, 3000);


</script>
<style>
	.owl-nav button span {
    font-size: xxx-large;
}
</style>