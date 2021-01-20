import java.util.InputMismatchException;
import java.util.Scanner;


public class TestBibliotheque {
    //création de variables de classe
    private static DocBibliotheque doc1 = new DocBibliotheque("Les fleurs du mal", "Michel");
    private static DocBibliotheque doc2 = new DocBibliotheque("DDH-ZE", "Michel");
    private static DocBibliotheque doc3 = new DocBibliotheque("DDHE", "Michel");
    private static MembreEtudiant membre1 = new MembreEtudiant("Kezel", "Benoit", "000000", "21 rue de la fondarmée");
    private static MembrePersonnel membre2 = new MembrePersonnel("zefzef", "etienne", "000000", "21 rue de la fondarmée");
    private static CatalogueBibliotheque cat = new CatalogueBibliotheque();
    private static EmployeBibliotheque employe1 = new EmployeBibliotheque(2,"Maurren");

    public static void main(String[] args){

        // Test pour notification MembreEtudiant
        cat.ajDoc(doc1);
        cat.ajDoc(doc2);

        cat.emprunteDoc(0, membre2);
        cat.reserveDoc(0, membre1);
        cat.rendreDoc(0);

        // Test pour notification MembrePersonnel
        cat.reserveDoc(0, membre2);
        cat.rendreDoc(0);

        // Test emprunt EmployeBibliotheque
        cat.emprunteDoc(0, membre1);
        try{
            doc1.reserver(employe1);
        }catch(ReservationImpossibleException e){
            System.out.println("Impossible de réserver");
        }
        System.out.println("Document dans le catalogue avant : ");
        cat.afficheTousLesDocs();
        cat.rendreDoc(0);
        System.out.println("Document dans le catalogue après : ");
        cat.afficheTousLesDocs();


    }
}
