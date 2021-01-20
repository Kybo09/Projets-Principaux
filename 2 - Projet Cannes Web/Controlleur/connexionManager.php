<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ConnexionManager
 *
 * @author benoi
 */
class ConnexionManager {
    private $bdd;

    function __construct($host,$db,$user,$pwd) {
        try {
            $this->bdd = new PDO("mysql:host=".$host.';dbname='.$db.';charset=utf8', $user,$pwd);
        } catch (Exception $e) {
            exit('Erreur : '.$e->getMessage());
        }
    }

    function getDB() {
        return $this->bdd;
    }
    
    function login($username, $password){
        $stmt = $this->bdd->prepare("SELECT  *  FROM staff WHERE nom = ? AND  password  = ?");
	$stmt->execute(array($username, $password));
	if($stmt->rowCount() >=  1){
            return  true;
	}else{
            return  false;
	}
    }
}
