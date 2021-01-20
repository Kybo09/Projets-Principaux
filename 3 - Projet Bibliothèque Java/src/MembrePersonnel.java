public class MembrePersonnel extends MembreBibliotheque {

    MembrePersonnel(String nom, String prenom, String tel, String adresse){
        super(nom, prenom, tel, adresse);
    }

    @Override
    public void docDisponible(DocBibliotheque d){
        System.out.println("Le document " + d + " qui a été réservé par le membre du personnel " + this.getPrenom() + " est désormais disponible à l’emprunt au bureau des réservations");
    }
}
