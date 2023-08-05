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

        for ($i = 0; $i < $allUrls; $i++) {  //463

            $file = Storage::get($this->productPagesPath . MyFunc::urlToFileName($allUrls[$i]));
            $prod = new ProductParserObject($file, $allUrls[$i]);

            if (!$prod->checkData()) {
                echo($prod); // __toString
                die();
            }
            $this->info($i." - good - ".$allUrls[$i]. " - good").PHP_EOL;
            echo($prod).PHP_EOL;
        }


    }


}

