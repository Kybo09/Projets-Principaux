        <?php 
            include 'header.php';
            $vipManager = new vipManager($bdd);
            $actionManager = new actionManager($bdd);
            $echangeManager = new echangeManager($bdd);
            
            if(isset($_GET['id'])){
                $listeInfo = $vipManager->getInfoVip($_GET['id']);
            }
            
            if(isset($_GET['deleteconfirm'])){
                $hrefdelete = "ficheVip.php?delete=true&amp;id=".$_GET['id'];
                echo '<div id="popup" class="row">';
                echo '<p class="col s8">Etes vous sûr de vouloir supprimer cette fiche ?</p>';
                echo '<a class="col s2" href='.$hrefdelete.'>Oui</a> <a class="col s2" href="ficheVip.php?id='. $listeInfo->getId() .'">Non</a>';
                echo '</div>';
            }
        ?>
        <div>
        <div class="row rowaction btn-group-card">
            <a href="ficheVip.php?id=<?php echo $listeInfo->getId()?>&amp;deleteconfirm=true#popup"><i class="medium material-icons">delete</i></a>
            <a href="formVip.php?id=<?php echo $listeInfo->getId()?>"><i class="medium material-icons">edit</i></a>
        </div>
        <div class="row" id="fichevipinfo">
            <div class="col s12 m6 offset-m3">
                <div class="col s6">
                    <img src="<?php echo "../".$listeInfo->getUrlPicture() ?>">
                </div>
                <div class="col s6 infovip">
                    <p><?php echo $listeInfo->getPrenom()." ".strtoupper($listeInfo->getNom()) ?></p>
                    <p>Type : <?php echo $listeInfo->getType() ?></p>
                    <p>Nationalité : <?php echo $listeInfo->getNationalite() ?></p>
                    <p>Coefficient d'importance : <?php echo $listeInfo->getCoeffImportance() ?>/10</p>
                    <p>Compagnon : <?php if(strcmp($listeInfo->getCompagnon(),'') !== 0){echo $listeInfo->getCompagnon();}else{echo 'Aucun(e)';}?></p>
                </div>
                <div class="input-field col s12 switchCharge">
                   <div class="switch col s4">
                        <label>
                          Hebergement
                          <input type="checkbox" name="hebergement" disabled <?php if($listeInfo->getNiveauPriseCharge()[2]==1){echo 'checked';}?>>
                          <span class="lever"></span>
                        </label>
                    </div>
                    <div class="switch col s4">
                        <label>
                          Repas
                          <input type="checkbox" name="repas" disabled <?php if($listeInfo->getNiveauPriseCharge()[1]==1){echo 'checked';}?>>
                          <span class="lever"></span>
                        </label>
                    </div>
                    <div class="switch col s4">
                        <label>
                          Transport
                          <input type="checkbox" name="transport" disabled <?php if($listeInfo->getNiveauPriseCharge()[0]==1){echo 'checked';}?>>
                          <span class="lever"></span>
                        </label>
                    </div>
                </div>
            </div>
            <?php
                $actiondata = $actionManager->getActionInfobyVip($listeInfo->getId());
                $echangedata = $echangeManager->getEchangeInfobyVip($listeInfo->getId());
            ?>
            <div class="col s12">
                <a href="ficheActions.php?id=<?php echo $actiondata->getIdAction() ?>" class="black">
                    <div class="col s12 m4 offset-m1 lastSave">
                        <p>Dernière action effectuée :</p>
                        <p><?php echo $actiondata->getTitre(); ?></p>
                        <p class="date">Le <?php echo $actiondata->getDate();?> à <?php echo $actiondata->getHeure();?></p>
                    </div>
                </a>
                <a href="ficheEchange.php?id=<?php echo $echangedata->getIdEchange() ?>" class="black">
                    <div class="col s12 m4 offset-m1 lastSave">
                        <p>Dernier échange enregistré :</p>
                        <p><?php echo $echangedata->getTitre(); ?></p>
                        <p class="date">Le <?php echo $echangedata->getDate();?> à <?php echo $echangedata->getHeure();?></p>
                        
                    </div>
                </a>
                
            </div>
        </div>
        </div>
        <?php
            if (isset($_GET['delete'])) {
                $getUrl = $conn->prepare('SELECT urlPicture FROM vip WHERE idVip = ?');
                $getUrl->execute(array($_GET['id']));
                $url = $getUrl->fetch()[0];
                unlink($url);
                $query2 = $conn->prepare('DELETE FROM vip WHERE idVip = ?');
                $query2->execute(array($_GET['id']));
                echo '<script>window.location.href="vip.php";</script>';
            }
        ?>
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
        <script>
            M.AutoInit();
        </script>
    </body>
</html>