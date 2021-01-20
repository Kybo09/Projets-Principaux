<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RedirectController
 *
 * @author benoi
 */
class RedirectManager {
    
    function getVipSearchUrlRedirect($search, $tri){
        if($search != ""){
            return "listVip.php?search=".$search;
        }else{
            if($tri != ""){
                return "listVip.php?tri=".$tri;
            }else{
                return "listVip.php";
            }
        }
    }
    
    function getActionSearchUrlRedirect($search, $idvip, $tri){
        if($search != ""){
            return "listActions.php?search=".$search;
        }else{
            if($ivdip != ""){
                return "listActions.php?searchVip=".$idvip;
            }else{
                if($tri != ""){
                    return "listActions.php?tri=".$tri;
                }else{
                    return "listActions.php";
                }
            }
        }
    }
    
    function getEchangeSearchUrlRedirect($search, $idvip, $type, $tri){
        if($search != ""){
            return "listEchanges.php?search=".$search;
        }else{
            if($ivdip != ""){
                return "listEchanges.php?searchVip=".$idvip;
            }else{
                if($type != ""){
                    return "listEchanges.php?type=".$type;
                }else{
                    if($tri != ""){
                        return "listEchanges.php?tri=".$tri;
                    }else{
                        return "listEchanges.php";
                    }
                }
            }
        }
    }
}
