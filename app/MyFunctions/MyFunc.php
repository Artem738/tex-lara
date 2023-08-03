<?php

namespace App\MyFunctions;

class MyFunc
{

    public static function parseCont(string $r, string $leftString, string $rightString): array
    {
        $results = [];
        $r2 = explode($leftString, $r);

        for ($i = 1; $i < count($r2); $i++) {
            $strPosition = strpos($r2[$i], $rightString);

            if ($strPosition !== false) {
                $result = substr($r2[$i], 0, $strPosition);
                $results[] = $result;
            }
        }

        if (empty($results)) {
            return [];
        } else {
            return $results;
        }
    }

    public static function urlToFileName(string $url): string
    {
        $urlWithoutProtocol = str_replace(env('PARS_TARGET_URL'), '', $url);
        $fileName = str_replace('/', '_', $urlWithoutProtocol);
        return $fileName.'.txt';
    }

    public static function fileNameToUrl(string $fileName): string
    {
        $urlWithoutProtocol = str_replace('_', '/', $fileName);
        $url = env('PARS_TARGET_URL') . $urlWithoutProtocol;
        return str_replace('.txt', '', $url) ;
    }

}
