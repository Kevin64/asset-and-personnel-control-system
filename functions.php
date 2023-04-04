<?php

function gatherJsonTypes($json, $param1, $param2) {
    if($param2 != null) {
        return $array = $json[$param1][$param2];
    }
    else {
        return $array = $json[$param1];
    }

}
