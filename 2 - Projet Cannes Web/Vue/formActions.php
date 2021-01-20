        <?php
            include 'header.php';
            
            $actionManager = new actionManager($bdd);
            $vipManager = new vipManager($bdd);
        
            if(isset($_GET['id'])){
                $edit = 1;
                $actiondata = $actionManager->getActionInfo($_GET['id']);
            }
            $listeVip = $vipManager->getAllVip(0, "");
        ?>
        <div class="row">
            <h1><?php if($edit == 1){echo 'Editer';}else{echo 'Ajouter';} ?> une action</h1>
            <form class="col s10 offset-s1 m8 offset-m2 l6 offset-l3" id="formVIP" method='post' action="formActions.php">
                <div class="input-field col s12 l6">
                    <input type="text" id="titre" name="titre" value="<?php if($edit == 1){echo $actiondata->getTitre();} ?>" required/>
                    <label for="titre">Titre</label>
                </div>
                <div class="input-field col s12 l6">
                    <select name="idvip" required>
                        <option value="" disabled <?php if($edit != 1){echo 'selected';}?>>VIP Concerné</option>
                        <?php foreach($listeVip as $vip){?>
                        <option value="<?php echo $vip->getId();?>" <?php if($edit == 1){if($vip->getId() == $actiondata->getIdvip()){echo 'selected';}}?>><?php echo $vip->getNom() . ' ' . $vip->getPrenom();?> </option>
                        <?php }?>
                    </select>
                </div>
                <div class="input-field col s12 l6">
                    <input type="date"  name="date" placeholder="Date" value="<?php if($edit == 1){echo $actionManager->getDateForm($actiondata->getIdAction());}?>" required>
                </div>
                <div class="input-field col s12 l6">
                    <input type="time"  name="heure" placeholder="Heure" value="<?php if($edit == 1){echo $actiondata->getHeure();}?>" required>
                </div>

                <div class="input-field col s12">
                    <textarea id="textarea1" name="description" class="materialize-textarea" required><?php if($edit == 1){echo $actiondata->getDescription();}?></textarea>
                    <label for="textarea1">Description</label>
                </div>
                <input id="editmode" name="editmode" type="checkbox" <?php if($edit == 1){echo 'checked';}?>>
                <input id="idviphide" name="idviphide" type="text" value ="<?php if($edit == 1){echo $_GET['id'];}?>">
                <div class="input-field col s12">
                    <input type="submit" value="<?php if($edit == 1){echo 'Editer';}else{echo 'Ajouter';}?>"/>
                </div>
            </form>
        </div>
        
        <?php 
            if(isset($_POST['titre']) AND isset($_POST['date']) AND isset($_POST['heure']) AND isset($_POST['description'])){
                $a=date($_POST['date']. ' ' .$_POST['heure']);
                
                if(isset($_POST['editmode'])){
                    if($actionManager->editAction($_POST['titre'], $_POST['description'], $a, $_POST['idvip'], $_POST['idviphide'])){
                        echo '<script>window.location.href="listActions.php"</script>';
                    }
                }else{
                    if($actionManager->addAction($_POST['titre'], $_POST['description'], $a, $_POST['idvip'])){
                        echo '<script>window.location.href="listActions.php"</script>';
                    }
                }
            }
            
        ?>
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            M.AutoInit();
        </script>
    </body>
</html>
