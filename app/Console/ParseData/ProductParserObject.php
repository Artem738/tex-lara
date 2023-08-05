<?php

namespace App\Console\ParseData;

class ProductParserObject
{
    public ?string $r;

    public ?string $sku;

    public ?string $title;
    public ?string $goodUrl;
    public ?string $description;
    public ?string $categoryAll;
    public ?string $purpose;
    public ?string $rollWidth;
    public ?string $density;
    public ?string $madeIn;
    public ?string $fabricTone;
    public ?string $patternType;
    public ?string $fabricStructure;
    public ?float $price;
    public ?float $regularPrice;
    public ?float $salePrice;
    public ?string $imgUrl;
    public ?string $allImgUrl;
    //public ?string $width; ??
   // public ?string $length;
    public ?string $optDiscount;
    public ?string $saleDiscount;
    public ?string $cutDiscount;
    public ?string $rollDiscount;
    public ?string $prodStatus;


    /**   checkData     checkData    checkData   */
    public function checkData()
    {
        $allowedNullableProperties = [
            'optDiscount',
            'saleDiscount',
            'cutDiscount',
            'rollDiscount',
        ];

        $allDataPresent = true;
        $missingProperties = [];

        $properties = get_object_vars($this);

        foreach ($properties as $propertyName => $propertyValue) {
            if ($propertyValue === null && !in_array($propertyName, $allowedNullableProperties, true)) {
                $allDataPresent = false;
                $missingProperties[] = $propertyName;
            }
        }

        if ($allDataPresent) {
            return true;
        } else {
            echo "Missing properties: " . implode(", ", $missingProperties) . PHP_EOL;
            return false;
        }
    }

    public function __construct(string $r, string $url)
    {

        $this->r = $r;
        $this->sku = null;
        $this->title = null;
        $this->goodUrl = $url;
        $this->description = null;
        $this->categoryAll = null;
        $this->purpose = null;
        $this->rollWidth = null;
        $this->density = null;
        $this->madeIn = null;
        $this->fabricTone = null;
        $this->patternType = null;
        $this->fabricStructure = null;
        $this->price = null;
        $this->regularPrice = null;
        $this->salePrice = null;
        $this->imgUrl = null;
        $this->allImgUrl = null;
        $this->optDiscount = null;
        $this->saleDiscount = null;
        $this->cutDiscount = null;
        $this->rollDiscount = null;
        $this->prodStatus = null;

        $this->gettingData();

    }

    private function gettingData()
    {
        $this->parseProductPage($lang = 'ru');
    }


##############  F U N C T I O N S #######################
    public function parseProductPage($lang = 'ru'): void
    {
        if ($lang == 'ru') {
            $naznach_lang = 'назначение:';
            $shir_lang = 'ширина рулона СМ.:';
            $plotn_lang = 'ПЛОТНОСТЬ Г/М:';
            $strproizvod_lang = 'страна производитель:';
            $ottenok_lang = 'Оттенок:';
            $sostav = "состав:";
        }


        $dataArray = array();


        $this->title = $this->parseCont($this->r, 'post-product current-item">', '<');
        $this->title = $this->megaTrim($this->title);

        $this->sku = $this->parseCont($this->r, '<span class="sku">', '</span>');
        $this->sku = trim($this->sku);

        $this->categoryAll = $this->parseCont($this->r, '<span class="posted_in">', '</span>');
        $this->categoryAll = $this->parseTaggedString($this->categoryAll);

        $this->purpose = $this->parseCont($this->r, '<span>' . $naznach_lang, '</span>');
        $this->purpose = $this->parseTaggedString($this->purpose);

        $this->rollWidth = $this->parseCont($this->r, '<span>' . $shir_lang, '</span>');
        $this->rollWidth = $this->parseTaggedString($this->rollWidth);


        $this->density = $this->parseCont($this->r, '<span>' . $plotn_lang, '</span>');
        $this->density = $this->parseTaggedString($this->density);

        $this->madeIn = $this->parseCont($this->r, '<span>' . $strproizvod_lang, '</span>');
        $this->madeIn = $this->parseTaggedString($this->madeIn);

        $this->fabricTone = $this->parseCont($this->r, '<span>' . $ottenok_lang, '</span>');
        $this->fabricTone = $this->parseTaggedString($this->fabricTone);

        $this->patternType = $this->parseCont($this->r, 'class="tagged_as">', '</span>');
        $this->patternType = $this->parseTaggedString($this->patternType);

        $this->fabricStructure = $this->parseCont($this->r, '<div class="product-fabric">', '</div>');
        $this->fabricStructure = $this->parseCont($this->fabricStructure, $sostav . '</p><p>', '</p>');
        $this->fabricStructure = $this->fabricStructureCorrector($this->fabricStructure);


        $price = $this->parseCont($this->r, '<p class="price">', '</p>');
        $price = $this->parseCont($price, '<bdi>', '&nbsp;');
        $price = str_replace(",", "", $price);
        if (is_array($price)) {
            $this->price = floatval($price[1]);
            $this->regularPrice = floatval($price[1]);
            $this->salePrice = floatval($price[0]);
        } else {
            $this->price = floatval($price);
            $this->regularPrice = floatval($price);
            $this->salePrice = floatval($price);
        }

        // images
        $imgs = $this->parseCont($this->r, '<div class="gallery-cno">', '</div></div>');
        $imgs = $this->parseCont($imgs, '<img src="', '"');
        $firstImgUrl = "";
        if (is_array($imgs)) {
            $firstImgUrl = $imgs[0];
            $all_img_url = "";
            for ($i = 0; $i < sizeof($imgs); $i++) {
                $all_img_url = $all_img_url . $imgs[$i];
                if ($i != sizeof($imgs) - 1) {
                    $all_img_url = $all_img_url . ';';
                }
            }
        } else {
            $firstImgUrl = $imgs;
            $all_img_url = $imgs;
        }
        $this->imgUrl = $firstImgUrl;
        $this->allImgUrl = $all_img_url;

        $description = $this->parseCont($this->r, '<div class="description">', '</p>');
        $this->description = $this->megaTrim($description[0]);

        if(strpos($this->r,'<p class="stock out-of-stock">')){
            $this->prodStatus = 'not exist';
        } else {
            $this->prodStatus = 'exist';
        }

//        echo($this);
//        $this->checkData();
//        die();

    }


##############  F U N C T I O N S #######################

