public class ReservationImpossibleException extends Exception{
    ReservationImpossibleException(){
        super("Impossible de réserver le document");
    }
}
