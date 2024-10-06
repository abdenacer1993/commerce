<?php 

session_start();

if(strpos($_SERVER['HTTP_REFERER'], '/cart') !== false) {
  unset($_SESSION['cart']); 
} else {
  header('Location: /products.php');
}


require __DIR__ . '/header.php';
?>
<!-- Page Wrapper -->
<section class="page-wrapper success-msg">
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <div class="block text-center">
        	<i class="tf-ion-android-checkmark-circle"></i>
          <h2 class="text-center">Merci d'avoir magasiné avec nous</h2>
          <a href="./products.php" class="btn btn-main mt-20">Continuer vos achats</a>
        </div>
      </div>
    </div>
  </div>
</section><!-- /.page-warpper -->

<?php require __DIR__ . '/footer.php'; ?>