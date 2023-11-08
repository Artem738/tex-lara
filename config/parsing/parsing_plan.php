<?php

use App\Console\ParseData\Parsers\Corrector;
use App\Console\ParseData\Parsers\FindAndTrimParser;
use App\Console\ParseData\Parsers\NullStringParser;
use App\Console\ParseData\Parsers\SimpleStringMultyParser;
use App\Console\ParseData\Parsers\SimpleStringParser;
use App\Console\ParseData\Parsers\TaggedStringFormatParser;
use App\Console\ParseData\Parsers\TaggedStringParser;
use App\Helpers\MyHelper;
use App\Helpers\StringHelper;

/**
 * @var Corrector $patternCorrector
 * @var Corrector $fabricToneCorrector
 * @var Corrector $structureCorrector
 * @var Corrector $structureCorrectorFinal
 */
$tone = '';
$parsingPlan = [];
$price = null;
$regularPrice = null;
$salePrice = null;


$fabricToneCorrector = require_once __DIR__ . '/correctors/tone.php';
$patternCorrector = new Corrector();
$priceCorrector = new Corrector();
$imgCorrector = new Corrector();
$imgAllCorrector = new Corrector();
$regularPriceCorrector = new Corrector();
$salePriceCorrector = new Corrector();
$structureCorrectorFinal = require_once __DIR__ . '/correctors/structure.php';
$structureCorrector = new Corrector(postHandler: function ($content) use ($structureCorrectorFinal) {
    $parser = new SimpleStringMultyParser('состав:</p><p>', '</p>', $structureCorrectorFinal);
    $parser->parse($content);
});


$parsingPlan['Title'] = new FindAndTrimParser('post-product current-item">', '<');
$parsingPlan['Description'] = new SimpleStringParser(
    '<div class="description">',
    '<div class="product-reviews">',
    $imgCorrector
);

$parsingPlan['SKU'] = new FindAndTrimParser('<span class="sku">', '</span>');
$parsingPlan['Category All'] = new TaggedStringParser(
    '<span class="posted_in">',
    '</span>',
    require_once __DIR__ . '/correctors/category.php'
);
$parsingPlan['Purpose'] = new TaggedStringFormatParser('<span>назначение:', '</span>');
$parsingPlan['Roll Width'] = new TaggedStringParser('<span>ширина рулона СМ.:', '</span>');
$parsingPlan['Roll Width '] = new TaggedStringParser('<span>Ширина:', '</span>');
$parsingPlan['Roll Width Category'] = new TaggedStringParser('<span>Категория ширины рулона', '</span>');
$parsingPlan['Density'] = new TaggedStringParser('<span>ПЛОТНОСТЬ Г/М:', '</span>');
$parsingPlan['Made In'] = new TaggedStringParser('<span>страна производитель:', '</span>');
$parsingPlan['Fabric Tone'] = new TaggedStringParser('<span>Оттенок:', '</span>', $fabricToneCorrector);
$parsingPlan['Pattern Type'] = new TaggedStringParser('class="tagged_as">', '</span>', $patternCorrector);
$parsingPlan['Fabric Structure'] = new SimpleStringMultyParser(
    '<div class="product-fabric">',
    '</div>',
    $fabricToneCorrector
);

$parsingPlan['Price'] = new SimpleStringMultyParser('<meta itemprop="price" content="', '"', $priceCorrector);
$parsingPlan['Regular Price'] = new SimpleStringMultyParser(
    '<del><span class="woocommerce-Price-amount amount"><bdi>',
    '&nbsp',
    $regularPriceCorrector
);
$parsingPlan['Sale Price'] = new NullStringParser('', '', $salePriceCorrector);
$parsingPlan['Image URL'] = new SimpleStringMultyParser('<img src="', '"', $imgCorrector);
$parsingPlan['All Image URL'] = new NullStringParser('', '', $imgAllCorrector);
$parsingPlan['Product Status'] = new NullStringParser('', '', new Corrector(preHandler: function ($content) {
    if (strpos($content, '<p class="stock out-of-stock">')) {
        $content = 'not exist';
    } else {
        $content = 'exist';
    }
    return $content;
}));
$parsingPlan['Similar Products'] = new SimpleStringMultyParser('button-for-search" onclick="location.href=', ';">', new Corrector(
    [
        "'" => "",
        "/?" => "",
    ]
));


