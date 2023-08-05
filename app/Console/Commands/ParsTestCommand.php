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
        foreach ($allUrls as $url) {
            $file = Storage::get($this->productPagesPath . MyFunc::urlToFileName($url));
            $prod = new ProductParserObject($file, $url);

            if ($prod->checkData() === false) {
                echo($prod); // __
                die();
            }


        }


    }


}

