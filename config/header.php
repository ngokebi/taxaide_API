<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With, Authorization, Origin");
header("Access-Control-Allow-Credentials: true");
//Security will update later
header("X-Frame-Options: deny");
header("X-Content-Type-Options: nosniff");

class Utility
{
    public static function ValidateEmpty($datas, $expectedFields, $optionalfields)
    {
        $DataMissing = 200;
        global $genericdata;
        $DataMissingarray = array();
        $sentFields = array();
        for ($i = 0; $i < count($datas); $i++) {
            $keys = array_keys($datas);
            $key = $keys[$i];
            $value = $datas[$key];
            array_push($sentFields, $key);
            $w = array_search($key, $optionalfields);
            $v = array_search($key, $expectedFields);
            if (str_replace(' ', '', $value) == "") {
                if ($w === false && $v !== false) {
                    array_push($DataMissingarray, $key);
                    $DataMissing =  implode(",", $DataMissingarray);
                }
            } elseif ($v !== false) {
                $genericdata[$key] = $value;
            }
        }
        $missingFieldarray = array_diff($expectedFields, $sentFields);
        $missingFields =  implode(",", $missingFieldarray);
        array_push($DataMissingarray, $missingFields);
        $DataMissing =  implode(",", $DataMissingarray);
        return $DataMissing;
    }
}
