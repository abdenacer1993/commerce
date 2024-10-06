<?php 

require __DIR__ . '/header.php';
require __DIR__ . '/../csrf.php';
require __DIR__ . '/db.php';

if(!isset($_SESSION['name'])) {
  header('Location: /login');
}

if(isset($_POST['update']) && CSRF::validateToken($_POST['token'])) {
  if(isset($_POST['firstname'])) {
    $firstname = filter_input(INPUT_POST, 'firstname');
    $statement = $pdo->prepare("UPDATE personnes SET nom=? WHERE email=?");
    $statement->execute(array($firstname, $_SESSION['email']));
    $_SESSION['name'] = explode(' ', $_SESSION['name'])[0] . ' ' . $firstname;
  }
  if(isset($_POST['lastname'])) {
    $lastname = filter_input(INPUT_POST, 'lastname');
    $statement = $pdo->prepare("UPDATE personnes SET prenom=? WHERE email=?");
    $statement->execute(array($lastname, $_SESSION['email']));
    $_SESSION['name'] = $lastname . ' ' . explode(' ', $_SESSION['name'])[1];
  }
  if(isset($_POST['address'])) {
    $address = filter_input(INPUT_POST, 'address');
    $statement = $pdo->prepare("UPDATE personnes SET addresse=? WHERE email=?");
    $statement->execute(array($address, $_SESSION['email']));
    $_SESSION['address'] = $address;
  }
  if(isset($_POST['phone'])) {
    $phone = filter_input(INPUT_POST, 'phone');
    $statement = $pdo->prepare("UPDATE personnes SET telephone=? WHERE email=?");
    $statement->execute(array($phone, $_SESSION['email']));
    $_SESSION['phone'] = $phone;
  }
    // Redirect back to the same page after processing the form
    header("Location: ".$_SERVER['PHP_SELF']); // Redirect to the same page
    exit(); // Ensure that no further code is executed after the redirect
}


?>
<section class="user-dashboard page-wrapper">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <ul class="list-inline dashboard-menu text-center">
          <li><a class="active" href="./profile.php">Profile Details</a></li>
          <li><a href="./orders.php">Orders</a></li>
        </ul>
        <div class="dashboard-wrapper dashboard-user-profile">
            <div class="media">
              <div class="media-body">
                <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="post">
                  <ul class="user-profile-list">
                    <?php CSRF::csrfInputField() ?>
                    <li><span>Nom:</span><input type="text" name="firstname" value="<?= htmlspecialchars(explode(' ', $_SESSION['name'])[1]) ?>"></li>
                    <li><span>Prenom:</span><input type="text" name="lastname" value="<?= htmlspecialchars(explode(' ', $_SESSION['name'])[0]) ?>"></li>
                    <li><span>Addresse:</span><input type="text" name="address" value="<?= htmlspecialchars($_SESSION['address']) ?>"></li>
                    <li><span>Telephone:</span><input type="tel" name="phone" value="<?= htmlspecialchars($_SESSION['phone']) ?>"></li>
                    <li><button class="btn btn-main" type="submit" name="update">Mise a jour</button></li>
                  </ul>
                </form>
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>
</section>
<?php require __DIR__ . '/footer.php'; ?>