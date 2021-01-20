<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of vip
 *
 * @author benoi
 */
class vip {
    
    private $id;
    private $prenom;
    private $nom;
    private $nationalite;
    private $type;
    private $coeffImportance;
    private $niveauPriseCharge;
    private $compagnon;
    private $urlPicture;
    
    function __construct($id, $prenom, $nom, $nationalite, $type, $coeffImportance, $niveauPriseCharge, $compagnon, $urlPicture) {
        $this->id = $id;
        $this->prenom = $prenom;
        $this->nom = $nom;
        $this->nationalite = $nationalite;
        $this->type = $type;
        $this->coeffImportance = $coeffImportance;
        $this->niveauPriseCharge = $niveauPriseCharge;
        $this->compagnon = $compagnon;
        $this->urlPicture = $urlPicture;
    }
    
    function getId() {
        return $this->id;
    }
    
    function getPrenom() {
        return $this->prenom;
    }

    function getNom() {
        return $this->nom;
    }

    function getNationalite() {
        return $this->nationalite;
    }

    function getType() {
        return $this->type;
    }

    function getCoeffImportance() {
        return $this->coeffImportance;
    }

    function getNiveauPriseCharge() {
        return $this->niveauPriseCharge;
    }

    function getCompagnon() {
        return $this->compagnon;
    }

    function getUrlPicture() {
        return $this->urlPicture;
    }

    function setPrenom($prenom): void {
        $this->prenom = $prenom;
    }

    function setNom($nom): void {
        $this->nom = $nom;
    }

    function setNationalite($nationalite): void {
        $this->nationalite = $nationalite;
    }

    function setType($type): void {
        $this->type = $type;
    }

    function setCoeffImportance($coeffImportance): void {
        $this->coeffImportance = $coeffImportance;
    }

    function setNiveauPriseCharge($niveauPriseCharge): void {
        $this->niveauPriseCharge = $niveauPriseCharge;
    }

    function setCompagnon($compagnon): void {
        $this->compagnon = $compagnon;
    }

    function setUrlPicture($urlPicture): void {
        $this->urlPicture = $urlPicture;
    }


}
