<?php

use App\Console\ParseData\Parsers\Corrector;

$additionalRules = [
    "/ "                        => "",
    "("                         => "",
    "ДВОЙНОЙ ДАБЛ"              => "",
    "СПАНДЕКС6%"                => "СПАНДЕКС 6%",
    "РАЙОН18%"                  => "РАЙОН 18%",
    "ОРГАНЗА СОСТАВ ТЕНСЕЛ 66%" => "ТЕНСЕЛ 66%",

];

return new Corrector(
    [
        "ШОВК"            => "ШЕЛК",
        "ДАБЛКАШЕМИР"     => "",
        " ДАБЛ (ДВОЙНОЙ)" => "",
        "ECONYL"          => "ЭКОНИЛ",
        "TERYLENE"        => "ТЕРИЛЕН",
        "COTTON"          => "ХЛОПОК",
        "SPANDEX"         => "СПАНДЕКС",
        "RAYON"           => "РАЙОН",
        "; "              => "(",
        "( "              => "(",
        " )"              => ")",
        "(ХЛОПОК)"        => "",
        "ОРГАНИКА"        => "",
        "КОТОН"           => "ХЛОПОК",
        "КОТТОН"          => "ХЛОПОК",
        "ПОЛИЄСТЕР"       => "ПОЛИЭФИР",
        "ПОЛИЭСТЕР"       => "ПОЛИЭФИР",
        "ПОЛИЕСТЕР"       => "ПОЛИЭФИР",
        "ПОЛИУРEТАН"      => "ПОЛИУРЕТАН",
        "ЄЛАСТАН"         => "СПАНДЕКС",
        "ЭЛАСТАН"         => "СПАНДЕКС",
        "ЕЛАСТАН"         => "СПАНДЕКС",
        ";"               => "",
        ". "              => "",
        "% ,"             => "%",
        "%,"              => "%",
        "%"               => "%,",
        ","               => ";",
        "100%;ПОЛИЭФИР"   => "ПОЛИЭФИР 100%",
    ],
    postHandler: function (string $content) use ($additionalRules) {
        $content = rtrim($content, ";");

        $items = explode(';', $content);
        $newItems = [];
        foreach ($items as $item) {

            if (stripos($item, "NBSP") === false) {
                foreach ($additionalRules as $search => $replace) {
                    $item = str_replace($search, $replace, $item);
                }
                $newItems[] = $item;
            }

        }
        $content = implode(';', $newItems);
        return rtrim($content, ";");
    },
    preHandler: function (string $content) {
        return mb_strtoupper($content);
    }
);
