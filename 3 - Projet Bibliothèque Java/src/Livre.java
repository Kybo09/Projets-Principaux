public class Livre extends DocBibliotheque {
    // Variables d'instanciation
    private String titre;
    private int annee;
    private String editeur;
    private int nbPages;
    private int isbn;
    private static int nbLivres;

    // Constructeur
    Livre(String code, String auteur, String newTitre, int newAnnee, String newEditeur, int newNbPages, int newIsbn){
       super(code, auteur);
       this.titre = newTitre;
       this.annee = newAnnee;
       this.editeur = newEditeur;
       this.nbPages = newNbPages;
       this.isbn = newIsbn;
    }

    // Getters
    public String getTitre(){return titre;}
    public int getAnnee(){return annee;}
    public String getEditeur() {return editeur;}
    public int getNbPages() {return nbPages;}
    public int getIsbn() {return isbn;}
    public int getNbLivres() {return nbLivres;}

    // Setters
    public void setTitre(String newTitre){
        this.titre = newTitre;
    }
    public void setAnnee(int newAnnee){
        this.annee = newAnnee;
    }
    public void setEditeur(String editeur) {this.editeur = editeur;}
    public void setNbPages(int nbPages) {this.nbPages = nbPages;}
    public void setIsbn(int isbn) {this.isbn = isbn;}
    public void setNbLivres(int nbLivres) {this.nbLivres = nbLivres;}

    public String toString() {
        return (isbn + titre + annee + editeur + nbPages + super.toString());
    }
}
