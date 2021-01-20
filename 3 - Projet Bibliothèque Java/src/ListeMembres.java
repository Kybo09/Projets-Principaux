import java.util.ArrayList;

public class ListeMembres {

    private ArrayList<MembreBibliotheque> listeMembre;

    public ListeMembres(){
        this.listeMembre = new ArrayList<>();
    }

    public boolean ajMembre(MembreBibliotheque membreAj){
        if(listeMembre.contains(membreAj)){
            return false;
        }else{
            listeMembre.add(membreAj);
            return true;
        }
    }

    public MembreBibliotheque accesMembre(int num){
        return listeMembre.get(num);
    }
}


