<?php 

require __DIR__ . '/header.php'; //le style est deja existe (css et bootstrap)
require __DIR__ . '/db.php';

if(!isset($_SESSION['name'])) {
  header('Location: /login');
}

$orders;
$statement = $pdo->prepare("SELECT * FROM transactions WHERE email=? ORDER BY id DESC");
$statement->execute(array($_SESSION['email']));
$orders = $statement->fetchAll(PDO::FETCH_ASSOC);

?>
<section class="user-dashboard page-wrapper">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<ul class="list-inline dashboard-menu text-center">
                    <li><a href="./profile.php">Profile Details</a></li>
					<li><a class="active" href="./orders.php">Ordres</a></li>
				</ul>
				<div class="dashboard-wrapper user-dashboard">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Prix total</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($orders as $order): ?>
                                <tr>
                                <td><?= htmlspecialchars($order['horodatage']) ?></td>
                                <td>DT <?php
                                    $details = unserialize($order['details']);
                                    
                                    $total = 0;
                                    foreach($details as $detail) {
                                        // print_r($details);die();
                                        $total += $detail['price'] * $detail['quantity'];
                                    }
                                    echo $total;
                                    ?>
                                </td>
                                <td><a href="./order-details.php?id=<?= htmlspecialchars($order['id']) ?>" class="btn btn-default">Voir</a></td>
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