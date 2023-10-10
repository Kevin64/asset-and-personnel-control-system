<?php

function gatherJsonTypes($json, $param1, $param2) {
    if($param2 != null) {
        return $array = $json[$param1][$param2];
    }
    else {
        return $array = $json[$param1];
    }

}

function floordec($zahl,$decimals=2){    
    return floor($zahl*pow(10,$decimals))/pow(10,$decimals);
}