    function fabricStructureCorrector($retStr)
    {


        // Work fine :)  but looks strange ))
        $retStr = mb_strtoupper($retStr);
        $retStr = str_replace("( ", "(", $retStr);
        $retStr = str_replace(" )", ")", $retStr);
        $retStr = str_replace("(ХЛОПОК)", "", $retStr);
        $retStr = str_replace("ОРГАНИКА", "", $retStr);
        $retStr = str_replace("КОТОН", "ХЛОПОК", $retStr);
        $retStr = str_replace("КОТТОН", "ХЛОПОК", $retStr);
        $retStr = str_replace("ПОЛИЄСТЕР", "ПОЛИЭФИР", $retStr);
        $retStr = str_replace("ПОЛИЭСТЕР", "ПОЛИЭФИР", $retStr);
        $retStr = str_replace("ПОЛИЕСТЕР", "ПОЛИЭФИР", $retStr);
        $retStr = str_replace("ПОЛИУРEТАН", "ПОЛИУРЕТАН", $retStr);
        $retStr = str_replace("ЭЛАСТАН", "СПАНДЕКС", $retStr);
        $retStr = str_replace("ЭЛАСТАН", "СПАНДЕКС", $retStr);
        $retStr = str_replace("ЕЛАСТАН", "СПАНДЕКС", $retStr);
        $retStr = str_replace(";", "", $retStr);
        $retStr = str_replace(". ", "", $retStr);
        $retStr = str_replace("% ,", "%", $retStr);
        $retStr = str_replace("%,", "%", $retStr);
        $retStr = str_replace("%", "%,", $retStr);
        $retStr = str_replace(",", ";", $retStr);
        $retStr = preg_replace('/[\s]+/mu', ' ', $retStr);

        $retStr = rtrim($retStr, ";");

        //print($retStr. '<br>');
        return $retStr;
    }

    function parseTaggedString($taggedData)
    {

        $taggedData = str_replace('&nbsp;', ' ', $taggedData);
        $taggedData = str_replace('&#x433;', '', $taggedData);
        $taggedData = str_replace('&#x440;', '', $taggedData);
        $taggedData = str_replace('&#x43D;', '', $taggedData);

        $taggedData = $this->parseCont($taggedData, '>', '<');
        $returnString = "";

        if (is_array($taggedData)) {
            $returnString = "";
            for ($i = 0; $i < sizeof($taggedData); $i++) {
                $taggedData[$i] = trim($taggedData[$i]);
                if (strlen($taggedData[$i]) > 2) {
                    $returnString = $returnString . $taggedData[$i];
                    if ($i != sizeof($taggedData) - 1) {
                        $returnString = $returnString . ";";
                    }
                }
            }
        } else {
            $returnString = trim($taggedData);
        }

        return $returnString;
    }


    /* PARSE PAGE FUNCTION */

    function writeMapToFileTsv($dataMap, $resultDataTsvFilePath)
    {

        $lineString = "";

        foreach ($dataMap as $key => $value) {
            $value = str_replace("\t", " ", $value);
            $lineString = $lineString . $value . "\t";
        }
        //print($lineString); exit;
        file_put_contents($resultDataTsvFilePath, $lineString . PHP_EOL, FILE_APPEND | LOCK_EX);
        //print_r($dataMap);
    }

