<?php

namespace App\MyFunctions;

use Exception;

class ParsFunc
{

    public static function filterData($data)
    {
        // Проверяем, является ли строка закодированным Unicode
        if (preg_match('/\\\\u([0-9a-f]{4})/i', $data)) {
            // Если строка содержит кодированные Unicode символы, выбрасываем исключение
            throw new Exception('Некорректные данные: строка содержит закодированные Unicode символы');
        }

        // Другие фильтры и исправления данных, если необходимо...

        return $data;
    }


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

    public static function categoryCorrector($retStr): string
    {


        // Work fine :)  but looks strange ))

        $retStr = str_replace("джинсовая ткань", "Джинсовая ткань", $retStr);
        $retStr = str_replace("Ткань для нижнего белья", "Ткани для нижнего белья", $retStr);
        $retStr = str_replace("Подкладочные", "Подкладочная ткань", $retStr);
        $retStr = str_replace("ткани для плащевок (плащей)", "Ткани для плащевок (плащей)", $retStr);
        $retStr = str_replace("Hовое*", "Hовое", $retStr);


        $retStr = rtrim($retStr, ";");

        //print($retStr. '<br>');
        return $retStr;
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


    public static function megaTrim($csvdata)
    {
        $csvdata = trim($csvdata);
        // Спецвимволы типа &nbsp;  убираются, но возможно..., это не всегда надо наверно, возможно нужно только для $name и $description ...
        $csvdata = htmlspecialchars_decode($csvdata);

        $csvdata = str_replace("\t\t", "\t", $csvdata);
        $csvdata = str_replace("\t\t", "\t", $csvdata);
        $csvdata = str_replace("\t\t", "\t", $csvdata);
        $csvdata = str_replace("\n", " ", $csvdata);
        $csvdata = str_replace("\r", " ", $csvdata);
        $csvdata = str_replace("&#13;", " ", $csvdata);
        $csvdata = str_replace("  ", " ", $csvdata); // уберем двойные пробелы
        $csvdata = str_replace("  ", " ", $csvdata);
        $csvdata = str_replace("  ", " ", $csvdata);
        $csvdata = str_replace("  ", " ", $csvdata);
        $csvdata = str_replace("  ", " ", $csvdata);
        $csvdata = str_replace("  ", " ", $csvdata);
        $csvdata = str_replace("  ", " ", $csvdata);
        $csvdata = str_replace("  ", " ", $csvdata);

        $csvdata = str_replace("  ", " ", $csvdata);
        $csvdata = str_replace("	", " ", $csvdata); //уберем табуляторы
        $csvdata = str_replace("|", "-", $csvdata);
        return $csvdata;
    }




}
