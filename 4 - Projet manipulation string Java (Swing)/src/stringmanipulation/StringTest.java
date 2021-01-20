package stringmanipulation;
import javax.swing.*;
import javax.swing.event.*;
import java.awt.*;
import java.awt.event.*;

public class StringTest extends JFrame implements ActionListener{
    // ecouteur classe interne
    private class InterneMaj implements ActionListener{ 
        public void  actionPerformed( ActionEvent e) {
            StringMoteur.toMaj();
        }
    }
    
    private static JPanel main = new JPanel();
    private static JLabel lab = new JLabel("Welcome to the string tester");
    private static JTextField entree = new JTextField(28);
    
   public StringTest(){
       super();
       StringMoteur moteur = new StringMoteur(this);
       constrFen();
   }
   
   private void constrFen(){
       setTitle("String Test");
       setSize(580, 150);
       setLocationRelativeTo(null);
       setResizable(false);
       setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
       setContentPane(constrPan());
       setVisible(true);
   }
   
   private JPanel constrPan(){
       // Panel main mis en variable de classe pour gérer le popup longueur
       main.setLayout(new GridLayout(3,1));
       // Création sous panel 1
       JPanel sp1 = new JPanel(new FlowLayout());
       JButton maj = new JButton("MAJUSCULES");
       maj.addActionListener(new InterneMaj());
       sp1.add(maj);
       JButton min = new JButton("minuscules");
       // ecouteur classe anonyme
       min.addActionListener(new ActionListener() { 
           public void  actionPerformed (ActionEvent e) {
               StringMoteur.toMin();
           }
       });
       sp1.add(min);
       JButton rb = new JButton("RetraitsBlancs");
       // expression lambda
       rb.addActionListener(event -> {StringMoteur.retrait();});
       sp1.add(rb);
       JButton longueur = new JButton("Longueur");
       longueur.addActionListener(this);
       sp1.add(longueur);
       JButton quit = new JButton("Quitte");
       quit.addActionListener(this);
       sp1.add(quit);
       //Création sous panel 2
       JPanel sp2 = new JPanel(new FlowLayout(FlowLayout.LEFT));
       // lab est en variable de classe pour y avoir accès depuis les accesseurs
       sp2.add(lab);
       sp2.setComponentOrientation(ComponentOrientation.LEFT_TO_RIGHT);
       // Création sous panel 3
       JPanel sp3 = new JPanel(new FlowLayout());
       // entree est en variable de classe pour y avoir accès depuis les accesseurs
       sp3.add(entree);
       JButton afin = new JButton("Ajout fin");
       afin.addActionListener(this);
       sp3.add(afin);
       JButton adebut = new JButton("Ajout debut");
       adebut.addActionListener(this);
       sp3.add(adebut);
       JButton remplace = new JButton("Remplace");
       remplace.addActionListener(this);
       sp3.add(remplace);
       // Ajout des sous panels
       main.add(sp1);
       main.add(sp2);
       main.add(sp3);
       
       return main;
   }
   
   public String getStringAffichee(){
       return lab.getText();
   }
   
   public void setStringAffichee(String newText){
       lab.setText(newText);
   }
   
   public static String getStringEntree(){
       return entree.getText();
   }
   
   public static JPanel getJpanel(){
       return main;
   }
   
   public void actionPerformed(ActionEvent evt){
        JButton buttonSource = (JButton) evt.getSource();
        String source = buttonSource.getText();
        if(source.equals("Longueur")){
           StringMoteur.longueur();
        }
        if(source.equals("Quitte")){
            StringMoteur.quitte();
        }
        if(source.equals("Ajout fin")){
            StringMoteur.afin();
        }
        if(source.equals("Ajout debut")){
            StringMoteur.adebut();
        }
        if(source.equals("Remplace")){
            StringMoteur.remplace();
        }
    };
   
}
        