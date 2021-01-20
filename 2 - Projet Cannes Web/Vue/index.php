    <?php include 'header.php';?>
        <h1>Bonjour <?php echo $_SESSION['prenom']?> !</h1>
        <div class="row">
            <div class="col s12 m6 l4" id="cartevip">
                <a href="listVip.php">
                    <div class="card">
                        <div class="card-content">
                            <i class="material-icons">assignment_ind</i>
                            <p>Fiches VIP</p>
                        </div>
                        <div class="card-action">
                            <p>Ajouter, modifier ou supprimer des fiches VIP</p>
                        </div>
                    </div>
                </a>
            </div>
            
            <div class="col s12 m6 l4" id="carteactions">
                <a href="actions.php">
                    <div class="card">
                        <div class="card-content">
                          <i class="material-icons">priority_high</i>
                          <p>Actions</p>
                        </div>
                        <div class="card-action">
                            <p>Ajouter, modifier ou supprimer des actions effectuées</p>
                        </div>
                    </div>
                </a>
            </div>
            
            <div class="col s12 m6 l4" id="carteechanges">
                <a href="echange.php">
                    <div class="card">
                        <div class="card-content">
                            <i class="material-icons">compare_arrows</i>
                            <p>Echanges</p>
                        </div>
                        <div class="card-action">
                            <p>Ajouter, modifier ou supprimer des échanges avec les VIP</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
        <script>
            M.AutoInit();
        </script>
        
        
    </body>
</html>
