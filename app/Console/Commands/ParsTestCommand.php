<?php

namespace App\Console\Commands;

use App\Console\ParseData\ProductParserObject;
use App\MyFunctions\ParsFunc;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\MyFunctions\MyFunc;
use PHPUnit\Event\Runtime\PHP;

class ParsTestCommand extends Command
{
    protected $signature = 'pars:test';
    protected $description = 'Pars Test Command description';

    /**
     * Execute the console command.
     */
    private string $allUrlsFilePath = 'pars_data/all_urls.txt';
    private string $productPagesPath = 'pars_data/pages/'; // with /

    /**
     * @throws \Exception
     */
    public function handle()
    {
        MyFunc::hello();
        $allUrls = explode("\n", Storage::get($this->allUrlsFilePath));

        //$this->output->progressStart(sizeof($allUrls));
        $allMadeIns = [];
        $allCategoryAll = [];
        $allPurpose = [];
        $allFabricTones = [];
        $allPatterns = [];

        for ($i = 0; $i < count($allUrls) - 1; $i++) {  //463

            echo($i . ' ' . $allUrls[$i] . " parsing start - ");
            $fileHtmlString = Storage::get($this->productPagesPath . MyFunc::urlToFileName($allUrls[$i]));
            $prod = new ProductParserObject($fileHtmlString, $allUrls[$i]);

            if (!$prod->checkData()) {
                echo($prod); // __toString
                //die();
            }
            //echo($prod).PHP_EOL;
            $this->info($i . " - good - " . $allUrls[$i] . " - good");
            //echo($prod);
            $allMadeIns[] = $prod->madeIn;
            $allCategoryAll[] = $prod->categoryAll;
            $allPurpose[] = $prod->purpose;
            $allFabricTones[] = $prod->fabricTone;
            $allPatterns[] = $prod->patternType;


            /// CHEKING NON NULL DATA
            if ($prod->sku == null) {
                $this->error($prod->goodUrl . " -  sku");
                die();
            }
            if ($prod->title == null) {
                $this->error($prod->goodUrl . " -  title");
                die();
            }
            if ($prod->categoryAll == null) {
                $this->error($prod->goodUrl . " -  categoryAll");
                die();
            }

            if ($prod->rollWidth == null) {
                // $this->alert($prod->goodUrl . " -  rollWidth");
                //die();
            }

            if ($prod->fabricTone == null) {
                // $this->alert(" -  fabricTone  - " . $prod->goodUrl);
                //die();
            }
//            if ($prod->description == null) {
//                $this->error(" -  description  - " . $prod->goodUrl);
//                die();
//            }
            if ($prod->price == null) {
                $this->error(" -  price $$  - " . $prod->goodUrl);
                //echo($prod);
                //die();
            }
            //echo($prod->price);

            if ($prod->sku == "") {
                // echo($prod);
                // die();
            }

            if ($prod->price != $prod->regularPrice) {
                $this->info($prod->price . ' $prod->price != $prod->regularPrice ' . $prod->regularPrice);
            }

            //$this->alert($prod->similarProducts);
            if (!$this->checkPurposeOrDie($prod->purpose)) {
                $this->alert($prod->goodUrl) . PHP_EOL;
            }            //$this->alert($prod->similarProducts);
//            if (stripos($prod->fabricStructure, "100") && stripos($prod->fabricStructure, "ПОЛИЭФИР")) {
//                $this->alert($prod->goodUrl) . PHP_EOL;
//                die();
//            }
            if (!$this->parseAndCheckPercentages($prod->fabricStructure)) {
                $this->alert($prod->fabricStructure) . PHP_EOL;
                die($prod->goodUrl);
            }

        }
        // Вывод статистики
//        $madeInStats = $this->countMadeInStats($allMadeIns);
//        $categoryStats = $this->countSemicolonArrayStats($allCategoryAll);
//        $purposeStats = $this->countSemicolonArrayStats($allPurpose);
//showAssociativeArrayForArray

        //print_r($this->getUniqueFabricsNames($allFabricStructure));
        //print_r($this->countSemicolonArrayStats($allFabricStructure));

        //$this->showAssociativeArrayForArray($this->countSemicolonArrayStats($allFabricStructure));

        $fabricToneStats = $this->countSemicolonArrayStats($allFabricTones);

        print_r($fabricToneStats);

        $patternStats = $this->countSemicolonArrayStats($allPatterns);

        print_r($patternStats);


    }

    ######  F U N C T I O N S ###########
    ######  F U N C T I O N S ###########
    ######  F U N C T I O N S ###########
    ######  F U N C T I O N S ###########
    ######  F U N C T I O N S ###########
    ######  F U N C T I O N S ###########

    public static function showAssociativeArrayForArray(array $data): void
    {
        ksort($data);
        $stringData = "";
        $index = 1;

        print PHP_EOL . PHP_EOL . PHP_EOL;
        foreach ($data as $name => $stat) {
            $stringData .= "['id' => " . $index . ", 'name' => '" . $name . "']," . PHP_EOL;
            $index++;
        }

        print $stringData;
    }

    public function checkFabricStructure($data)
    {

//        if(stripos ($data, "100 %")) {
//            return false;
//        }
        $exData = explode(';', $data);

        foreach ($exData as $item) {
            print($item) . PHP_EOL;
            if (stripos($item, ';100%')) {
                return false;
            }
        }
        return true;
    }

    function parseAndCheckPercentages($input)
    {
        $components = explode(";", $input);
        $totalPercentage = 0.0; // Используем double

        foreach ($components as $component) {
            $parts = explode(" ", trim($component));
            if (count($parts) === 2) {
                $percentage = doubleval($parts[1]);
                if ($percentage >= 0.0 && $percentage <= 100.0) {
                    $totalPercentage += $percentage;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
        return $totalPercentage === 100.0; // Сравниваем с double
    }

    public function getUniqueFabricsNames($dataArray)
    {
        $uniqueArray = array();

        foreach ($dataArray as $line) {
            $fabricsArray = explode(";", $line);
            foreach ($fabricsArray as $data) {
                $exName = explode(" ", $data);
                $exName = $exName[0];
                // echo ($exName).PHP_EOL;
                if (isset($uniqueArray[$exName])) {
//                    if ($exName == "100%") {
//                        die($line);
//                    }
                    $uniqueArray[$exName]++;
                } else {
                    $uniqueArray[$exName] = 1;
                }

            }
        }
        return $uniqueArray;
    }

    public function countSemicolonArrayStats($dataArray): array
    {
        $statArray = array();
        foreach ($dataArray as $data) {
            $exData = explode(";", $data);
            foreach ($exData as $ex) {
                if (isset($statArray[$ex])) {
                    $statArray[$ex]++;
                } else {
                    $statArray[$ex] = 1;
                }
            }
        }
        // ksort($statCatAll);
        uasort(
            $statArray, function ($b, $a) {
            return $a - $b;
        }
        );
        return $statArray;
    }

    public function countMadeInStats($allMadeIns): array
    {
        $statMadeIn = array();

        foreach ($allMadeIns as $country) {
            if (isset($statMadeIn[$country])) {
                $statMadeIn[$country]++;
            } else {
                $statMadeIn[$country] = 1;
            }
        }

        return $statMadeIn;
    }

    public function checkPurposeOrDie($purpose): bool
    {
        $purposeArray = explode(';', $purpose);

        foreach ($purposeArray as $item) {
            if (empty(trim($item))) {
                return false;
            }
        }
        return true;
    }


}

