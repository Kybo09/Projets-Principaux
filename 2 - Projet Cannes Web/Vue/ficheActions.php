        <?php 
            include 'header.php';
            
            $actionManager = new actionManager($bdd);
            $vipManager = new vipManager($bdd);
            
            $actiondata = $actionManager->getActionInfo($_GET['id']);
            $vipdata = $vipManager->getInfoVip($actiondata->getIdvip());

            if(isset($_GET['deleteconfirm'])){
                $hrefdelete = "ficheActions.php?delete=true&amp;id=".$_GET['id'];
                echo '<div id="popup" class="row">';
                echo '<p class="col s8">Etes vous sûr de vouloir supprimer cette action ?</p>';
                echo '<a class="col s2" href='.$hrefdelete.'>Oui</a> <a class="col s2" href="ficheActions.php?id='. $idVip .'">Non</a>';
                echo '</div>';
            }
        ?>
        <div>
            <div class="row rowaction btn-group-card">
                <a href="ficheActions.php?id=<?php echo $actiondata->getIdAction()?>&amp;deleteconfirm=true#popup"><i class="medium material-icons">delete</i></a>
                <a href="formActions.php?id=<?php echo $actiondata->getIdAction()?>"><i class="medium material-icons">edit</i></a>
            </div>
            <div class="row" id="ficheAction">
                <div class="col s12 m6 offset-m3 descAction">
                    <p><?php echo $actiondata->getTitre()?></p>
                    <p><?php echo $actiondata->getDescription()?></p>
                    <p class="date">Le <?php echo $actiondata->getDate()?> à <?php echo $actiondata->getHeure()?></p>
                </div>
                <div class="col s12 m6 offset-m3">
                    <div class="card horizontal">
                        <div class="card-image">
                            <img src=<?php echo "../".$vipdata->getUrlPicture() ?>>
                        </div>
                        <a href="ficheVip.php?id=<?php echo $vipdata->getId()?>">
                            <div class="card-stacked">
                                <div class="card-content row" style="margin: 0;">
                                    <div class="col s6">
                                        <p><?php echo $vipdata->getPrenom(); ?></p>
                                        <p><?php echo strtoupper($vipdata->getNom()); ?></p>
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
                if($actionManager->deleteAction($_GET['id'])){
                    echo '<script>window.location.href="listActions.php";</script>';
                }
            }
        ?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
        <script>
            M.AutoInit();
        </script>
    </body>
</html>
