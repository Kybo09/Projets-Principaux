<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of echange
 *
 * @author benoi
 */
class echange {
    
    private $idEchange;
    private $nature;
    private $titre;
    private $description;
    private $date;
    private $heure;
    private $idvip;
    
    function __construct($idEchange, $nature, $titre, $description, $date, $heure, $idvip) {
        $this->idEchange = $idEchange;
        $this->nature = $nature;
        $this->titre = $titre;
        $this->description = $description;
        $this->date = $date;
        $this->heure = $heure;
        $this->idvip = $idvip;
    }
    
    function getIdEchange() {
        return $this->idEchange;
    }

    function getNature() {
        return $this->nature;
    }

    function getTitre() {
        return $this->titre;
    }

    function getDescription() {
        return $this->description;
    }

    function getDate() {
        return $this->date;
    }

    function getIdvip() {
        return $this->idvip;
    }


    function setNature($nature): void {
        $this->nature = $nature;
    }

    function setTitre($titre): void {
        $this->titre = $titre;
    }

    function setDescription($description): void {
        $this->description = $description;
    }

    function setDate($date): void {
        $this->date = $date;
    }

    function setIdvip($idvip): void {
        $this->idvip = $idvip;
    }

    function getHeure() {
        return $this->heure;
    }

    function setHeure($heure): void {
        $this->heure = $heure;
    }


    
}
