<?php

namespace App\Console\ParseData;

use App\MyFunctions\MyFunc;
use App\MyFunctions\ParsFunc;

class ProductParserObject
{
    /// UTIL
    public string $r;

    /// DATA

    public ?string $sku;

    public ?string $title;
    public string $goodUrl;
    public ?string $description;
    public ?string $categoryAll;
    public ?string $purpose;
    public ?string $rollWidth;
    public ?string $rollWidthCategory;
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
    public ?string $optDiscount;
    public ?string $saleDiscount;
    public ?string $cutDiscount;
    public ?string $rollDiscount;
    public ?string $prodStatus;
    public ?string $similarProducts;


    //todo: <button class="button-for-search" onclick="location.href='/?s=10029 + 10028 + 10027 + 10021&search_id=1&post_type=product';">Смотреть доступные цвета		</div>


    public function checkData(): bool
    {
        $allowedNullableProperties = [
            'optDiscount',
            'saleDiscount',
            'cutDiscount',
            'rollDiscount',
            // Добавьте сюда другие переменные, которым разрешено быть null
        ];

        $properties = get_object_vars($this);

        foreach ($properties as $propertyName => $propertyValue) {
            if ($propertyValue === null && !in_array($propertyName, $allowedNullableProperties, true)) {
                $missingProperties[] = $propertyName;
                echo "Missing properties: " . implode(", ", $missingProperties) . PHP_EOL;
                return false;

            }
        }

        return true;
    }


    public function __construct(string $r, string $url)
    {

        $this->r = $r;

        ///
        $this->sku = null;
        $this->title = null;
        $this->goodUrl = $url;
        $this->description = null;
        $this->categoryAll = null;
        $this->purpose = null;
        $this->rollWidth = null;
        $this->rollWidthCategory = null;
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
        $this->similarProducts = null;

        $this->parseProductPage();

    }

//    private function gettingData(): void
//    {
//        $this->parseProductPage();
//    }


##############  F U N C T I O N S #######################
    public function parseProductPage(): void
    {
        // if ($lang == 'ru') { $lang = 'ru'
        $naznach_lang = 'назначение:';
        $shir_lang = 'ширина рулона СМ.:';
        $plotn_lang = 'ПЛОТНОСТЬ Г/М:';
        $strproizvod_lang = 'страна производитель:';
        $ottenok_lang = 'Оттенок:';
        $sostav = "состав:";


        $this->title = MyFunc::parseContMulti($this->r, 'post-product current-item">', '<');
        $this->title = ParsFunc::megaTrim($this->title);

        $this->sku = MyFunc::parseContMulti($this->r, '<span class="sku">', '</span>');
        $this->sku = trim($this->sku);

        $this->categoryAll = MyFunc::parseContMulti($this->r, '<span class="posted_in">', '</span>');
        $this->categoryAll = ParsFunc::parseTaggedString($this->categoryAll);

        $this->purpose = MyFunc::parseContMulti($this->r, '<span>' . $naznach_lang, '</span>');
        $this->purpose = ParsFunc::parseTaggedString($this->purpose);

        $this->rollWidth = MyFunc::parseContMulti($this->r, '<span>' . $shir_lang, '</span>');
        $this->rollWidth = ParsFunc::parseTaggedString($this->rollWidth);
        if ($this->rollWidth == null) {
            $this->rollWidth = MyFunc::parseContMulti($this->r, '<span>' . "Ширина:", '</span>');
            $this->rollWidth = ParsFunc::parseTaggedString($this->rollWidth);
        }

        $this->rollWidthCategory = MyFunc::parseContMulti($this->r, '<span>' . 'Категория ширины рулона', '</span>');
        $this->rollWidthCategory = ParsFunc::parseTaggedString($this->rollWidthCategory);


        $this->density = MyFunc::parseContMulti($this->r, '<span>' . $plotn_lang, '</span>');
        $this->density = ParsFunc::parseTaggedString($this->density);

        $this->madeIn = MyFunc::parseContMulti($this->r, '<span>' . $strproizvod_lang, '</span>');
        $this->madeIn = ParsFunc::parseTaggedString($this->madeIn);

        $this->fabricTone = MyFunc::parseContMulti($this->r, '<span>' . $ottenok_lang, '</span>');
        $this->fabricTone = ParsFunc::parseTaggedString($this->fabricTone);

        $this->patternType = MyFunc::parseContMulti($this->r, 'class="tagged_as">', '</span>');
        $this->patternType = ParsFunc::parseTaggedString($this->patternType);

        $this->fabricStructure = MyFunc::parseContMulti($this->r, '<div class="product-fabric">', '</div>');
        $this->fabricStructure = MyFunc::parseContMulti($this->fabricStructure, $sostav . '</p><p>', '</p>');
        $this->fabricStructure = ParsFunc::fabricStructureCorrector($this->fabricStructure);


        $price = MyFunc::parseContMulti($this->r, '<meta itemprop="price" content="', '"');
        $regularPrice = MyFunc::parseContMulti($this->r, '<del><span class="woocommerce-Price-amount amount"><bdi>', '&nbsp');
        //$price = MyFunc::parseContMulti($price, '<bdi>', '&nbsp;');
        //$price = str_replace(",", "", $price);

        if (!$regularPrice) {
            $regularPrice = $price;
        }

        if (is_array($price)) {
            $this->price = floatval($price[1]);
            $this->regularPrice = floatval($regularPrice[1]);
            $this->salePrice = floatval($price[0]);
        } else {
            $this->price = floatval($price);
            $this->regularPrice = floatval($regularPrice);
            $this->salePrice = floatval($price);
        }


        // images
        $imgs = MyFunc::parseContMulti($this->r, '<div class="gallery-cno">', '</div></div>');
        $imgs = MyFunc::parseContMulti($imgs, '<img src="', '"');
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

        $description = MyFunc::parseCont($this->r, '<div class="description">', '<div class="product-reviews">');
        // echo (gettype($description) . " " . $this->goodUrl) . PHP_EOL;
        // die();
        $this->description = ParsFunc::megaTrim($description[0]);

        if (strpos($this->r, '<p class="stock out-of-stock">')) {
            $this->prodStatus = 'not exist';
        } else {
            $this->prodStatus = 'exist';
        }



         $this->similarProducts = MyFunc::parseContMulti($this->r, 'button-for-search" onclick="location.href=', ';">');
        $this->similarProducts = str_replace("'","", $this->similarProducts);
        $this->similarProducts = str_replace("/?","", $this->similarProducts);

//        echo($this);
//        $this->checkData();
//        die();
    }


##############  F U N C T I O N S #######################

    public function __toString()
    {
        $reset = "\033[0m"; // Сброс стилей
        //  $red = "\033[31m"; // Красный
        //  $green = "\033[32m"; // Зеленый

        return

            $this->getColorString($this->sku, "SKU") .
            $this->getColorString($this->title, "Title") .
            $this->getColorString($this->goodUrl, "Good URL") .
            $this->getColorString(mb_strlen($this->description) > 200 ? mb_substr($this->description, 0, 200) . '...' : $this->description, "Description") .
            $this->getColorString($this->categoryAll, "Category All") .
            $this->getColorString($this->purpose, "Purpose") .
            $this->getColorString($this->rollWidth, "Roll Width") .
            $this->getColorString($this->rollWidthCategory, "Roll Width Category") .
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
            $this->getColorString($this->similarProducts, "Product Status") .
            $reset;
    }

    private function getColorString($value, $label): string
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
