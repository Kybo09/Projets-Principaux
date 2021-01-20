        <?php
            include 'header.php';
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
            $listeVip = $vipManager->getAllVip($tri, $search);
            
            if(isset($_GET['deleteconfirm'])){
                $hrefdelete = "listVip.php?delete=true&amp;id=".$_GET['id'];
                echo '<div id="popup" class="row">';
                echo '<p class="col s8">Etes vous sûr de vouloir supprimer cette fiche ?</p>';
                echo '<a class="col s2" href='.$hrefdelete.'>Oui</a> <a class="col s2" href="listVip.php">Non</a>';
                echo '</div>';
            }
        ?>

        <div>
            <h1>Fiches VIP</h1>
            
            <form class="row" method='post' action="listVip.php">
                <div class="input-field col s12 m5">
                    <select name="tri">
                      <option value="0" disabled <?php if(!isset($_GET['tri'])){echo 'selected';}?>>Trier par</option>
                      <option value="1" <?php if($_GET['tri'] == 1){echo 'selected';}?>>Prenom A-Z</option>
                      <option value="2" <?php if($_GET['tri'] == 2){echo 'selected';}?>>Prenom Z-A</option>
                      <option value="3" <?php if($_GET['tri'] == 3){echo 'selected';}?>>Nom A-Z</option>
                      <option value="4" <?php if($_GET['tri'] == 4){echo 'selected';}?>>Nom Z-A</option>
                    </select>
                </div>
                <div class="input-field col s12 m6">
                    <input type="text" id="search" name="search" placeholder="Rechercher un VIP" value="<?php if(isset($_GET['search'])){echo $_GET['search'];}?>"/>
                </div>
                <div class="input-field col s12 m1">
                    <input type="submit" name="submit" value="GO"/>
                </div>
            </form>
            
            <div class="row" id="cardvipfiche">           
                                
                <?php foreach($listeVip as $vip) {?>
                <div class="col s12 m6">
                    <div class="card horizontal">
                        <div class="card-image">
                            <img src=<?php echo "../".$vip->getUrlPicture() ?>>
                        </div>
                        <a href="ficheVip.php?id=<?php echo $vip->getId() ?>">
                            <div class="card-stacked">
                                <div class="card-content row" style="margin: 0;">
                                    <div class="col s6">
                                        <p><?php echo $vip->getNom(); ?></p>
                                        <p><?php echo $vip->getPrenom(); ?></p>
                                    </div>
                                    <div class="col s6 btn-group-card">
                                        <a href="listVip.php?deleteconfirm=true&amp;id=<?php echo $vip->getId()?>#popup"><i class="medium material-icons">delete</i></a>
                                        <a href="formVip.php?id=<?php echo $vip->getId()?>"><i class="medium material-icons">edit</i></a>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                    
                <?php }?>

            </div>
            <?php
                if(isset($_GET['delete'])) {
                    $vipManager->deleteVip($_GET['id']);
                    echo '<script>window.location.href="listVip.php";</script>';
                }
                
                if($_POST['submit']){
                    $urlredirect = $redirectManager->getVipSearchUrlRedirect($_POST['search'], $_POST['tri']);
                    echo '<script>window.location.href="'. $urlredirect . '";</script>';
                }
            ?>
            
            
            <div class="fixed-action-btn horizontal" style="bottom: 45px; right: 24px;">
                <a class="btn-floating btn-large purple" href="formVip.php">
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
