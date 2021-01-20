package com.example.kybank

import android.app.AlertDialog
import android.os.Bundle
import android.view.View
import android.widget.EditText
import android.widget.LinearLayout
import android.widget.TextView
import androidx.appcompat.app.AppCompatActivity
import com.google.gson.Gson
import com.google.gson.reflect.TypeToken
import kotlinx.android.synthetic.main.activity_budgets.*
import org.w3c.dom.Text
import java.lang.reflect.Type
import kotlin.math.roundToInt


class BudgetsActivity : AppCompatActivity() {
    companion object {
        var budgetListe: ArrayList<Budget> = ArrayList()
        var detailListe: ArrayList<String> = ArrayList()
    }
    private var prog: Float = 0f
    private lateinit var activite: BudgetsActivity
    var budgetCourrant: Budget = Budget(null, 0f, 0f)
    var budget1: Budget = Budget("Setup Gaming", 0f, 1200f)

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        activite = this
        setContentView(R.layout.activity_budgets)

        budgetListe = chargerArrayBudgets()
        detailListe = chargerArrayDetails()

        affichageUI()
        affichageBtnSuivPrec()

        ajoutBudget.setOnClickListener{
            if(somme.text.toString() != ""){
                budgetCourrant.montantActuel = budgetCourrant.montantActuel + somme.text.toString().toFloat()
                detailListe.add(labelInput.text.toString() + " : " + somme.text.toString() +"€")
                somme.setText("Somme")
                labelInput.setText("Label")
                updateProgressBar(budgetCourrant);
                sauvegarderArray()
                sauvegarderArrayDetail()
            }
        }

        retraitBudget.setOnClickListener{
            if(somme.text.toString() != ""){
                if(budgetCourrant.montantActuel <= somme.text.toString().toFloat()){
                    budgetCourrant.montantActuel = 0f
                }else{
                    budgetCourrant.montantActuel = budgetCourrant.montantActuel - somme.text.toString().toFloat()
                }
                somme.setText("Somme")
                updateProgressBar(budgetCourrant);
                sauvegarderArray()
            }
        }

        btnCreerBudget.setOnClickListener{
            creerBudget(budget1)
        }

        budgetSuiv.setOnClickListener{
            val idBudgCourant:Int = budgetListe.indexOf(budgetCourrant)
            budgetCourrant = budgetListe[idBudgCourant + 1]
            affichageBtnSuivPrec()
            updateProgressBar(budgetCourrant)
        }

        budgetPrec.setOnClickListener{
            val idBudgCourant:Int = budgetListe.indexOf(budgetCourrant)
            budgetCourrant = budgetListe[idBudgCourant - 1]
            affichageBtnSuivPrec()
            updateProgressBar(budgetCourrant)
        }

        btnDelete.setOnClickListener{
            supprBudget()
        }

        btnEdit.setOnClickListener{
            editerBudget(budgetCourrant)
        }

