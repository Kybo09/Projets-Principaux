<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of actionManager
 *
 * @author benoi
 */
class actionManager {
    
    private $bdd;
    
    function __construct($bdd) {
        $this->bdd = $bdd;
    }
    
    function setBdd($bdd): void {
        $this->bdd = $bdd;
    }
    
    function getActionInfo($idAction){
        $action = $this->bdd->prepare("SELECT idAction, titre, description, DATE_FORMAT(date, '%d/%m/%Y'), DATE_FORMAT(date, '%H:%i'), idvip  FROM actions WHERE idAction = ? ORDER BY date DESC");
        $action->execute(array($idAction));
        $actionobj = array();
        if($actiondata = $action->fetch()){
            $actionobj = new actions($actiondata[0], $actiondata[1], $actiondata[2], $actiondata[3], $actiondata[4], $actiondata[5]);
        } 
        
        return $actionobj;
    }
    
    function getActionInfobyVip($idVip){
        $action = $this->bdd->prepare("SELECT idAction, titre, description, DATE_FORMAT(date, '%d/%m/%Y'), DATE_FORMAT(date, '%H:%i'), idvip  FROM actions WHERE idVip = ? ORDER BY date DESC");
        $action->execute(array($idVip));
        $actionobj = array();
        if($actiondata = $action->fetch()){
            $actionobj = new actions($actiondata[0], $actiondata[1], $actiondata[2], $actiondata[3], $actiondata[4], $actiondata[5]);
        }        
        return $actionobj;
    }
    
    function getAllActions($tri, $idVip, $search){
        $req = $this->getRequest($tri, $idVip, $search);
        $stmt = $this->bdd->prepare($req);
        if(strcmp($req, "SELECT idAction, titre, description, DATE_FORMAT(date, '%d/%m/%Y'), DATE_FORMAT(date, '%H:%i'), idvip  FROM actions WHERE titre LIKE ?") == 0){
            $stmt->execute(array('%'.$search.'%'));
        }else{
            if(strcmp($req, "SELECT idAction, titre, description, DATE_FORMAT(date, '%d/%m/%Y'), DATE_FORMAT(date, '%H:%i'), idvip  FROM actions WHERE idvip = ?") == 0){
                $stmt->execute(array($idVip));
            }else{
                $stmt->execute();
            }            
        }
        $i = 0;
        $listeActions = array();
        while($data = $stmt->fetch()){
            $listeActions[$i] = new actions($data[0], $data[1], $data[2], $data[3], $data[4], $data[5]);
            $i = $i + 1;
        }
        return $listeActions;
    }
    
    function getRequest($tri, $idVip, $search){
        if(strcmp ($search, "") !== 0){
            return "SELECT idAction, titre, description, DATE_FORMAT(date, '%d/%m/%Y'), DATE_FORMAT(date, '%H:%i'), idvip  FROM actions WHERE titre LIKE ?";
        }else{
            if($idVip != -1){
                return "SELECT idAction, titre, description, DATE_FORMAT(date, '%d/%m/%Y'), DATE_FORMAT(date, '%H:%i'), idvip  FROM actions WHERE idvip = ?";
            }else{
                switch ($tri){
                    case 0: return "SELECT idAction, titre, description, DATE_FORMAT(date, '%d/%m/%Y'), DATE_FORMAT(date, '%H:%i'), idvip  FROM actions ORDER BY date DESC";
                    case 1: return "SELECT idAction, titre, description, DATE_FORMAT(date, '%d/%m/%Y'), DATE_FORMAT(date, '%H:%i'), idvip  FROM actions ORDER BY date DESC";
                    case 2: return "SELECT idAction, titre, description, DATE_FORMAT(date, '%d/%m/%Y'), DATE_FORMAT(date, '%H:%i'), idvip  FROM actions ORDER BY date ASC";
                }
            }
        }
    }
    
    function deleteAction($idAction){
        $stmt = $this->bdd->prepare("DELETE FROM actions WHERE idAction = ?");
        if($stmt->execute(array($idAction))){
            return true;
        }else{
            return false;
        }
    }
    
    function getDateForm($idAction){
        $stmt = $this->bdd->prepare("SELECT DATE_FORMAT(date, '%Y-%m-%d') FROM actions WHERE idAction = ?");
        $stmt->execute(array($idAction));
        return $stmt->fetch()[0];
    }
    
    function editAction($titre, $description, $date, $idvip, $idaction){
        $stmt = $this->bdd->prepare("UPDATE actions SET titre = ?, description = ?, date = ?, idvip = ? WHERE idAction = ?");
        if($stmt->execute(array($titre, $description, $date, $idvip, $idaction))){
            return true;
        }else{
            return false;
        }
    }
    
    function addAction($titre, $description, $date, $idvip){
        $stmt = $this->bdd->prepare("INSERT INTO actions (titre, description, date, idvip) VALUES (?,?,?,?)");
        if($stmt->execute(array($titre, $description, $date, $idvip))){
            return true;
        }else{
            return false;
        }
    }
}

