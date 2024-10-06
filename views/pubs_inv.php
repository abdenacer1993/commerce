<?php
require __DIR__ . '/header.php';
require __DIR__ . '/db.php';
session_start();
if (!isset($_SESSION['name'])) {
  header('Location: ./login.php');
  exit(); // Exit after redirection
}

$orders;
$statement = $pdo->prepare("SELECT * FROM pub WHERE id_investor=? ORDER BY id DESC");
$statement->execute(array($_SESSION['id']));
$orders = $statement->fetchAll(PDO::FETCH_ASSOC);

// Check if the ID parameter is set in the URL
if (isset($_GET['id'])) {
  // Sanitize the ID input
  $pub_id = intval($_GET['id']);

  // Prepare and execute the DELETE query
  $statement = $pdo->prepare("DELETE FROM pub WHERE id = ?");
  $statement->execute([$pub_id]);
}

// Redirect back to the pubs_inv.php page
header('Location: pubs_inv.php');
exit(); // Make sure to exit after redirection
?>




<section class="user-dashboard page-wrapper">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <ul class="list-inline dashboard-menu text-center">
          <li><a href="./profile_inv.php">Profile Details</a></li>
          <li><a class="active" href="./pubs_inv.php">Mes publicité</a></li>
        </ul>
        <div class="dashboard-wrapper user-dashboard">
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>Image</th>
                  <th>Name Ste</th>
                  <th>Etat</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($orders as $order): ?>
                  <tr>
                    <td>
                      <img src="../uploads/<?= htmlspecialchars(unserialize($order['image'])[0]) ?>" alt=""
                        width="80px" />
                    </td>
                    <td><?= htmlspecialchars($order['name_company']) ?></td> <!-- Changed from $orders['company'] -->
                    <td><?= htmlspecialchars($order['status']) ?></td>
                    <td><a href="./delete_pub.php?id=<?= htmlspecialchars($order['id']) ?>"
                        class="btn btn-default">Supprimer pub </a></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>

            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php require __DIR__ . '/footer.php'; ?>