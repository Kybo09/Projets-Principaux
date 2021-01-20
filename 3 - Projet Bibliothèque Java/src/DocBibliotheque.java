class DocBibliotheque {

    //variables d'instances
    public String code;
    public String auteur;
    private boolean etageres = true;
    public boolean emprunte;
    private boolean pile_retours;
    private boolean pile_reservation;
    public boolean enresa;
    private static int nbdocEtageres = 10;
    private static int nbdocEmprunt;
    private static int nbdocPile;
    private static int nbdocResa;
    private MembreBibliotheque emprunteur;
    private Notifiable reserveur;
    public boolean isUsed;

    //Constructeur paramètres
    DocBibliotheque(String newCode, String newAuteur){
        this.code = newCode;
        this.auteur = newAuteur;
    }

    //Mutateurs
    public String getCode() {
        return code;
    }

    public void setCode(String code) {
        this.code = code;
    }

    public String getAuteur() {
        return auteur;
    }

    public void setAuteur(String auteur) {
        this.auteur = auteur;
    }

    public void ranger() throws RangementImpossibleException{
        if(this.pile_retours == true){
            this.etageres = true;
            this.pile_retours = false;
            this.nbdocPile--;
            this.nbdocEtageres++;
        }
        else{
            throw new RangementImpossibleException();
        }
    }

    public void emprunter(MembreBibliotheque newEmprunteur) throws EmpruntImpossibleException{
        if(this.etageres == true){
            this.emprunte = true;
            this.etageres = false;
            this.nbdocEtageres--;
            this.nbdocEmprunt++;
            this.emprunteur = newEmprunteur;
            this.reserveur = null;
        }
        else {
            if (this.pile_reservation == true) {
                this.emprunte = true;
                this.pile_reservation = false;
                this.enresa = false;
                this.nbdocResa--;
                this.nbdocEmprunt++;
                if(this.reserveur.equals(newEmprunteur)){
                    this.emprunteur = newEmprunteur;
                    this.reserveur = null;
                }else{throw new EmpruntImpossibleException();}

            } else {
                throw new EmpruntImpossibleException();
            }
        }
    }

    public String retour() throws RetourImpossibleException{
        if(this.emprunte == true){
            if(this.enresa == true){
                this.pile_reservation = true;
                this.emprunte = false;
                nbdocResa++;
                nbdocEmprunt--;
                reserveur.docDisponible(this);
                this.emprunteur = null;
                return "resa";
            }
            else{
                this.pile_retours = true;
                this.emprunte = false;
                nbdocPile++;
                nbdocEmprunt--;
                this.emprunteur = null;
                return "retour";
            }
        }
        else{
            throw new RetourImpossibleException();
        }
    }

    public String reserver(Notifiable notif) throws ReservationImpossibleException{
        if(this.emprunte == true){
            if(this.enresa == false) {
                this.enresa = true;
                this.reserveur = notif;
                return "ok";
            }
            else {throw new ReservationImpossibleException();}
        }
        else{
            throw new ReservationImpossibleException();
        }
    }

    public boolean annulerReservation(Notifiable notif) throws AnnulationResaImpossibleException{
        if(this.reserveur.equals(notif)) {
            if (this.enresa == true) {
                this.enresa = false;
                this.reserveur = null;
                return true;
            } else {
                throw new AnnulationResaImpossibleException();
            }
        }
        throw new AnnulationResaImpossibleException();
    }

    //Accesseurs
    public boolean isEtageres() {
        return etageres;
    }

    public boolean isEmprunte() {
        return emprunte;
    }

    public boolean isRetours() {
        return pile_retours;
    }

    public boolean isReservation() {
        return pile_reservation;
    }

    public boolean isReserver(){
        return enresa;
    }

    public int nbDocEtagere(){
        return nbdocEtageres;
    }

    public int nbDocResa(){
        return nbdocResa;
    }

    public int nbDocEmprunter(){
        return nbdocEmprunt;
    }

    public int nbDocRetour(){
        return nbdocPile;
    }

    public void setIsUsed(boolean state){
        this.isUsed = state;
    }

    public static int getNbdocEtageres() {
        return nbdocEtageres;
    }

    public static int getNbdocEmprunt() {
        return nbdocEmprunt;
    }

    public static int getNbdocPile() {
        return nbdocPile;
    }

    public static int getNbdocResa() {
        return nbdocResa;
    }

    public MembreBibliotheque getEmprunteur() {
        return emprunteur;
    }

    public Notifiable getReserveur() {
        return reserveur;
    }

    public String toString(){
        return(code + " écrit par " + auteur);
    }

}
