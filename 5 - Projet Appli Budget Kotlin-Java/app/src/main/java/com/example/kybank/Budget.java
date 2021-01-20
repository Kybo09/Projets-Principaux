package com.example.kybank;

public class Budget {
    private static int idBudget;
    private String labelBudget;
    private float montantActuel;
    private float objectif;

    public static int getIdBudget() {
        return idBudget;
    }

    public String getLabelBudget() {
        return labelBudget;
    }

    public void setLabelBudget(String labelBudget) {
        this.labelBudget = labelBudget;
    }

    public float getMontantActuel() {
        return montantActuel;
    }

    public void setMontantActuel(float montantActuel) {
        this.montantActuel = montantActuel;
    }

    public float getObjectif() {
        return objectif;
    }

    public void setObjectif(float objectif) {
        this.objectif = objectif;
    }

    public Budget(String label, float montant, float obj){
        labelBudget = label;
        montantActuel = montant;
        objectif = obj;
    }
}
