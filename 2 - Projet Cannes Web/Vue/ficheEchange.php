        <?php 
            include 'header.php';
            
            $echangeManager = new echangeManager($bdd);
            $vipManager = new vipManager($bdd);
            
            $dataEchange = $echangeManager->getEchangeInfo($_GET['id']);
            $vipData = $vipManager->getInfoVip($dataEchange->getIdvip());
            
            if(isset($_GET['deleteconfirm'])){
                $hrefdelete = "ficheEchange.php?delete=true&amp;id=".$_GET['id'];
                echo '<div id="popup" class="row">';
                echo '<p class="col s8">Etes vous sûr de vouloir supprimer cet échange ?</p>';
                echo '<a class="col s2" href='.$hrefdelete.'>Oui</a> <a class="col s2" href="ficheEchange.php?id='. $idVip .'">Non</a>';
                echo '</div>';
            }
        ?>
        <div>
            <div class="row rowaction btn-group-card">
                <a href="ficheEchange.php?id=<?php echo $dataEchange->getIdEchange()?>&amp;deleteconfirm=true#popup"><i class="medium material-icons">delete</i></a>
                <a href="formEchange.php?id=<?php echo $dataEchange->getIdEchange()?>"><i class="medium material-icons">edit</i></a>
            </div>
            <div class="row" id="ficheAction">
                <div class="col s12 m6 offset-m3 descAction">
                    <p><?php echo $dataEchange->getTitre()?></p>
                    <p>Type : <?php echo $dataEchange->getNature()?></p>
                    <p><?php echo $dataEchange->getDescription()?></p>
                    <p class="date">Le <?php echo $dataEchange->getDate()?> à <?php echo $dataEchange->getHeure()?></p>
                </div>
                <div class="col s12 m6 offset-m3">
                    <div class="card horizontal">
                        <div class="card-image">
                            <img src=<?php echo "../".$vipData->getUrlPicture() ?>>
                        </div>
                        <a href="ficheVip.php?id=<?php echo $vipData->getId()?>">
                            <div class="card-stacked">
                                <div class="card-content row" style="margin: 0;">
                                    <div class="col s6">
                                        <p><?php echo $vipData->getPrenom(); ?></p>
                                        <p><?php echo strtoupper($vipData->getNom());?></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php
            if (isset($_GET['delete'])) {                  
                if($echangeManager->deleteEchange($_GET['id'])){
                    echo '<script>window.location.href="listEchanges.php";</script>';
                }
            }
        ?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
        <script>
            M.AutoInit();
        </script>
    </body>
</html>
