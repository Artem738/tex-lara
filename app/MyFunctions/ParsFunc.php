<?php

namespace App\MyFunctions;

use Exception;

class ParsFunc
{




    public static function formatPurposeString($inputString): string
    {
        $items = explode(';', $inputString);
        $newItems = [];
        foreach ($items as $item) {
            // $item = trim($item);
            $item = trim($item);
            $newItems[] = mb_convert_case($item, MB_CASE_TITLE, 'UTF-8');
            //ucfirst(strtolower(trim($item)));
        }
        //print_r($newItems);
        //echo( ).PHP_EOL;
        return implode(';', $newItems);
    }


    public static function convertToUtf8($string)
    {
        // Подключаем расширение mbstring
        if (!extension_loaded('mbstring')) {
            die('Расширение mbstring не установлено. Установите его для корректной работы с кодировками.');
        }

        $result = '';

        // Перебираем каждый символ в строке
        for ($i = 0; $i < mb_strlen($string); $i++) {
            $character = mb_substr($string, $i, 1);

            // Определяем кодировку символа
            $encoding = mb_detect_encoding($character, 'UTF-8, ISO-8859-1, Windows-1251', true);

            // Если кодировка не UTF-8, преобразуем символ в UTF-8
            if ($encoding !== 'UTF-8') {
                $oldCar = $character;
                $character = mb_convert_encoding($character, 'UTF-8', $encoding);
                echo "Символ: " . $oldCar . ", Кодировка: " . $encoding . "исправлено на - " . $character . PHP_EOL;
            }

            // Добавляем символ в результат
            $result .= $character;
        }

        return $result;
    }


    /**
     * Проверяет кодировку каждого символа в строке и выводит информацию о ней.
     *
     * @param string $string Строка для проверки кодировки символов.
     */
    public static function detectAndEchoCharacterEncodings($string)
    {
        // Подключаем расширение mbstring
        if (!extension_loaded('mbstring')) {
            die('Расширение mbstring не установлено. Установите его для корректной работы с кодировками.');
        }

        // Перебираем каждый символ в строке
        for ($i = 0; $i < mb_strlen($string); $i++) {
            $character = mb_substr($string, $i, 1);

            // Определяем кодировку символа
            $encoding = mb_detect_encoding($character, 'UTF-8, ISO-8859-1, Windows-1251', true);

            // Выводим информацию о кодировке
            if ($encoding != 'UTF-8') {
                echo "Символ: " . $character . ", Кодировка: " . $encoding . PHP_EOL;
                die();
            }
        }
    }

    public static function detectEncoding($data)
    {
        $encodings = ['UTF-8', 'ISO-8859-1', 'ISO-8859-5', 'Windows-1251']; // Добавьте другие возможные кодировки, которые используются в вашей системе
        foreach ($encodings as $encoding) {
            if (mb_detect_encoding($data, $encoding, true) === $encoding) {
                return $encoding;
            }
        }
        return 'UNKNOWN'; // Если не удалось определить кодировку
    }

    public static function filterData($data)
    {
        //$data = mb_convert_decoding($data, 'UTF-8', 'Unicode');
        //$data = utf8_encode($data);
        $data = mb_convert_encoding($data, 'UTF-8', 'HTML-ENTITIES');

        // Проверяем, является ли строка закодированным Unicode
        if (preg_match('/\\\\u([0-9a-f]{4})/i', $data)) {
            // Если строка содержит кодированные Unicode символы, выбрасываем исключение
            //throw new Exception('Некорректные данные: строка содержит закодированные Unicode символы');
            die("WWWWWWWWWWW $$data");
        }

        // Другие фильтры и исправления данных, если необходимо...

        return $data;
    }

    function detectCharacterEncoding($character)
    {
        // Подключаем расширение mbstring
        if (!extension_loaded('mbstring')) {
            die('Расширение mbstring не установлено. Установите его для корректной работы с кодировками.');
        }

        // Определяем кодировку символа
        $encoding = mb_detect_encoding($character, 'UTF-8, ISO-8859-1, Windows-1251', true);

        // Если кодировка не определена, возвращаем "Unknown"
        if (!$encoding) {
            return "Unknown";
        }

        return $encoding;
    }

    public static function detectCharacterLetterEncoding($string): string
    {
        $length = strlen($string);
        $is_utf8 = true;
        $is_ascii = true;

        for ($i = 0; $i < $length; $i++) {
            $char = ord($string[$i]);

            // Check for UTF-8 characters
            if ($char >= 128) {
                $is_ascii = false;
                if ($char >= 194 && $char <= 244) {
                    if ($char == 194 && $i < $length - 1 && ord($string[$i + 1]) >= 160 && ord($string[$i + 1]) <= 191) {
                        // Valid UTF-8 character
                        $i++;
                    } elseif ($char == 195 && $i < $length - 1 && ord($string[$i + 1]) >= 128 && ord($string[$i + 1]) <= 191) {
                        // Valid UTF-8 character
                        $i++;
                    } elseif ($char >= 224 && $i < $length - 2 && ord($string[$i + 1]) >= 128 && ord($string[$i + 1]) <= 191 && ord($string[$i + 2]) >= 128 && ord($string[$i + 2]) <= 191) {
                        // Valid UTF-8 character
                        $i += 2;
                    } elseif ($char >= 240 && $i < $length - 3 && ord($string[$i + 1]) >= 128 && ord($string[$i + 1]) <= 191 && ord($string[$i + 2]) >= 128 && ord($string[$i + 2]) <= 191 && ord($string[$i + 3]) >= 128 && ord($string[$i + 3]) <= 191) {
                        // Valid UTF-8 character
                        $i += 3;
                    } else {
                        $is_utf8 = false;
                        break;
                    }
                } else {
                    $is_utf8 = false;
                    break;
                }
            }
        }

        if ($is_utf8) {
            return 'UTF-8';
        } elseif ($is_ascii) {
            return 'ASCII';
        } else {
            return 'Unknown';
        }
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
