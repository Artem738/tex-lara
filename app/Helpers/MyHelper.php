<?php

namespace App\Helpers;

use Carbon\Carbon;

class MyHelper
{
    public static function hello(): void
    {
        $artFile = __DIR__ . '/../../config/hello_art.txt';
        $art = file_get_contents($artFile);

        $art .= "              #####################################" . PHP_EOL;
        $art .= "              #       " . self::getCurrentDateTime() . "       #" . PHP_EOL;
        $art .= "              #####################################" . PHP_EOL;
        $art .= PHP_EOL;

        echo $art;
    }

    public static function parseCont(string $r, string $leftString, string $rightString): array
    {
        $results = [];
        $start = 0;
        while (($start = strpos($r, $leftString, $start)) !== false) {
            $start += strlen($leftString);
            $end = strpos($r, $rightString, $start);
            if ($end !== false) {
                $results[] = substr($r, $start, $end - $start);
            } else {
                break;
            }
        }
        return $results;
    }

    public static function urlToFileName(string $url): string
    {
        $parsedUrl = parse_url($url);
        $path = ltrim($parsedUrl['path'], '/');
        return str_replace('/', '_', $path) . '.txt';
    }

    public static function fileNameToUrl(string $fileName): string
    {
        $path = str_replace('_', '/', $fileName);
        return rtrim(env('PARS_TARGET_URL'), '/') . '/' . ltrim($path, '/');
    }

    public static function parseContMulti($r, $leftString, $rightString)
    {
        $results = static::parseCont($r, $leftString, $rightString);
        return count($results) === 1 ? $results[0] : $results;
    }

    public static function writeMapToFileTsv($dataMap, $resultDataTsvFilePath)
    {
        // Assuming $dataMap is an array of arrays, where each child array represents a line.
        foreach ($dataMap as $lineData) {
            // We're using array_map here to ensure each value is a string and tabs are replaced
            $line = implode("\t", array_map(function ($value) {
                return str_replace("\t", ' ', (string)$value);
            }, $lineData));

            // Write the line to the file with a trailing newline
            file_put_contents($resultDataTsvFilePath, $line . PHP_EOL, FILE_APPEND | LOCK_EX);
        }
    }

    public static function resolvePattern(string $type, string $word): string
    {
        return ($type == "Однотонный") ? $word : $type . ";" . $word;
    }
}
