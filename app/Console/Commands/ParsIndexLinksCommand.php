<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

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
            1 => 'Сканируем ссылки',
            2 => 'Парсим',
            3 => 'Чтото еще',
        ];
        $defaultChoice = 1;

        $choiceVal = $this->choice('Выберите опцию:', $choices, $defaultChoice);
        $choiceKey = array_search($choiceVal, $choices);
        $targetUrl = env('PARS_TARGET_URL');
       // print ($dataDirPath); die();


        if ($choiceKey === 2) {
            $response = Http::get($targetUrl);
            print("Index data length - " . strlen($response)) . PHP_EOL;
            if (Storage::put('pars_data/' . 'index.txt', $response)) {
                print("File Stored Successful") . PHP_EOL;
            } else {
                print("File Store Error") . PHP_EOL;
            }

        } elseif ($choiceKey === 1) {

        }


    }
}
