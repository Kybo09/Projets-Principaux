public class MembreBibliotheque implements Notifiable{

    //variables d'instance
    private String nom;
    private String prenom;
    private String tel;
    private String adresse;
    private int numAbo;
    public int nbDocEmprunte = 0;
    private static int dernierNumeroAbonne;

    //constructeur
    MembreBibliotheque(String newNom, String newPrenom, String newTel, String newAdresse){
        this.nom = newNom;
        this.prenom = newPrenom;
        this.tel = newTel;
        this.adresse = newAdresse;
        dernierNumeroAbonne++;
        this.numAbo = dernierNumeroAbonne;
    }

    public String getNom() {
        return nom;
    }

    public String getPrenom() {
        return prenom;
    }

    public String getTel() {
        return tel;
    }

    public String getAdresse() {
        return adresse;
    }

    public int getNumAbo() {
        return numAbo;
    }

    public int getNbDocEmprunte(){
        return nbDocEmprunte;
    }

    public void reduireEmprunt(int nbDoc){
        this.nbDocEmprunte -= nbDoc;
    }

    public void augmenterEmprunt(int nbDoc){
        this.nbDocEmprunte += nbDoc;
    }

    public boolean peutEmprunterAutreDocument(){
        if(nbDocEmprunte >=8) {
            return false;
        }else{
            return true;
        }
    }

    public String toString(){
        return(nom + " " + prenom + " " + tel + " " + adresse + " N°" + numAbo);
    }

    @Override
    public void docDisponible(DocBibliotheque d) {}
}
