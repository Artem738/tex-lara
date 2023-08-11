<?php

namespace App\Console\Commands;

use App\Console\ParseData\ProductParserObject;
use App\MyFunctions\ParsFunc;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\MyFunctions\MyFunc;

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

        for ($i = 0; $i < count($allUrls) - 1; $i++) {  //463

            echo ($allUrls[$i] . " parsing start - " . $i) . PHP_EOL;
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
            $allFabricStructure[] = $prod->fabricStructure;


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
            if ($prod->description == null) {
                $this->error(" -  description  - " . $prod->goodUrl);
                die();
            }
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
            }
        }
        // Вывод статистики
//        $madeInStats = $this->countMadeInStats($allMadeIns);
//        $categoryStats = $this->countSemicolonArrayStats($allCategoryAll);
//        $purposeStats = $this->countSemicolonArrayStats($allPurpose);
//showAssociativeArrayForArray
        print_r($this->countSemicolonArrayStats($allFabricStructure));


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
            return $a - $b; // Сортировка по значению в порядке возрастания
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

