<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of echangeManager
 *
 * @author benoi
 */
class echangeManager {
    
    private $bdd;
    
    function __construct($bdd) {
        $this->bdd = $bdd;
    }
    
    function setBdd($bdd): void {
        $this->bdd = $bdd;
    }
    
    function getEchangeInfo($idEchange){
        $stmt = $this->bdd->prepare("SELECT idEchange, nature, titre, description, DATE_FORMAT(date, '%d/%m/%Y'), DATE_FORMAT(date, '%H:%i'), idvip  FROM echanges WHERE idEchange = ? ORDER BY date DESC");
        $stmt->execute(array($idEchange));
        $echangeobj = array();
        if($dataechange = $stmt->fetch()){
            $echangeobj = new echange($dataechange[0], $dataechange[1], $dataechange[2], $dataechange[3], $dataechange[4], $dataechange[5], $dataechange[6]);
        }
        
        return $echangeobj;
    }
    
    function getEchangeInfobyVip($idVip){
        $stmt = $this->bdd->prepare("SELECT idEchange, nature, titre, description, DATE_FORMAT(date, '%d/%m/%Y'), DATE_FORMAT(date, '%H:%i'), idvip  FROM echanges WHERE idvip = ? ORDER BY date DESC");
        $stmt->execute(array($idVip));
        $echangeobj = array();
        if($dataechange = $stmt->fetch()){
            $echangeobj = new echange($dataechange[0], $dataechange[1], $dataechange[2], $dataechange[3], $dataechange[4], $dataechange[5], $dataechange[6]);
        }
        
        return $echangeobj;
    }
    
    function getAllEchanges($tri, $type, $idVip, $search){
        $req = $this->getRequest($tri, $type, $idVip, $search);
        $stmt = $this->bdd->prepare($req);
        if(strcmp($req, "SELECT idEchange, nature, titre, description, DATE_FORMAT(date, '%d/%m/%Y'), DATE_FORMAT(date, '%H:%i'), idvip FROM echanges WHERE titre LIKE ? ORDER BY date DESC") == 0){
            $stmt->execute(array('%'.$search.'%'));
        }else{
            if(strcmp($req, "SELECT idEchange, titre, description, DATE_FORMAT(date, '%d/%m/%Y'), DATE_FORMAT(date, '%H:%i'), idvip  FROM actions WHERE idvip = ?") == 0){
                $stmt->execute(array($idVip));
            }else{
                if(strcmp($req, "SELECT idEchange, nature, titre, description, DATE_FORMAT(date, '%d/%m/%Y'), DATE_FORMAT(date, '%H:%i'), idvip FROM echanges WHERE nature = ? ORDER BY date DESC") == 0){
                    if($type == 1){
                        $stmt->execute(array("SMS"));
                    }
                    if($type == 2){
                        $stmt->execute(array("Mail"));
                    }
                    if($type == 3){
                        $stmt->execute(array("Appel"));
                    }
                }else{
                    $stmt->execute();
                }
            }            
        }
        $i = 0;
        $listeEchanges = array();
        while($data = $stmt->fetch()){
            $listeEchanges[$i] = new echange($data[0], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6]);
            $i = $i + 1;
        }
        return $listeEchanges;
    }
    
    function getRequest($tri, $type ,$idVip, $search){
        if(strcmp ($search, "") !== 0){
            return "SELECT idEchange, nature, titre, description, DATE_FORMAT(date, '%d/%m/%Y'), DATE_FORMAT(date, '%H:%i'), idvip FROM echanges WHERE titre LIKE ? ORDER BY date DESC";
        }else{
            if($idVip != -1){
                return "SELECT idEchange, nature, titre, description, DATE_FORMAT(date, '%d/%m/%Y'), DATE_FORMAT(date, '%H:%i'), idvip FROM echanges WHERE idvip = ? ORDER BY date DESC";
            }else{
                if($type != -1){
                    return ("SELECT idEchange, nature, titre, description, DATE_FORMAT(date, '%d/%m/%Y'), DATE_FORMAT(date, '%H:%i'), idvip FROM echanges WHERE nature = ? ORDER BY date DESC"); 
                }
                switch ($tri){
                    case 0: return "SELECT idEchange, nature, titre, description, DATE_FORMAT(date, '%d/%m/%Y'), DATE_FORMAT(date, '%H:%i'), idvip  FROM echanges ORDER BY date DESC";
                    case 1: return "SELECT idEchange, nature, titre, description, DATE_FORMAT(date, '%d/%m/%Y'), DATE_FORMAT(date, '%H:%i'), idvip  FROM echanges ORDER BY date DESC";
                    case 2: return "SELECT idEchange, nature, titre, description, DATE_FORMAT(date, '%d/%m/%Y'), DATE_FORMAT(date, '%H:%i'), idvip  FROM echanges ORDER BY date ASC";
                }
            }
        }
    }
    
    function deleteEchange($idechange){
        $stmt = $this->bdd->prepare("DELETE FROM echanges WHERE idEchange  = ?");
        if($stmt->execute(array($idechange))){
            return true;
        }else{
            return false;
        }
    }
    
    function getDateForm($idEchange){
        $stmt = $this->bdd->prepare("SELECT DATE_FORMAT(date, '%Y-%m-%d') FROM echanges WHERE idEchange = ?");
        $stmt->execute(array($idEchange));
        return $stmt->fetch()[0];
    }
    
    function editEchange($nature, $titre, $description, $date, $idvip, $idEchange){
        $stmt = $this->bdd->prepare("UPDATE echanges SET nature = ?, titre = ?, description = ?, date = ?, idvip = ? WHERE idEchange = ?");
        if($nature == 1){
            $typeEchange = "SMS";
        }
        if($nature == 2){
            $typeEchange = "Mail";
        }
        if($nature == 3){
            $typeEchange = "Appel";
        }
        if($stmt->execute(array($typeEchange, $titre, $description, $date, $idvip, $idEchange))){
            return true;
        }else{
            return false;
        }
    }
    
    function addEchange($nature, $titre, $description, $date, $idvip){
        $stmt = $this->bdd->prepare("INSERT INTO echanges (nature, titre, description, date, idvip) VALUES (?,?,?,?,?)");
        if($nature == 1){
            $typeEchange = "SMS";
        }
        if($nature == 2){
            $typeEchange = "Mail";
        }
        if($nature == 3){
            $typeEchange = "Appel";
        }
        if($stmt->execute(array($typeEchange, $titre, $description, $date, $idvip))){
            return true;
        }else{
            return false;
        }
    }
}