$fabricToneCorrector->addCallback(function ($content) use (&$tone) {
    $tone = $content;
    return match ($content) {
        '' => 'Бесцветный',
        'Белый/ ракушка' => 'Белый',
        'Бело-голубой градиент' => 'Бело-голубой',
        'Камуфляж', 'Зеленые круги' => 'Зеленый',
        'Коричневые круги' => 'Коричневый',
        'Серые звездочки', 'Серый с мелкой гусиной лапкой' => 'Серый',
        'Голограмма', 'Узор разноцветный зиг-заг', 'Принт / разноцветный зигзаг' => 'Разноцветный',
        'Черно-белая клетка', 'Черно/белый зигзаг' => 'Черно-белый',
        'Желто/белый зигзаг', 'Желто-белый зигзаг', 'Желто-белая клетка' => 'Желто-белый',
        default => StringHelper::ucfirst($content)
    };
});
$patternCorrector->addCallback(function (string $content) use ($tone) {
    return match ($tone) {
        '' => 'Однотонный',
        'Камуфляж' => MyHelper::resolvePattern($content, "Камуфляж"),
        'Серые звездочки' => MyHelper::resolvePattern($content, "Звёзды"),
        'Белый/ ракушка' => MyHelper::resolvePattern($content, "Ракушка"),
        'Зеленые круги', 'Коричневые круги' => MyHelper::resolvePattern($content, "Круги"),
        'Желто-белая клетка', 'Черно-белая клетка' => MyHelper::resolvePattern($content, "Клетка"),
        'Голограмма' => MyHelper::resolvePattern($content, "Голограмма"),
        'Серый с мелкой гусиной лапкой' => MyHelper::resolvePattern($content, "Гусиная Лапка"),
        'Черно/белый зигзаг' => ';Зигзаг',
        'Бело-голубой градиент', 'Желто/белый зигзаг', 'Принт / разноцветный зигзаг', 'Желто-белый зигзаг', 'Узор разноцветный зиг-заг' => MyHelper::resolvePattern(
            $content,
            "Зигзаг"
        ),
        default => StringHelper::ucfirst($content)
    };
});

$priceCorrector->addCallback(function ($content) use (&$price, &$salePrice) {
    $price = $content;
    if (is_array($price)) {
        $price = floatval($content[1]);
        $salePrice = floatval($content[0]);
    } else {
        $price = floatval($content);
        $salePrice = floatval($content);
    }
    return $price;
});

$regularPriceCorrector->addCallback(function ($content) use (&$price, &$regularPrice) {
    if (!$content) {
        $regularPrice = $price;
    }
    if (is_array($price)) {
        $regularPrice = floatval($regularPrice[1]);
    } else {
        $regularPrice = floatval($regularPrice);
    }

    return $regularPrice;
});

$salePriceCorrector->addCallback(function ($content) use (&$salePrice) {
    return $salePrice;
});

$imgs = null;
$allImgs = null;
$imgCorrector->addCallback(function ($content) use (&$imgs, &$allImgs) {
    if (is_array($content)) {
        $allImgs = $content[0];
        $allImgs = "";
        for ($i = 0; $i < sizeof($content); $i++) {
            $allImgs = $allImgs . $content[$i];
            if ($i != sizeof($content) - 1) {
                $allImgs = $allImgs . ';';
            }
        }
    } else {
        $allImgs = $content;
    }
    $imgs = $content;
});
$imgAllCorrector->addCallback(function ($content) use (&$allImgs) {
    return $allImgs;
});

return $parsingPlan;
