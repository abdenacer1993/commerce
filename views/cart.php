<?php

require __DIR__ . '/header.php'; 
require __DIR__ . '/db.php';
require __DIR__ . '/../csrf.php';
require __DIR__ . '/invoice.php';
require __DIR__ . '/sendgrid-php/sendgrid-php.php';
require __DIR__ . '/admin/util.php';


if(isset($_POST['checkout']) && CSRF::validateToken($_POST['token'])) {
  if(!isset($_SESSION['name'])) {
    header('Location: /login');
  } else {
    $details = serialize($_SESSION['cart']);
    $timestamp = gmdate('Y-m-d h:i:s');
    $statement = $pdo->prepare("INSERT INTO transactions (nom_prenom, email, address, details, horodatage) VALUES (?, ?, ?, ?, ?)");
    $statement->execute(array($_SESSION['name'], $_SESSION['email'], $_SESSION['address'], $details, $timestamp));
    
    // print_r($details);die();
    header('Location: ./confirmation.php');
  }
}

?>
<?php if(!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0): ?>
<section class="empty-cart page-wrapper">
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <div class="block text-center">
        	<i class="tf-ion-ios-cart-outline"></i>
          	<h2 class="text-center">Votre carte est actuellement vide.</h2>
          	<a href="./products.php" class="btn btn-main mt-20">Retour à la boutique</a>
      </div>
    </div>
  </div>
</section>
<?php else: ?>
<div class="page-wrapper">
  <div class="cart shopping">
    <div class="container">
      <div class="row">
        <div class="col-md-8 col-md-offset-2">
          <div class="block">
            <div class="product-list">
              <form method="post">
                <?php CSRF::csrfInputField() ?>
                <table class="table">
                  <thead>
                    <tr>
                      <th class="">Nom de l'article</th>
                      <th class="">Prix ​​de l'article</th>
                      <th class="">Quantité</th>
                      <th class="">Actions</th>
                      <th class="">Total</th>
                    </tr>
                  </thead>
                  <tbody>

                      <?php foreach($_SESSION['cart'] as $item): ?>
                        <tr class="">
                          <td class="">
                            <div class="product-info">
                              <img width="80" src="<?= htmlspecialchars($item['image']) ?>" alt="" />
                              <a href="#!"><?= htmlspecialchars($item['title']) ?></a>
                            </div>
                          </td>
                          <td class="">DT<?= number_format($item['price'], 2) ?></td>
                          <td class="">   <?= htmlspecialchars($item['quantity']) ?></td>
                          <td class="">
                            <a href="./cart-remove-item.php?id=<?= $item['id'] ?>" class="product-remove">Retirer</a>
                          </td>
                          <td class="">DT<?= number_format($item['price'] * htmlspecialchars($item['quantity']), 2) ?></td>
                        </tr>
                      <?php endforeach; ?>

                    <tr class="">
                      <td class="">
                        <div class="product-info">
                          <a href="#!">Total</a>
                        </div>
                      </td>
                      <td class=""></td>
                      <td class=""></td>
                      <td class=""></td>
                      <td class="">DT<?php
                          if(!isset($_SESSION['cart'])) {
                            echo '0.00';
                          } else {
                            $total = 0;
                            foreach($_SESSION['cart'] as $item) {
                              $total += $item['price'] * $item['quantity'];
                            }
                            echo number_format($total, 2);
                          }
                        ?>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="post">
                  <?php CSRF::csrfInputField() ?>
                  <button name="checkout" type="submit" class="btn btn-main pull-right">Passer à la caisse</button>
                </form>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php endif ?>
<?php require __DIR__ . '/footer.php'; ?>
