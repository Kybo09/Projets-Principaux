package stringmanipulation;

import javax.swing.*;
import javax.swing.event.*;
import java.awt.*;
import java.awt.event.*;

public class StringMoteur{
    
    public static StringTest interfaceUtilisateur;
    
    public StringMoteur(StringTest ObjetInterface){
        this.interfaceUtilisateur = ObjetInterface;
    }
    
    public static void main(String[] args){
        StringTest s = new StringTest();
    }
    
    public static void toMaj(){
        String actuel = interfaceUtilisateur.getStringAffichee();
        actuel = actuel.toUpperCase();
        interfaceUtilisateur.setStringAffichee(actuel);
    }
    
    public static void toMin(){
        String actuel = interfaceUtilisateur.getStringAffichee();
        actuel = actuel.toLowerCase();
        interfaceUtilisateur.setStringAffichee(actuel);
    }
    
    public static void retrait(){
        String entree = interfaceUtilisateur.getStringAffichee();
        entree = entree.trim();
        interfaceUtilisateur.setStringAffichee(entree);
        
    }
    
    public static void longueur(){
        String actuel = interfaceUtilisateur.getStringAffichee();
        int taille = actuel.length();
        JPanel p = interfaceUtilisateur.getJpanel();
        JOptionPane.showMessageDialog(p,"Longeur : " + taille,"Longeur de la chaine",JOptionPane.PLAIN_MESSAGE);
    }
    
    public static void quitte(){
        System.exit(0);
    }
    
    public static void afin(){
        String entree = interfaceUtilisateur.getStringEntree();
        String actuel = interfaceUtilisateur.getStringAffichee();
        interfaceUtilisateur.setStringAffichee(actuel + entree);
    }
    
    public static void adebut(){
        String entree = interfaceUtilisateur.getStringEntree();
        String actuel = interfaceUtilisateur.getStringAffichee();
        interfaceUtilisateur.setStringAffichee(entree + actuel);
    }
    
    public static void remplace(){
        String entree = interfaceUtilisateur.getStringEntree();
        interfaceUtilisateur.setStringAffichee(entree);
    }
   
}
