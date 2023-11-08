<?php

namespace App\Helpers;

use Exception;

class StringHelper
{
    public static function formatPurposeString($inputString): string
    {
        return implode(';', array_map(function ($item) {
            return mb_convert_case(trim($item), MB_CASE_TITLE, 'UTF-8');
        }, explode(';', $inputString)));
    }

    public static function convertToUtf8($string)
    {
        // Визначаємо кодування всієї рядка
        $encoding = mb_detect_encoding($string, 'UTF-8, ISO-8859-1, Windows-1251', true);

        // Якщо кодування не UTF-8, конвертуємо весь рядок
        if ($encoding !== 'UTF-8') {
            $string = mb_convert_encoding($string, 'UTF-8', $encoding);
            echo "Кодировка изменена на UTF-8" . PHP_EOL;
        }

        return $string;
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
            throw new Exception('Некорректные данные: строка содержит закодированные Unicode символы');
        }

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
        $encodings = ['ASCII', 'UTF-8'];
        $encoding = mb_detect_encoding($string, $encodings, true);

        return $encoding ?: 'Unknown';
    }


    public static function parseTaggedString(string $taggedData): string
    {
        // Замінюємо HTML сутності та зайві символи однією операцією
        $search = ['&nbsp;', '&#x433;', '&#x440;', '&#x43D;'];
        $taggedData = str_replace($search, ' ', $taggedData);
        // Скорочуємо декілька пробілів до одного
        $taggedData = preg_replace('/\s+/', ' ', $taggedData);
        // Обробляємо вміст між тегами
        $taggedData = MyHelper::parseContMulti($taggedData, '>', '<');
        // Якщо taggedData - це масив, перетворюємо його в рядок
        if (is_array($taggedData)) {
            $taggedData = static::convertArrayToString($taggedData);
        } else {
            $taggedData = trim($taggedData);
        }

        return $taggedData;
    }

    public static function ucfirst(string $string): string
    {
        return mb_strtoupper(mb_substr($string, 0, 1)) . mb_substr($string, 1);
    }

    public static function convertArrayToString(array $array): string
    {
        $resultString = "";
        $arraySize = sizeof($array);

        for ($i = 0; $i < $arraySize; $i++) {
            $trimmedValue = trim($array[$i]);
            if (strlen($trimmedValue) > 2) {
                $resultString .= $trimmedValue;
                if ($i < $arraySize - 1) {
                    $resultString .= ";";
                }
            }
        }

        return $resultString;
    }




    public static function megaTrim(string $csvData): string
    {
        $csvData = trim($csvData);
        // Спецвимволы типа &nbsp;  убираются, но возможно..., это не всегда надо наверно, возможно нужно только для $name и $description ...
        $csvData = htmlspecialchars_decode($csvData);
        $csvData = preg_replace("/[\t\r\n]+| {2,}/", " ", $csvData); // Заміняє один або більше табів, символів переводу рядка, повернення каретки, або два або більше пробілів на один пробіл
        $csvData = str_replace(" ", "", $csvData);                  // Заміняє всі вертикальні лінії на дефіс
        $csvData = str_replace("|", "-", $csvData);                  // Заміняє всі вертикальні лінії на дефіс
        return $csvData;
    }
}
