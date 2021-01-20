import java.util.ArrayList;

public class CatalogueBibliotheque{

    private ArrayList<DocBibliotheque> listeDoc;

    public CatalogueBibliotheque(){
        this.listeDoc = new ArrayList<>();
    }

    public boolean ajDoc(DocBibliotheque docAj){
        if(listeDoc.contains(docAj)){
            return false;
        }else{
            listeDoc.add(docAj);
            return true;
        }
    }

    public boolean supDoc(DocBibliotheque docSup){
        for(int i=0;i<listeDoc.size();i++){
            if(listeDoc.get(i) == docSup){
                listeDoc.remove(i);
                return true;
            }
        }
        return false;
    }

    public DocBibliotheque accesDoc(int i) throws NombreHorsLimiteException{
        if(i > listeDoc.size() || i < 0){
            throw new NombreHorsLimiteException(i);
        }
        return listeDoc.get(i);
    }

    public void afficheTousLesDocs(){
        for(int i=0;i<listeDoc.size();i++){
            if(!listeDoc.get(i).isUsed) {
                System.out.println(listeDoc.get(i));
            }
        }
    }

    public void afficheDocsEmpruntes(){
        for(int i=0;i<listeDoc.size();i++){
            if(listeDoc.get(i).emprunte){
                System.out.println(listeDoc.get(i));
            }
        }
    }

    public boolean emprunteDoc(int indiceDoc, MembreBibliotheque m){
        if(listeDoc.get(indiceDoc).emprunte){
            return false;
        }else{
            try{
                listeDoc.get(indiceDoc).emprunter(m);
                return true;
            }catch(EmpruntImpossibleException eie){
                System.out.println("Erreur : " + eie);
                return false;
            }

        }
    }

    public boolean reserveDoc(int indiceDoc, MembreBibliotheque m){
        if(listeDoc.get(indiceDoc).enresa || !listeDoc.get(indiceDoc).emprunte){
            return false;
        }else{
            try {
                listeDoc.get(indiceDoc).reserver(m);
                return true;
            }catch(ReservationImpossibleException rie){
                System.out.println("Erreur : " + rie);
                return false;
            }
        }
    }

    public boolean annulResaDoc(int indiceDoc, MembreBibliotheque m){
        if(listeDoc.get(indiceDoc).enresa && listeDoc.get(indiceDoc).getReserveur() == m){
            try{
                listeDoc.get(indiceDoc).annulerReservation(m);
                return true;
            }catch(AnnulationResaImpossibleException arie){
                System.out.println("Erreur " + arie);
                return false;
            }

        }else{
            return false;
        }
    }

    public boolean rendreDoc(int indiceDoc){
        if(listeDoc.get(indiceDoc).emprunte){
            try{
                listeDoc.get(indiceDoc).retour();
                return true;
            }catch(RetourImpossibleException rie){
                System.out.println("Erreur : " + rie);
                return false;
            }
        }else{
            return false;
        }
    }


}
