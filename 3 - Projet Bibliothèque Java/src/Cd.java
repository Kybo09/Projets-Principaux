import java.util.ArrayList;

public class Cd extends DocBibliotheque {

    // Variables d'instanciation
    private String titre;
    private ArrayList<String> listeMorceaux;
    private static int nbCD;

    // Constructeur
    Cd(String code, String auteur, String newTitre, ArrayList<String> newListeMorceaux){
        super(code, auteur);
        this.titre = newTitre;
        this.listeMorceaux = newListeMorceaux;
    }


    public String getTitre() {
        return titre;
    }

    public void setTitre(String titre) {
        this.titre = titre;
    }


    public ArrayList<String> getListeMorceaux() {
        return listeMorceaux;
    }

    public void setListeMorceaux(ArrayList<String> listeMorceaux) {
        this.listeMorceaux = listeMorceaux;
    }

    public String toString(){
        return(titre + listeMorceaux + super.toString());
    }
}
