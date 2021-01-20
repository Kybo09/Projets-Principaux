<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of vipControlleur
 *
 * @author benoi
 */
class vipManager {
    
    private $bdd;
    
    function __construct($bdd) {
        $this->bdd = $bdd;
    }
    
    function setBdd($bdd): void {
        $this->bdd = $bdd;
    }

    function getAllVip($tri, $search){
        $req = $this->getRequest($tri, $search);
        $stmt = $this->bdd->prepare($req);
        if(strcmp($req, "SELECT * FROM vip WHERE prenom LIKE ? OR nom LIKE ?") == 0){
            $stmt->execute(array('%'.$search.'%','%'.$search.'%'));
        }else{
            $stmt->execute();
        }
        $i = 0;
        $listeVip = array();
        while($data = $stmt->fetch()){
            $listeVip[$i] = new vip($data[0], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], $data[8]);
            $i = $i + 1;
        }
        return $listeVip;
    }
    
    function deleteVip($idvip){
        $getUrl = $this->bdd->prepare('SELECT urlPicture FROM vip WHERE idVip = ?');
        $getUrl->execute(array($idvip));
        $url = $getUrl->fetch()[0];
        if(strcmp($url, 'images/pp/default-avatar.jpg') == 0){
            unlink("../".$url);
        }
        $stmt = $this->bdd->prepare("DELETE FROM vip WHERE idVip = ?");
        $stmt->execute(array($idvip));
    }
    
    function getPrenom($nom){
        $getPrenom = $this->bdd->prepare('SELECT  prenom  FROM staff WHERE nom = ?');
        $getPrenom->execute(array($nom));
        return  $getPrenom->fetch()[0];
    }
    
    function getRequest($tri, $search){
        if(strcmp ($search, "") !== 0){
            return "SELECT * FROM vip WHERE prenom LIKE ? OR nom LIKE ?";
        }else{
            switch ($tri){
                case 0: return "SELECT  *  FROM vip ORDER BY nom";
                case 1: return "SELECT  *  FROM vip ORDER BY prenom";
                case 2: return "SELECT  *  FROM vip ORDER BY prenom DESC";
                case 3: return "SELECT  *  FROM vip ORDER BY nom";
                case 4: return "SELECT  *  FROM vip ORDER BY nom DESC";
            }
        }
    }
    
    function getInfoVipRequest($idVip){
        $getInfo = $this->bdd->prepare("SELECT * FROM vip WHERE idVip = ?");
        $getInfo->execute(array($idVip));
        $listeInfo = array();
        if($data = $getInfo->fetch()){
          $listeInfo = new vip($data[0], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], $data[8]);  
        }
        
        $typeNumberEdit = $this->getNumberType($listeInfo->getType());
        $tableCharge = $this->getTableCharge($listeInfo->getNiveauPriseCharge());
        $namePicture = substr($listeInfo->getUrlPicture(), 10);
        
        $listeInfo->setType($typeNumberEdit);
        $listeInfo->setNiveauPriseCharge($tableCharge);
        $listeInfo->setUrlPicture($namePicture);
        
        return $listeInfo;
    }
    
    function getInfoVip($idVip){
        $getInfo = $this->bdd->prepare("SELECT * FROM vip WHERE idVip = ?");
        $getInfo->execute(array($idVip));
        $listeInfo = array();
        if($data = $getInfo->fetch()){
          $listeInfo = new vip($data[0], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], $data[8]);  
        }
        
        $tableCharge = $this->getTableCharge($listeInfo->getNiveauPriseCharge());
        $listeInfo->setNiveauPriseCharge($tableCharge);
        
        return $listeInfo;
    }
    
    function getNumberType($typeEdit){
        if($typeEdit == "acteur"){
            return 1;
        }
        if($typeEdit == "realisateur"){
            return 2;
        }
        if($typeEdit == "autre"){
            return 3;
        }
        return 0;
    }
    
    function getTableCharge($priseChargeEdit){
        if(($priseChargeEdit - 4) >= 0){
            $table[0] = 1;
            $priseChargeEdit -= 4;
        }
        if(($priseChargeEdit - 2) >= 0){
            $table[1] = 1;
            $priseChargeEdit -= 2;
        }
        if(($priseChargeEdit - 1) >= 0){
            $table[2] = 1;
            $priseChargeEdit -=1;
        }
        return $table;
    }
    
    function addVip($prenom, $nom, $nationalite, $type, $coeff, $niveau, $compagnon, $url){
        $stmt = $this->bdd->prepare("INSERT INTO vip (prenom,nom,nationalite,type,coeffImportance,niveauPriseCharge,compagnon,urlPicture) VALUES(?,?,?,?,?,?,?,?)");
        if($type == 1){
            $role = "acteur";
        }else{
            if($type == 2){
                $role = "realisateur";
            }else{
                $role = "autre";
            }
        }
        $urlcomplete = 'images/pp/'.$url;
        if($stmt->execute(array($prenom, $nom, $nationalite, $role, $coeff, $niveau, $compagnon, $urlcomplete))){
            return true;
        }else{
            return false;
        }
        
    }
    
    function editVip($prenom, $nom, $nationalite, $type, $coeff, $niveau, $compagnon, $url, $idVip){
        $stmt = $this->bdd->prepare("UPDATE vip SET prenom = ?, nom = ?, nationalite = ?, type = ?, coeffImportance = ?, niveauPriseCharge = ?, compagnon = ?, urlPicture = ? WHERE idVip = ?");
        $role = "";
        if($type == 1){
            $role = "acteur";
        }else{
            if($type == 2){
                $role = "realisateur";
            }else{
                $role = "autre";
            }
        }
        $urlcomplete = 'images/pp/'.$url;
        if($stmt->execute(array($prenom, $nom, $nationalite, $role, $coeff, $niveau, $compagnon, $urlcomplete,$idVip))){
            return true;
        }else{
            return false;
        }
    }
    
    function getPrenomById($idvip){
        $stmt = $this->bdd->prepare("SELECT nom FROM vip WHERE idVip = ?");
        $stmt->execute(array($idvip));
        $nom = $stmt->fetch();
        return $nom[0];
    }
    
    
}
