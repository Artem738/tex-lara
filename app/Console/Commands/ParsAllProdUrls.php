<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\MyFunctions\MyFunc;

class ParsAllProdUrls extends Command
{

    protected $signature = 'pars:allurls';


    protected $description = 'Command Pars All Product Urls';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $choices = [
            1 => 'Проверяем',
            2 => 'Парсим shop',
            3 => 'Получаем данные',
        ];
        $defaultChoice = 1;
        $choiceKey = array_search($this->choice('Выберите опцию:', $choices, $defaultChoice), $choices);


        if ($choiceKey === 2) {

            for ($i = 37; $i <= 38; $i++) {

                $filePath = 'pars_data/shop/page_' . $i . '.txt';
                $response = Http::get(env('PARS_TARGET_URL') . '/shop/page/' . $i . '/');
                if (Storage::put($filePath, $response)) {
                    $this->info($i . " File Stored Successful");
                } else {
                    $this->error($i . " File Store Error");
                }
                sleep(5);
            }



        } elseif ($choiceKey === 1) {

        }

    }


}

