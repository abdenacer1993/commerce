<?php 

require __DIR__ . '/header.php'; 
require __DIR__ . '/../db.php';
require __DIR__ . '/../../csrf.php';
require __DIR__ . '/util.php';

if(isset($_POST['export']) && CSRF::validateToken($_POST['token'])) {
    exportDB($host, $name, $user, $password);
}

if(isset($_POST['import']) && CSRF::validateToken($_POST['token'])) {
    importDB($pdo);
}

if(isset($_POST['send-email']) && CSRF::validateToken($_POST['token'])) {
    $title = filter_input(INPUT_POST, 'title');
    $message = filter_input(INPUT_POST, 'message');
    if($_POST['flexRadioDefault'] == 'all') {
        $emails = array();
        $statement = $pdo->prepare("SELECT * FROM personnes");
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach($results as $data) {
            $emails[] = $data['email'];
        }
        sendEmail($emails, $title, $message, $key);
    } else {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        sendEmail(array($email), $title, $message, $key);
    }
}

$dateRange = array(
    gmdate('Y-m-d') . ' 00:00:00 GMT',
    gmdate('Y-m-d') . ' 22:59:59 GMT'
);
$statement = $pdo->query("SELECT count(*) FROM transactions WHERE horodatage >= '$dateRange[0]' AND horodatage <= '$dateRange[1]'");
$orderCount = $statement->fetchColumn();
$revenue = 0;
$statement = $pdo->prepare("SELECT * FROM transactions WHERE horodatage >= ? AND horodatage <= ?");
$statement->execute($dateRange);
$transactions = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach($transactions as $transaction) {
    $details = unserialize($transaction['details']);
    // print_r($details);die();
    foreach($details as $detail) {
        $revenue += $detail['price'] * $detail['quantity'];
    }
}

$statement = $pdo->query("SELECT count(*) FROM transactions ");
$order_all_Count = $statement->fetchColumn();
$revenue_all = 0;
$statement = $pdo->prepare("SELECT * FROM transactions");
$statement->execute();
$transactions_all = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach($transactions_all as $transaction) {
    $details = unserialize($transaction['details']);
    foreach($details as $detail) {
        $revenue_all += $detail['price'] * $detail['quantity'];
    }
}





// Now $revenue_semaine contains the total revenue for the last week


$userCount = $pdo->query("SELECT count(*) FROM personnes where role ='client' ")->fetchColumn();
$investorCount = $pdo->query("SELECT count(*) FROM personnes where role = 'investisseur'")->fetchColumn();
?>
<div class="container">
    <div class="row">
        <div class="col-md-12 page-header">
            <div class="page-pretitle">Aperçu</div>
            <h2 class="page-title">Acceuil</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-md-6 col-lg-4 mt-3">
            <div class="card">
                <div class="content">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="icon-big text-center">
                                <i class="teal fas fa-shopping-cart"></i>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="detail">
                                <p class="detail-subtitle">Orders</p>
                                <span class="number"><?= $orderCount ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="footer">
                        <hr />
                        <div class="stats">
                            <i class="fas fa-calendar"></i> Pour aujourd'hui
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-6 col-lg-4 mt-3">
            <div class="card">
                <div class="content">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="icon-big text-center">
                                <i class="olive fas fa-money-bill-alt"></i>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="detail">
                                <p class="detail-subtitle">Revenu</p>
                                <span class="number">DT <?= number_format($revenue, 2) ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="footer">
                        <hr />
                        <div class="stats">
                            <i class="fas fa-calendar"></i> Pour aujourd'hui
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-6 col-lg-4 mt-3">
            <div class="card">
                <div class="content">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="icon-big text-center">
                                <i class="grey fas fa-users"></i>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="detail">
                                <p class="detail-subtitle">Utilisateur</p>
                                <span class="number"><?= $userCount ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="footer">
                        <hr />
                        <div class="stats">
                            <i class="fas fa-calendar"></i> Tous
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-sm-6 col-md-6 col-lg-4 mt-3">
            <div class="card">
                <div class="content">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="icon-big text-center">
                                <i class="teal fas fa-shopping-cart"></i>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="detail">
                                <p class="detail-subtitle">Orders</p>
                                <span class="number"><?= $order_all_Count ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="footer">
                        <hr />
                        <div class="stats">
                            <i class="fas fa-calendar"></i> Pour tous
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-6 col-lg-4 mt-3">
            <div class="card">
                <div class="content">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="icon-big text-center">
                                <i class="olive fas fa-money-bill-alt"></i>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="detail">
                                <p class="detail-subtitle">Revenu</p>
                                <span class="number">DT <?= number_format($revenue_all, 2) ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="footer">
                        <hr />
                        <div class="stats">
                            <i class="fas fa-calendar"></i> Pour tous
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-6 col-lg-4 mt-3">
            <div class="card">
                <div class="content">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="icon-big text-center">
                                <i class="grey fas fa-user-tie"></i>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="detail">
                                <p class="detail-subtitle">Investisseur</p>
                                <span class="number"><?= $investorCount ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="footer">
                        <hr />
                        <div class="stats">
                            <i class="fas fa-calendar"></i> Tous
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-11 mt-3">
            <div class="card">
                <div class="content">
                    <canvas id="revenueChart"></canvas> <!-- Canvas for the pie chart -->
                </div>
            </div>
        </div>
    </div>
  
</div>

<?php require __DIR__ . '/footer.php'; ?>
<script>
    // JavaScript code to initialize the Chart.js pie chart
    var ctx = document.getElementById('revenueChart').getContext('2d');
    var revenueChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Pour aujourd hui', 'Pour tous'],
            datasets: [{
                label: 'Revenue',
                data: [<?= $revenue ?>, <?= $revenue_all ?>],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
        }
    });
</script>
<style>
    #body>.navbar {
    padding: 0 5px;
    }
</style>