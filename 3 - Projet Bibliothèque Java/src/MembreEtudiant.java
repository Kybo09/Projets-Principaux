import javax.print.Doc;
import java.util.Scanner;

public class MembreEtudiant extends MembreBibliotheque {

    MembreEtudiant(String nom, String prenom, String tel, String adresse){
        super(nom, prenom, tel, adresse);
    }

    public boolean peutEmprunterAutreDocument(){
        if(nbDocEmprunte >=4) {
            return false;
        }else{
            return true;
        }
    }

    @Override
    public void docDisponible(DocBibliotheque d){
        System.out.println("Le document " + d + " est disponible !");
        Scanner sc = new Scanner(System.in);
        System.out.println("Souhaitez-vous l'emprunter ? ");
        System.out.println("1 - oui");
        System.out.println("2 - non");
        String choix = sc.nextLine();
        if(choix.equals("1")){
            try {
                d.emprunter(this);
            } catch (EmpruntImpossibleException e) {
                e.printStackTrace();
            }
        }else{
            System.out.println("Document non emprunté !");
        }
    }

    public String toString(){
        return(super.toString());
    }
}