    function getFileNameFromUrl($url)
    {
        $pageFileName = parse_url($url, PHP_URL_PATH);
        $pageFileName = trim($pageFileName, '/') . '.txt';
        $pageFileName = str_replace('/', '_', $pageFileName);
        $pageFileName = str_replace('product_', '', $pageFileName);
        return $pageFileName;
    }


    private function parseCont($r, $leftString, $rightString)
    {
        $urls = [];
        $r2 = explode($leftString, $r);
        for ($i = 1; $i < sizeof($r2); $i++) {
            //$r2[$i] = $leftString.$r2[$i]; // хз
            $strpos = strpos($r2[$i], $rightString);
            $result = substr($r2[$i], 0, $strpos);
            if ($result) {
                $urls[] = $result;
            }
        }
        if (!$urls) {
            return false;
        } else {
            if (!$urls) {
                return false;
            } else {
                if (sizeof($urls) > 1) {
                    return $urls;
                } else {
                    $urls = $urls[0];
                    return $urls;
                }
            }
        }
    }

    function getAndDeleteFirstLineFromFile($filePath)
    {
        $allData = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $firstElement = array_shift($allData);
        file_put_contents($filePath, implode(PHP_EOL, $allData), FILE_APPEND || LOCK_EX);
        return $firstElement;
    }


    function megaTrim($csvdata)
    {
        $csvdata = trim($csvdata);
        // Спецвимволы типа &nbsp;  убираются, но возможно..., это не всегда надо наверно, возможно нужно только для $name и $description ...
        $csvdata = htmlspecialchars_decode($csvdata);

        $csvdata = str_replace("\t\t", "\t", $csvdata);
        $csvdata = str_replace("\t\t", "\t", $csvdata);
        $csvdata = str_replace("\t\t", "\t", $csvdata);
        $csvdata = str_replace("\n", " ", $csvdata);
        $csvdata = str_replace("\r", " ", $csvdata);
        $csvdata = str_replace("&#13;", " ", $csvdata);
        $csvdata = str_replace("  ", " ", $csvdata); // уберем двойные пробелы
        $csvdata = str_replace("  ", " ", $csvdata);
        $csvdata = str_replace("  ", " ", $csvdata);
        $csvdata = str_replace("  ", " ", $csvdata);
        $csvdata = str_replace("  ", " ", $csvdata);
        $csvdata = str_replace("  ", " ", $csvdata);
        $csvdata = str_replace("  ", " ", $csvdata);
        $csvdata = str_replace("  ", " ", $csvdata);

        $csvdata = str_replace("  ", " ", $csvdata);
        $csvdata = str_replace("	", " ", $csvdata); //уберем табуляторы
        $csvdata = str_replace("|", "-", $csvdata);
        return $csvdata;
    }





    public function __toString()
    {
        $reset = "\033[0m"; // Сброс стилей
        $red = "\033[31m"; // Красный
        $green = "\033[32m"; // Зеленый

        return

            $this->getColorString($this->sku, "SKU") .
            $this->getColorString($this->title, "Title") .
            $this->getColorString($this->goodUrl, "Good URL") .
            $this->getColorString(mb_strlen($this->description) > 200 ? mb_substr($this->description, 0, 200) . '...' : $this->description, "Description") .
            $this->getColorString($this->categoryAll, "Category All") .
            $this->getColorString($this->purpose, "Purpose") .
            $this->getColorString($this->rollWidth, "Roll Width") .
            $this->getColorString($this->density, "Density") .
            $this->getColorString($this->madeIn, "Made In") .
            $this->getColorString($this->fabricTone, "Fabric Tone") .
            $this->getColorString($this->patternType, "Pattern Type") .
            $this->getColorString($this->fabricStructure, "Fabric Structure") .
            $this->getColorString($this->price, "Price") .
            $this->getColorString($this->regularPrice, "Regular Price") .
            $this->getColorString($this->salePrice, "Sale Price") .
            $this->getColorString($this->imgUrl, "Image URL") .
            $this->getColorString($this->allImgUrl, "All Image URL") .
            $this->getColorString($this->optDiscount, "Opt Discount") .
            $this->getColorString($this->saleDiscount, "Sale Discount") .
            $this->getColorString($this->cutDiscount, "Cut Discount") .
            $this->getColorString($this->rollDiscount, "Roll Discount") .
            $this->getColorString($this->prodStatus, "Product Status") .
            $reset;
    }

    private function getColorString($value, $label)
    {
        $reset = "\033[0m"; // Сброс стилей
        $red = "\033[31m"; // Красный
        $green = "\033[32m"; // Зеленый

        $color = $red; // По умолчанию красный
        if ($value !== '' && $value !== null) {
            $color = $green; // Зеленый, если значение не пустое и не равно нулю
        }

        return $color . $label . ": " . $reset . $color . $value . "\n";
    }
}
