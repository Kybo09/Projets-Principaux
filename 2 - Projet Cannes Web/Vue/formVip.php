        <?php 
            include 'header.php';
            $vipManager = new vipManager($bdd);
            if(isset($_GET['id'])){
                $edit = 1;
                $listeInfo = $vipManager->getInfoVip($_GET['id']);
            }
        ?>
        
        <div class="row">
            <h1><?php if($edit == 1){echo 'Editer';}else{echo 'Ajouter';}?> une fiche VIP</h1>
            <form enctype="multipart/form-data" class="col s10 offset-s1 m8 offset-m2 l6 offset-l3" id="formVIP" method='post' action="formVip.php">
                <div class="col s12">
                    <div class="input-field col s12 l3">
                        <input type="text" id="nom" name="nom" value="<?php if($edit == 1){echo $listeInfo->getNom();}?>" required/>
                        <label for="nom">Nom</label>
                    </div>
                    <div class="input-field col s12 l3">
                        <input type="text" id="prenom" name="prenom" value="<?php if($edit == 1){echo $listeInfo->getPrenom();}?>" required/>
                        <label for="prenom">Prenom</label>
                    </div>
                    <div class="input-field col s12 l6">
                        <select name="role" required>
                            <option value="" disabled <?php if($edit != 1){echo 'selected';}?>>Rôle</option>
                            <option value="1" <?php if($edit == 1){if($listeInfo->getType()==1){echo 'selected';}}?>>Acteur</option>
                            <option value="2" <?php if($edit == 1){if($listeInfo->getType()==2){echo 'selected';}}?>>Réalisateur</option>
                            <option value="3" <?php if($edit == 1){if($listeInfo->getType()==3){echo 'selected';}}?>>Autre</option>
                        </select>
                    </div>
                </div>
                <div class="input-field col s12 l6">
                    <input type="text" id="nationalite" name="nationalite" value="<?php if($edit == 1){echo $listeInfo->getNationalite();}?>" required/>
                    <label for="nationalite">Nationalité</label>
                </div>
                <div class="col s12 l6">
                    <div class="input-field col s10">
                        <input type="number" min="0" max="10" id="coeff" name="coeff" value="<?php if($edit == 1){echo $listeInfo->getCoeffImportance();}?>" required/>
                        <label for="coeff">Niveau d'importance :</label>
                    </div>
                    <div class="input-field col s2">
                        <p>/10</p>
                    </div>
                </div>
                <div class="input-field col s12 switchCharge">
                   <div class="switch col s4">
                        <label>
                          Hebergement
                          <input type="checkbox" name="hebergement" <?php if($edit==1){if($listeInfo->getNiveauPriseCharge()[2]==1){echo 'checked';}}?>>
                          <span class="lever"></span>
                        </label>
                    </div>
                    <div class="switch col s4">
                        <label>
                          Repas
                          <input type="checkbox" name="repas" <?php if($edit==1){if($listeInfo->getNiveauPriseCharge()[1]==1){echo 'checked';}}?>>
                          <span class="lever"></span>
                        </label>
                    </div>
                    <div class="switch col s4">
                        <label>
                          Transport
                          <input type="checkbox" name="transport" <?php if($edit==1){if($listeInfo->getNiveauPriseCharge()[0]==1){echo 'checked';}}?>>
                          <span class="lever"></span>
                        </label>
                    </div>
                </div>
                <div class="col s12 file-field input-field">
                  <div class="btn">
                    <span>Photo</span>
                    <input type="file" id="fileselect" accept="image/*" name="fileselect">
                  </div>
                  <div class="file-path-wrapper">
                      <input class="file-path validate" type="text" name="urlpath" value="<?php if($edit == 1){echo $listeInfo->getUrlPicture();}?>">
                  </div>
                </div>
                <input id="editmode" name="editmode" type="checkbox" <?php if($edit == 1){echo 'checked';}?>>
                <input id="idviphide" name="idviphide" type="text" value ="<?php if($edit == 1){echo $_GET['id'];}?>">
                <input id="oldurl" name="oldurl" type="text" value ="<?php if($edit == 1){echo $urlEdit;}?>">
                <div class="input-field col s12">
                    <input type="text" id="compagnon" name="compagnon" value="<?php if($edit == 1){echo $compagnonEdit;}?>">
                    <label for="compagnon">Compagnon attitré.e</label>
                </div>
                <div class="input-field col s12">
                    <input type="submit" value="<?php if($edit == 1){echo 'Editer';}else{echo 'Ajouter';}?>"/>
                </div>
            </form>
        </div>
        <?php
            
        $imageManager = new imageManager();
        $imageManager->addImage($_FILES["fileselect"]["tmp_name"], $_FILES["fileselect"]["name"]);
            
        if(isset($_POST['prenom']) AND isset($_POST['nom'])){
            $priseCharge = 0;
            if(isset($_POST['hebergement'])){
                $priseCharge += 1;
            }
            if(isset($_POST['repas'])){
                $priseCharge += 2;
            }
            if(isset($_POST['transport'])){
                $priseCharge += 4;
            }

            if(!isset($_POST['editmode'])){
                if($vipManager->addVip($_POST['prenom'], $_POST['nom'], $_POST['nationalite'], $_POST['role'], $_POST['coeff'], $priseCharge, $_POST['compagnon'], $_POST['urlpath'])){
                    echo '<script>window.location.href="listVip.php";</script>';
                }
            }else{
                if($vipManager->editVip($_POST['prenom'], $_POST['nom'], $_POST['nationalite'],$_POST['role'],$_POST['coeff'],$priseCharge,$_POST['compagnon'],$_POST['urlpath'],$_POST['idviphide'])){
                    echo '<script>window.location.href="listVip.php";</script>';
                }
            }
        }
        ?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
        <script>
            M.AutoInit();
        </script>
    </body>
</html>