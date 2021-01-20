        <?php
            include 'header.php';
            
            
            if(isset($_GET['deleteconfirm'])){
                $hrefdelete = "listEchanges.php?delete=true&amp;id=".$_GET['id'];
                echo '<div id="popup" class="row">';
                echo '<p class="col s8">Etes vous sûr de vouloir supprimer cet échange ?</p>';
                echo '<a class="col s2" href='.$hrefdelete.'>Oui</a> <a class="col s2" href="listEchanges.php">Non</a>';
                echo '</div>';
            }
            
            $echangeManager = new echangeManager($bdd);
            $vipManager = new vipManager($bdd);
            $redirectManager = new RedirectManager();
            
            if(!isset($_GET['search'])){
                $search = "";
            }else{
                $search = $_GET['search'];
            }
            if(!isset($_GET['tri'])){
                $tri = 0;
            }else{
                $tri = $_GET['tri'];
            }
            if(!isset($_GET['searchVip'])){
                $idVip = -1;
            }else{
                $idVip = $_GET['searchVip'];
            }
            if(!isset($_GET['type'])){
                $type = -1;
            }else{
                $type = $_GET['type'];
            }
            
            $listeEchange = $echangeManager->getAllEchanges($tri, $type, $idVip, $search);
            $listeVip = $vipManager->getAllVip(0, "");
            
        ?>
        <div>
            <h1>Echanges</h1>
            <form class="row" method='post' action="listEchanges.php">
                <div class="input-field col s6 m2">
                    <select name="tri">
                      <option value="0" disabled selected>Trier par</option>
                      <option value="1">Date + récent</option>
                      <option value="2">Date - récent</option>
                    </select>
                </div>
                <div class="input-field col s6 m1">
                    <select name="type">
                      <option value="0" disabled selected>Type échange</option>
                      <option value="1">SMS</option>
                      <option value="2">Mail</option>
                      <option value="3">Appel</option>
                    </select>
                </div>
                <div class="input-field col s12 m4">
                    <select name="searchVip">
                        <option value="" disabled selected>Rechercher un VIP</option>
                        <?php foreach($listeVip as $vip){?>
                        <option value="<?php echo $vip->getId();?>"><?php echo $vip->getNom() . ' ' . $vip->getPrenom();?> </option>
                        <?php }?>
                    </select>
                </div>
                <div class="input-field col s12 m4">
                    <input type="text" id="search" name="search" placeholder="Rechercher un échange" value=""/>
                </div>
                <div class="input-field col s12 m1">
                    <input type="submit" name="submit" value="GO"/>
                </div>
            </form>
            
            <?php 
                if($_POST['submit']){
                   $urlredirect = $redirectManager->getEchangeSearchUrlRedirect($_POST['search'], $_POST['searchVip'], $_POST['type'], $_POST['tri']);
                   echo '<script>window.location.href="'. $urlredirect . '";</script>';
                }
            ?>
            
            <div class="row actionrow specialrow">
                <div class="col s2"><p>VIP</p></div>
                <div class="col s2"><p>Type</p></div>
                <div class="col s4"><p>Titre</p></div>
                <div class="col s2"><p>Date et Heure</p></div>
            </div>

            <?php foreach($listeEchange as $echange){ 
                $nom = $vipManager->getPrenomById($echange->getIdvip());
            ?>
            <a href="ficheEchange.php?id=<?php echo $echange->getIdEchange()?>" class="black">
                <div class="row actionrow">
                    <div class="col s2"><p><?php echo $nom?></p></div>
                    <div class="col s2"><p><?php echo $echange->getNature()?></p></div>
                    <div class="col s4"><p><?php echo $echange->getTitre()?></p></div>
                    <div class="col s2"><p>Le <?php echo $echange->getDate()?> à <?php echo $echange->getHeure()?></p></div>
                    <div class="col s2 actioncardbtn">
                        <a href="listEchanges.php?deleteconfirm=true&amp;id=<?php echo $echange->getIdEchange()?>#popup"><i class="material-icons">delete</i></a>
                        <a href="formEchange.php?id=<?php echo $echange->getIdEchange()?>"><i class="material-icons">edit</i></a>
                    </div>
                </div>
            </a>
            <?php } ?>
            <?php
                if (isset($_GET['delete'])) {                  
                    if($echangeManager->deleteEchange($_GET['id'])){
                        echo '<script>window.location.href="listEchanges.php";</script>';
                    }
                }
            ?>
            <div class="fixed-action-btn horizontal" style="bottom: 45px; right: 24px;">
                <a href="formEchange.php" class="btn-floating btn-large purple">
                  <i class="large material-icons">add</i>
                </a>
            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
        <script>
            M.AutoInit();
        </script>
    </body>
</html>