<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Helpers\MyHelper;


class ParsAllProdUrls extends Command
{
    protected $signature = 'pars:allurls';
    protected $description = 'Command Pars All Product Urls';

    // Path
    private string $directoryPath = 'pars_data/shop';
    private string $productPagesPath = 'pars_data/pages/'; // with /
    private string $allUrlsFilePath = 'pars_data/all_urls.txt';
    private int $sleepTime = 6;

    private function parsShop(): void
    {
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
    }

    private function getLinks(): void
    {
        $allUrls = [];

        if (Storage::exists($this->directoryPath)) {
            $files = Storage::files($this->directoryPath);
            foreach ($files as $file) {
                $fileName = pathinfo($file, PATHINFO_BASENAME);
                $fileData = Storage::get($this->directoryPath . '/' . $fileName);
                $urls = MyHelper::parseCont($fileData, '</h2>	<a href="', '"');

                $allUrls = array_merge($allUrls, $urls);
            }
            $allUrls = array_unique($allUrls);
            if (Storage::put($this->allUrlsFilePath, implode(PHP_EOL, $allUrls))) {
                $this->info("Файл успешно записан. Количество записей - " . count($allUrls));
            } else {
                $this->error("Ошибка при записи файла.");
            }
        } else {
            $this->error("Директория не существует.");
        }
    }


    private function showInfo(): void
    {
        if (Storage::exists($this->directoryPath)) {
            $files = Storage::files($this->directoryPath);
            foreach ($files as $file) {
                $fileName = pathinfo($file, PATHINFO_BASENAME);
                $fileSize = Storage::size($file);

                // Преобразуем размер файла в удобочитаемый формат (байты, килобайты, мегабайты и т.д.)
                $formattedSize = $fileSize >= 1024 ? round($fileSize / 1024, 2) . ' KB' : $fileSize . ' bytes';

                $this->line("$fileName - Размер: " . $formattedSize);
            }
        } else {
            $this->error("Директория не существует.");
        }

        if (Storage::exists($this->allUrlsFilePath)) {
            $timeDifference = Carbon::parse(Storage::lastModified($this->allUrlsFilePath))->diffForHumans(Carbon::now());
            $this->info($this->allUrlsFilePath . " - Exist. Last Updated: $timeDifference");
            $this->info("File size - " . count(explode(PHP_EOL, (Storage::get($this->allUrlsFilePath)))));
        } else {
            $this->error($this->allUrlsFilePath . " does not exist") . PHP_EOL;
        }
    }

    // GET PAGES
    private function storeSitePages(): void
    {
        if (Storage::exists($this->allUrlsFilePath)) {
            $urls = explode(PHP_EOL, Storage::get($this->allUrlsFilePath));

            $this->output->progressStart(sizeof($urls));

            foreach ($urls as $url) {
                $filename = MyHelper::urlToFileName($url);

                if (Storage::exists($this->productPagesPath . $filename)) {
                    //$this->info("Exist");
                    $this->output->progressAdvance();
                } else {
                    $response = Http::get($url);
                    if (strlen($response) < 150000) {
                        $this->error("Site Error");
                        die();
                    }
                    Storage::put($this->productPagesPath . $filename, $response);
                    $this->line(" Page - " . $url . " saved. Content size - " . strlen($response) . ". Sleeping " . $this->sleepTime . " sec...");
                    $this->output->progressAdvance();
                    sleep($this->sleepTime);
                }
            }

            $this->output->progressFinish();
        } else {
            $this->error($this->allUrlsFilePath . " does not exist") . PHP_EOL;
        }
    }

    /* Handle (menu) */
    public function handle()
    {
        $choices = [
            1 => 'Проверяем',
            2 => 'Парсим shop',
            3 => 'Получаем ссылки на продукты',
            4 => 'Сохраняем страницы сайта',
        ];
        $defaultChoice = 1;
        $choiceKey = array_search($this->choice('Выберите опцию:', $choices, $defaultChoice), $choices);
        if ($choiceKey === 1) {
            $this->showInfo();
        } elseif ($choiceKey === 2) {
            $this->parsShop();
        } elseif ($choiceKey === 3) {
            $this->getLinks();
        } elseif ($choiceKey === 4) {
            $this->storeSitePages();
        }
    }

}

