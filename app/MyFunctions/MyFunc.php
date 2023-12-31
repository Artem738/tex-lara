<?php

namespace App\MyFunctions;



use Carbon\Carbon;

class MyFunc
{
    public static function hello(): void
    {
        echo PHP_EOL;
        echo PHP_EOL;
        echo "___________               _____          __    _________            .___       " . PHP_EOL;
        echo "\_   _____/_ __  ____    /  _  \________/  |_  \_   ___ \  ____   __| _/____   " . PHP_EOL;
        echo " |    __)|  |  \/    \  /  /_\  \_  __ \   __\ /    \  \/ /  _ \ / __ |/ __ \  " . PHP_EOL;
        echo " |     \ |  |  /   |  \/    |    \  | \/|  |   \     \___(  <_> ) /_/ \  ___/  " . PHP_EOL;
        echo " \___  / |____/|___|  /\____|__  /__|   |__|    \______  /\____/\____ |\___  > " . PHP_EOL;
        echo "     \/             \/         \/                      \/            \/    \/  " . PHP_EOL;

        echo "              #####################################" . PHP_EOL;
        echo "              #        " . Carbon::now() . "        #" .PHP_EOL;
        echo "              #####################################" . PHP_EOL;
        echo PHP_EOL;
    }

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
        return $fileName . '.txt';
    }

    public static function fileNameToUrl(string $fileName): string
    {
        $urlWithoutProtocol = str_replace('_', '/', $fileName);
        $url = env('PARS_TARGET_URL') . $urlWithoutProtocol;
        return str_replace('.txt', '', $url);
    }

    public static function parseContMulti($r, $leftString, $rightString)
    {
        $urls = [];
        $r2 = explode($leftString, $r);
        for ($i = 1; $i < sizeof($r2); $i++) {
            $strpos = strpos($r2[$i], $rightString);
            $result = substr($r2[$i], 0, $strpos);
            if ($result) {
                $urls[] = $result;
            }
        }
        if (!$urls) {
            return false;
        } else {
            if (!$urls) {
                return false;
            } else {
                if (sizeof($urls) > 1) {
                    return $urls;
                } else {
                    $urls = $urls[0];
                    return $urls;
                }
            }
        }
    }


    public static function writeMapToFileTsv($dataMap, $resultDataTsvFilePath)
    {

        $lineString = "";

        foreach ($dataMap as $key => $value) {
            $value = str_replace("\t", " ", $value);
            $lineString = $lineString . $value . "\t";
        }
        file_put_contents($resultDataTsvFilePath, $lineString . PHP_EOL, FILE_APPEND | LOCK_EX);

    }




}
