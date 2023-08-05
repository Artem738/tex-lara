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
        for ($i = 462; $i < $allUrls; $i++) {  //463

            echo ($allUrls[$i] . " parsing start - " . $i) . PHP_EOL;
            $fileHtmlString = Storage::get($this->productPagesPath . MyFunc::urlToFileName($allUrls[$i]));
            $prod = new ProductParserObject($fileHtmlString, $allUrls[$i]);

            if (!$prod->checkData()) {
                echo($prod); // __toString
                die();
            }
            //echo($prod).PHP_EOL;
            $this->info($i . " - good - " . $allUrls[$i] . " - good");
            echo($prod);
            // $this->output->progressAdvance();

        }

        //$this->output->progressFinish();
    }


}

