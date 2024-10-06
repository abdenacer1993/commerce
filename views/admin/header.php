<?php 

ob_start();
session_start(); 

if(!isset($_SESSION['token'])) {
    header('Location: ./login.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" type="image/x-icon" href="../images/favicon.png" />
    <title> AlGiNET | Dashboard</title>
    <link href="./assets/vendor/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="./assets/vendor/fontawesome/css/solid.min.css" rel="stylesheet">
    <link href="./assets/vendor/fontawesome/css/brands.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" >
    <link href="./assets/css/master.css" rel="stylesheet">
    <link href="./assets/vendor/datatables/datatables.min.css" rel="stylesheet">
    <link href="./assets/vendor/flagiconcss/css/flag-icon.min.css" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <nav id="sidebar" class="active">
            <ul class="list-unstyled components text-secondary">
                <li>
                    <a href="./home.php"><i class="fas fa-home"></i>Acceuil</a>
                </li>
                <li>
                    <a href="./products.php"><i class="fas fa-shopping-cart"></i>Produits</a>
                </li>
                <li>
                    <a href="./pub.php"><i class="fas fa-shopping-cart"></i>Pub</a>
                </li>
                <li>
                    <a href="./customers.php"><i class="fas fa-user"></i></i>Clients</a>
                </li>
                <li>
                    <a href="./investor.php"><i class="fas fa-user"></i></i>Investisseur</a>
                </li>
                <li>
                    <a href="./orders.php"><i class="fas fa-file"></i>Ordres</a>
                </li>
                <li>
                    <a href="./faq.php"><i class="fas fa-info-circle"></i>FAQ</a>
                </li>
                <li>
                    <a href="./settings.php"><i class="fas fa-cog"></i>Paramètres</a>
                </li>
            </ul>
        </nav>
        <div id="body" class="active">
            <!-- navbar navigation component -->
            <nav class="navbar navbar-expand-lg navbar-white bg-white">
                <button type="button" id="sidebarCollapse" class="btn btn-light" onclick="change()">
                    <i id="bars" class="fas fa-bars"></i><span></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="nav navbar-nav ms-auto">
                     
                        <li class="nav-item dropdown">
                            <div class="nav-dropdown">
                                <a href="#" id="nav2" class="nav-item nav-link dropdown-toggle text-secondary" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user"></i> <span><?= $_SESSION['name'] ?></span> <i style="font-size: .8em;" class="fas fa-caret-down"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end nav-link-menu">
                                    <ul class="nav-list">
                                        <!-- <li><a href="./reset-password" class="dropdown-item"><i class="fas fa-address-card"></i> Réinitialiser le mot de passe</a></li> -->
                                        <li><a href="./logout.php" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Se déconnecter</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- end of navbar navigation -->
            <div class="content">
            <script>
function change() {
    var sidebar = document.getElementById('sidebarCollapse');
    var bars = document.getElementById('bars');

    if (sidebar.classList.contains('active')) {
        sidebar.classList.remove('active');
    } else {
        sidebar.classList.add('active');
    }

    // Add or remove rotate-icon class based on the active state
    if (sidebar.classList.contains('active')) {
        bars.classList.add('rotate-icon');
    } else {
        bars.classList.remove('rotate-icon');
    }
}
</script>

                <style>
                    .rotate-icon {
    transform: rotate(90deg);
    transition: transform 0.3s ease; /* Add smooth transition */
}
                </style>