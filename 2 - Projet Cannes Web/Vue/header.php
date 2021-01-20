<?php  
    session_start(); 
    if(!strpos($_SERVER['REQUEST_URI'],'login')){
        if(!isset($_SESSION['nom'])){
            header("Location:login.php");
        }
    }
    include '../Modele/vip.php';
    include '../Modele/action.php';
    include '../Modele/echange.php';
    include '../Controlleur/connexionManager.php';
    include '../Controlleur/actionManager.php';
    include '../Controlleur/vipManager.php';
    include '../Controlleur/echangeManager.php';
    include '../Controlleur/redirectManager.php';
    include '../Controlleur/imageManager.php';
    $conn = new connexionManager("mysql-devasbolute.alwaysdata.net", "devasbolute_cannes", "220228", "devabsolute");
    $bdd = $conn->getDB();
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="../css/main.css" rel="stylesheet">
    </head>
    <body>
        <?php if(!strpos($_SERVER['REQUEST_URI'],'login')){?>
        <nav>
            <div class="nav-wrapper purple lighten-1">
              <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
              <a href="logout.php" id="decotext" class="brand-logo right"><?php echo $_SESSION['nom']?><i class="material-icons">power_settings_new</i></a>
              <ul class="center hide-on-med-and-down">
                <li class="title"><a href="index.php">Cannes VIP</a></li>
                <li><a href="listVip.php">Fiches</a></li>
                <li><a href="listActions.php">Actions</a></li>
                <li><a href="listEchanges.php">Echanges</a></li>
              </ul>
            </div>
        </nav>

        <ul class="sidenav" id="mobile-demo">
          <li><a href="index.php">Cannes VIP</a></li>
          <li><a href="listVip.php">Fiches</a></li>
          <li><a href="listActions.php">Actions</a></li>
          <li><a href="listEchanges.php">Echanges</a></li>
        </ul>
        <?php } ?>

