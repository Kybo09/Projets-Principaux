public class EmployeBibliotheque implements Notifiable{

    private int numEmploye;
    private String nomEmploye;

    public EmployeBibliotheque(int num, String nom){
        this.numEmploye = num;
        this.nomEmploye = nom;
    }

    @Override
    public void docDisponible(DocBibliotheque d) {
        d.setIsUsed(true);
    }
}
