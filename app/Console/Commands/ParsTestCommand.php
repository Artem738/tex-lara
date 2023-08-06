<?php

namespace App\Console\Commands;

use App\Console\ParseData\ProductParserObject;
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

    public function handle()
    {
        $allUrls = explode("\n", Storage::get($this->allUrlsFilePath));

        //$this->output->progressStart(sizeof($allUrls));
        $allMadeIns = [];

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
                $this->alert($prod->goodUrl . " -  rollWidth");
                //die();
            }

            if ($prod->fabricTone == null) {
                $this->alert(" -  fabricTone  - " . $prod->goodUrl);
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

            $this->info($prod->similarProducts);


        }


        $statMadeIn = array();
        foreach ($allMadeIns as $country) {
            if (isset($statMadeIn[$country])) {
                $statMadeIn[$country]++;
            } else {
                $statMadeIn[$country] = 1;
            }
        }

//        print_r($allMadeIns);
//        print_r($statMadeIn);

        //$this->output->progressFinish();
    }


}

