<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of imageManager
 *
 * @author benoi
 */
class imageManager {
    
    function addImage($tmp, $name){
        $target_dir = "../images/pp/";
            $target_file = $target_dir . basename($name);
            
            $uploadOk = 1;
            
            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

            $check = getimagesize($tmp);
            if($check !== false) {
                $uploadOk = 1;
            } else {
                $uploadOk = 0;
            }
            
            
            if($imageFileType != "jpg" &&$imageFileType != "JPG"&& $imageFileType != "png" && $imageFileType != "PNG" && $imageFileType != "jpeg" && $imageFileType != "JPEG" && $imageFileType != "gif" && $imageFileType != "GIF") {
                $uploadOk = 0;
            }
            
            if ($uploadOk == 0) {
                echo '';

            } else {
                if (move_uploaded_file($tmp, $target_file)) {
                    echo '';
                } else {
                    $message = "Erreur inconnue! Merci de retenter l'ajout plus tard ou de contacter l'administrateur.";
                    echo $message;
                }
            }
    }
}