        btnDetails.setOnClickListener{
            afficherSourceBudget()
        }
    }

    private fun supprBudget(){
        val indexactuel:Int = budgetListe.indexOf(budgetCourrant)
        budgetListe.removeAt(indexactuel)
        sauvegarderArray()
        affichageUI()
        affichageBtnSuivPrec()
    }

    private fun sauvegarderArray(){
        val sharedPreferences = getSharedPreferences("shared preferences", MODE_PRIVATE)
        val editor = sharedPreferences.edit()
        val gson = Gson()
        val json = gson.toJson(budgetListe)
        editor.putString("budget list", json)
        editor.apply()
    }

    private fun sauvegarderArrayDetail(){
        val sharedPreferences = getSharedPreferences("shared preferences", MODE_PRIVATE)
        val editor = sharedPreferences.edit()
        val gson = Gson()
        val json = gson.toJson(detailListe)
        editor.putString("details list", json)
        editor.apply()
    }

    private fun chargerArrayBudgets(): ArrayList<Budget> {
        val sharedPreferences = getSharedPreferences("shared preferences", MODE_PRIVATE)
        val emptyList = Gson().toJson(ArrayList<Budget>())
        return Gson().fromJson(
            sharedPreferences.getString("budget list", emptyList),
            object : TypeToken<ArrayList<Budget>>() {
            }.type
        )
    }

    private fun chargerArrayDetails(): ArrayList<String>{
        val sharedPreferences = getSharedPreferences("shared preferences", MODE_PRIVATE)
        val emptyList = Gson().toJson(ArrayList<String>())
        return Gson().fromJson(
            sharedPreferences.getString("details list", emptyList),
            object : TypeToken<ArrayList<String>>() {
            }.type
        )
    }

    private fun affichageUI(){
        if(budgetListe.size == 0){
            budgetName.setText("Vous n'avez pas encore créer de budgets !");
            progress_budget.visibility = View.INVISIBLE;
            percentageText.visibility = View.INVISIBLE;
            avancementBudget.visibility = View.INVISIBLE;
            txtSomme.visibility = View.INVISIBLE;
            somme.visibility = View.INVISIBLE;
            ajoutBudget.visibility = View.INVISIBLE;
            retraitBudget.visibility = View.INVISIBLE;
            btnDelete.visibility = View.INVISIBLE;
        }else{
            budgetCourrant = budgetListe[0];
            updateProgressBar(budgetCourrant)
        }
    }

    private fun affichageBtnSuivPrec(){
        val idbudget:Int = budgetListe.indexOf(budgetCourrant)
        val nbBudget:Int = budgetListe.size
        if((idbudget+1)==nbBudget){
            budgetSuiv.visibility = View.INVISIBLE;
        }else{
            budgetSuiv.visibility = View.VISIBLE;
        }
        if(idbudget == 0 || budgetListe.size == 0){
            budgetPrec.visibility = View.INVISIBLE;
        }else{
            budgetPrec.visibility = View.VISIBLE;
        }
    }

    private fun afficherSourceBudget(){
        val alert = AlertDialog.Builder(this)

        alert.setTitle("Détails budget")
        val layout = LinearLayout(this)
        layout.orientation = LinearLayout.VERTICAL

        for(desc in detailListe){
            val text = TextView(this)
            text.text = desc
            layout.addView(text)
        }
        alert.setView(layout)
        alert.setPositiveButton("Ok") { dialog, whichButton ->}

        alert.show()
    }

    private fun editerBudget(b: Budget){
        val alert = AlertDialog.Builder(this)

        alert.setTitle("Modifier le budget")

        val layout = LinearLayout(this)
        layout.orientation = LinearLayout.VERTICAL

        val inputlabel = EditText(this)
        inputlabel.hint = "Nom du budget"
        inputlabel.setText(b.labelBudget)
        val inputobjectif = EditText(this)
        inputobjectif.hint = "Objectif"
        inputobjectif.setText(b.objectif.toString())

        layout.addView(inputlabel)
        layout.addView(inputobjectif)

        alert.setView(layout)

        alert.setPositiveButton("Ok") { dialog, whichButton ->
            b.labelBudget = inputlabel.text.toString()
            b.objectif = inputobjectif.text.toString().toFloat()
            updateProgressBar(budgetCourrant)
            affichageBtnSuivPrec()
            sauvegarderArray()
        }

        alert.setNegativeButton(
            "Annuler"
        ) { dialog, whichButton ->
            // Canceled.
        }

        alert.show()
    }

    private fun creerBudget(b: Budget){
        val alert = AlertDialog.Builder(this)

        alert.setTitle("Créer un nouveau budget")

        val layout = LinearLayout(this)
        layout.orientation = LinearLayout.VERTICAL

        val inputlabel = EditText(this)
        inputlabel.hint = "Nom du budget"
        val inputobjectif = EditText(this)
        inputobjectif.hint = "Objectif"

        layout.addView(inputlabel)
        layout.addView(inputobjectif)

        alert.setView(layout)

        alert.setPositiveButton("Ok") { dialog, whichButton ->
            val newBudget:Budget = Budget(
                inputlabel.text.toString(),
                0f,
                inputobjectif.text.toString().toFloat()
            )
            budgetListe.add(newBudget)
            budgetCourrant = newBudget
            if(budgetListe.size == 1){
                progress_budget.visibility = View.VISIBLE;
                percentageText.visibility = View.VISIBLE;
                avancementBudget.visibility = View.VISIBLE;
                txtSomme.visibility = View.VISIBLE;
                somme.visibility = View.VISIBLE;
                ajoutBudget.visibility = View.VISIBLE;
                retraitBudget.visibility = View.VISIBLE;
                btnDelete.visibility = View.VISIBLE;
            }
            updateProgressBar(newBudget)
            affichageBtnSuivPrec()
            sauvegarderArray()

        }

        alert.setNegativeButton(
            "Annuler"
        ) { dialog, whichButton ->
            // Canceled.
        }

        alert.show()
    }

    private fun updateProgressBar(b: Budget){
        budgetName.setText(b.labelBudget);
        prog = (b.montantActuel / b.objectif)*100
        avancementBudget.text = "${b.montantActuel}€ / ${b.objectif}€";
        progress_budget.progress = prog.roundToInt()
        percentageText.text = "${prog.roundToInt()}" + "%"
    }
}