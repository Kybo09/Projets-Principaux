public class NombreHorsLimiteException extends Exception {
    NombreHorsLimiteException (int nombre){
        super ("Le nombre " + nombre + " est hors limite !");
    }
}
