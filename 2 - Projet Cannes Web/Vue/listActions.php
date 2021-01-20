        <?php
            include 'header.php';
        
            if(isset($_GET['deleteconfirm'])){
                $hrefdelete = "listActions.php?delete=true&amp;id=".$_GET['id'];
                echo '<div id="popup" class="row">';
                echo '<p class="col s8">Etes vous sûr de vouloir supprimer cette action ?</p>';
                echo '<a class="col s2" href='.$hrefdelete.'>Oui</a> <a class="col s2" href="listActions.php">Non</a>';
                echo '</div>';
            }
            
            $actionManager = new actionManager($bdd);
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
            
            $listeActions = $actionManager->getAllActions($tri, $idVip, $search);
            $listeVip = $vipManager->getAllVip(0, "");
            
        ?>
        <div>
            <h1>Actions</h1>
            <form class="row" method='post' action="listActions.php">
                <div class="input-field col s12 m3">
                    <select name="tri">
                      <option value="0" disabled <?php if(!isset($_GET['tri'])){echo 'selected';}?>>Trier par</option>
                      <option value="1" <?php if($_GET['tri'] == 1){echo 'selected';}?>>Date + récent</option>
                      <option value="2" <?php if($_GET['tri'] == 2){echo 'selected';}?>>Date - récent</option>
                    </select>
                </div>
                
                <div class="input-field col s12 m4">
                    <select name="searchVip">
                        <option value="" disabled selected>Rechercher un VIP</option>
                        <?php foreach($listeVip as $vip){ ?>
                        <option value="<?php echo $vip->getId();?>" <?php if($vip->getId() == $_GET['searchVip']){echo 'selected';}?>><?php echo $vip->getNom() . ' ' . $vip->getPrenom();?> </option>
                        <?php }?>
                    </select>
                </div>
                <div class="input-field col s12 m4">
                    <input type="text" id="search" name="search" placeholder="Rechercher une action" value="<?php if(isset($_GET['search'])){echo $_GET['search'];}?>"/>
                </div>
                <div class="input-field col s12 m1">
                    <input type="submit" name="submit" value="GO"/>
                </div>
            </form>
           
            
            <div class="row actionrow specialrow">
                <div class="col s2"><p>VIP</p></div>
                <div class="col s4"><p>Titre</p></div>
                <div class="col s2"><p>Date</p></div>
                <div class="col s2"><p>Heure</p></div>
            </div>
            
            <?php foreach($listeActions as $actiondata) {
                $nom = $vipManager->getPrenomById($actiondata->getIdvip());
            ?>
            <a href="ficheActions.php?id=<?php echo $actiondata->getIdAction() ?>" class="black">
            <div class="row actionrow">
                <div class="col s2"><p><?php echo $nom;?></p></div>
                <div class="col s4"><p><?php echo $actiondata->getTitre();?></p></div>
                <div class="col s2"><p><?php echo $actiondata->getDate();?></p></div>
                <div class="col s2"><p><?php echo $actiondata->getHeure();?></p></div>
                <div class="col s2 actioncardbtn">
                    <a href="listActions.php?deleteconfirm=true&amp;id=<?php echo $actiondata->getIdAction()?>#popup"><i class="material-icons">delete</i></a>
                    <a href="formActions.php?id=<?php echo $actiondata->getIdAction()?>"><i class="material-icons">edit</i></a>
                </div>
            </div>
            </a>
            <?php } ?>

            <?php
                if (isset($_GET['delete'])) {                  
                    if($actionManager->deleteAction($_GET['id'])){
                        echo '<script>window.location.href="listActions.php";</script>';
                    }   
                }
                
                if($_POST['submit']){
                    $urlredirect = $redirectManager->getActionSearchUrlRedirect($_POST['search'], $_POST['searchVip'], $_POST['tri']);
                    echo '<script>window.location.href="'. $urlredirect . '";</script>';
                }
            ?>

            <div class="fixed-action-btn horizontal" style="bottom: 45px; right: 24px;">
                <a href="formActions.php" class="btn-floating btn-large purple">
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