<?php

namespace App\MyFunctions;

class ParsFunc
{

    public static function parseTaggedString($taggedData)
    {

        $taggedData = str_replace('&nbsp;', ' ', $taggedData);
        $taggedData = str_replace('&#x433;', '', $taggedData);
        $taggedData = str_replace('&#x440;', '', $taggedData);
        $taggedData = str_replace('&#x43D;', '', $taggedData);

        $taggedData = MyFunc::parseContMulti($taggedData, '>', '<');
        $returnString = "";

        if (is_array($taggedData)) {
            for ($i = 0; $i < sizeof($taggedData); $i++) {
                $taggedData[$i] = trim($taggedData[$i]);
                if (strlen($taggedData[$i]) > 2) {
                    $returnString = $returnString . $taggedData[$i];
                    if ($i != sizeof($taggedData) - 1) {
                        $returnString = $returnString . ";";
                    }
                }
            }
        } else {
            $returnString = trim($taggedData);
        }

        return $returnString;
    }

    public static function fabricStructureCorrector($retStr)
    {


        // Work fine :)  but looks strange ))
        $retStr = mb_strtoupper($retStr);
        $retStr = str_replace("( ", "(", $retStr);
        $retStr = str_replace(" )", ")", $retStr);
        $retStr = str_replace("(ХЛОПОК)", "", $retStr);
        $retStr = str_replace("ОРГАНИКА", "", $retStr);
        $retStr = str_replace("КОТОН", "ХЛОПОК", $retStr);
        $retStr = str_replace("КОТТОН", "ХЛОПОК", $retStr);
        $retStr = str_replace("ПОЛИЄСТЕР", "ПОЛИЭФИР", $retStr);
        $retStr = str_replace("ПОЛИЭСТЕР", "ПОЛИЭФИР", $retStr);
        $retStr = str_replace("ПОЛИЕСТЕР", "ПОЛИЭФИР", $retStr);
        $retStr = str_replace("ПОЛИУРEТАН", "ПОЛИУРЕТАН", $retStr);
        $retStr = str_replace("ЭЛАСТАН", "СПАНДЕКС", $retStr);
        $retStr = str_replace("ЭЛАСТАН", "СПАНДЕКС", $retStr);
        $retStr = str_replace("ЕЛАСТАН", "СПАНДЕКС", $retStr);
        $retStr = str_replace(";", "", $retStr);
        $retStr = str_replace(". ", "", $retStr);
        $retStr = str_replace("% ,", "%", $retStr);
        $retStr = str_replace("%,", "%", $retStr);
        $retStr = str_replace("%", "%,", $retStr);
        $retStr = str_replace(",", ";", $retStr);
        $retStr = preg_replace('/[\s]+/mu', ' ', $retStr);

        $retStr = rtrim($retStr, ";");

        //print($retStr. '<br>');
        return $retStr;
    }




}
