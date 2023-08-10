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

            if ($prod->goodUrl == "https://iamtex.com.ua/product/bifleks-zhatka-14/") {
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
        $madeInStats = $this->countMadeInStats($allMadeIns);
        $categoryStats = $this->countCategoryStats($allCategoryAll);
        $purposeStats = $this->countPurposeStats($allPurpose);

        print_r($madeInStats);
        print_r($categoryStats);
        print_r($purposeStats);
        ParsFunc::showAssociativeArrayForArray($purposeStats);

    }

    public function checkPurposeOrDie($purpose)
    {
        $purposeArray = explode(';', $purpose);

        foreach ($purposeArray as $item) {
            if (empty(trim($item))) {
                return false; // Если есть пустой элемент, возвращаем false
            }
        }

        return true; // Если все элементы не пустые, возвращаем true
    }

    public function countMadeInStats($allMadeIns)
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

    public function countCategoryStats($allCategoryAll)
    {
        $statCatAll = array();

        foreach ($allCategoryAll as $cat) {
            $exCat = explode(";", $cat);
            foreach ($exCat as $ex) {
                if (isset($statCatAll[$ex])) {
                    $statCatAll[$ex]++;
                } else {
                    $statCatAll[$ex] = 1;
                }
            }
        }

        ksort($statCatAll);
        return $statCatAll;
    }

    public function countPurposeStats($allPurpose)
    {
        $stataAllPurpose = array();

        foreach ($allPurpose as $pup) {
            $exCat = explode(";", $pup);
            foreach ($exCat as $ex) {
                if (isset($stataAllPurpose[$ex])) {
                    $stataAllPurpose[$ex]++;
                } else {
                    $stataAllPurpose[$ex] = 1;
                }
            }
        }

        ksort($stataAllPurpose);
        return $stataAllPurpose;
    }


}

