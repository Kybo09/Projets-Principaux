    <?php include 'header.php'; ?>
        <div id="popup">
            <a href="#" class="closepopup">X</a>
            <p>Contactez votre responsable Cannes pour obtenir vos identifiants et mot de passe</p>
        </div>
        
        <div class="row">
            <form class="col s12 m8 l6 offset-m2 offset-l3" id="formlogin" method="post" action="login.php">
              <div class="row">
                <h1>Connectez-vous pour accéder à Cannes VIP</h1>  
                <div class="input-field col s12">
                  <i class="material-icons prefix">account_circle</i>
                  <input type="text" id="username" name="username" value="demo"/>
                  <label for="username">Nom de famille (ex: Test)</label>
                </div>
                <div class="input-field col s12">
                  <i class="material-icons prefix">lock</i>
                  <input type="password" id="password" name="password" value="demo"/>
                  <label for="password">Mot de passe</label>
                </div>
                <div class="input-field col s12">
                    <input type="submit" value="Se Connecter"/>
                </div>
                <div class="col s12 center">
                    <a href="#popup" class="lienid">Obtenir vos identifiants</a>
                </div>
              </div>
            
            </form>
        </div>
        
        
        
        <?php
            $vipManager = new vipManager($bdd);
            if (isset($_POST["username"]) AND  isset($_POST["password"])){
                $lastname = $_POST["username"];
                if($conn->login($_POST['username'], $_POST['password'])){
                    $_SESSION['nom'] = $lastname;
                    $_SESSION['prenom'] = $vipManager->getPrenom($lastname);
                    header('Location:index.php');
                }else{
                    echo  '<script>alert("Erreur : Connexion impossible !");</script>';
                }
            }
        ?>
              
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
        <script>
            M.AutoInit();
        </script>
    </body>
</html>
