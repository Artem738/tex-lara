<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Helpers\MyHelper;

class ParsIndexLinksCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pars:index';

    /**
     * The console command description.
     *
     *
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $choices = [
            1 => 'Проверяем информацию',
            2 => 'Парсим',
            3 => 'Получаем данные',
        ];
        $defaultChoice = 1;
        $choiceKey = array_search($this->choice('Выберите опцию:', $choices, $defaultChoice), $choices);
        $targetUrl = env('PARS_TARGET_URL');
        $filePath = 'pars_data/index.txt';

        if ($choiceKey === 2) {
            $response = Http::get($targetUrl);
            print("Index data length - " . strlen($response)) . PHP_EOL;
            if (Storage::put($filePath, $response)) {
                $this->info("File Stored Successful") . PHP_EOL;
            } else {
                $this->error("File Store Error") . PHP_EOL;
            }

        } elseif ($choiceKey === 1) {
            if (Storage::exists($filePath)) {
                $timeDifference = Carbon::parse(Storage::lastModified($filePath))->diffForHumans(Carbon::now());
                $this->info("File Last Updated: $timeDifference") . PHP_EOL;
            } else {
                $this->error("File does not exist") . PHP_EOL;
            }

        } elseif ($choiceKey === 3) {


            $fileData = Storage::get($filePath);
            $urls = MyHelper::parseCont($fileData, '"mob-menu-li-a" href="', '</a>');


            $urlsDataArray = array();
            foreach ($urls as $url) {
                $urlData = explode('">', $url);
                $urlsDataArray[$targetUrl . $urlData[0]] = $urlData[1];
            }

            $urls = MyHelper::parseCont($fileData, '<li class="menu-item menu-item-type-taxonomy', '</a>');
            foreach ($urls as $url) {
                $urlData = explode('<a href="', $url);
                $urlData = explode('">', $urlData[1]);
                $urlsDataArray[$urlData[0]] = $urlData[1];
            }
            print_r($urlsDataArray);
        }
    }


}

