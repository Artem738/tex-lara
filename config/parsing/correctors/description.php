<?php

use App\Console\ParseData\Parsers\Corrector;

$additionalRules = [
    "<h2><strong>Купить ткань",
    "<p><b>Как выбрать ткань?</b></p>",
    "<div> <h2><strong>Купить",
    "<h2><strong>Купить",
    "<p>Купить ткань ",
    '<p><span style="font-weight: 400">Купить ткань ',
    '<h2 data-pm-slice="1 1 []',
    '<div data-pm-slice="1 1 []',
    '<p><strong>Варианты для пошива',
    "<p>Закажите наши ",
    "<p><strong>Если вас заинтересовала ткань ",
    '<p>* <em>Цена</em> указана при',
    '<p><em>* Цена указана',
    '<h2>Как купить ',
    '<h2>Как заказать ',
];


return new Corrector(
    [
        " "                                                                                                          => " ",
        "  </div>"                                                                                                   => "",
        "<div><b><i>+380502210020</i></b></div>"                                                                     => "",
        "<div><i>Киев, ул. Клеманская, 1/5</i></div>"                                                                => "",
        "<div><b><i>+380673890570 +380982990001</i></b></div>"                                                       => "",
        "<div><i>Киев, ул. Каземира Малевича, 86В м. Лыбедская (бывшая улица Боженко)</i></div>"                     => "",
        "<div><i>Закажите наши бесплатные образцы или ознакомьтесь лично с тканями в магазинах по адресу:</i></div>" => "",
        "<div><i>Закажите наши образцы или ознакомьтесь лично с тканями в магазинах по адресу:</i></div>"            => "",
        '&nbsp;',
        " ",
        ' data-pm-slice="1 1 []" data-en-clipboard="true"',
        "",
        '<strong>'                                                                                                   => '',
        '</strong>'                                                                                                  => '',
        '<strong style="font-weight: normal">'                                                                       => '',
    ],
    postHandler: function ($content) use ($additionalRules) {
        foreach ($additionalRules as $additionalRule) {
            $content = explode($additionalRule, $content)[0];
        }
        $content = html_entity_decode($content, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        if (mb_strlen($content) < 10) {
            return "";
        }

        $content = preg_replace('/<a\b[^>]*>(.*?)<\/a>/i', '', $content);

        $tidy = new tidy();
        $content = $tidy->repairString(
            $content,
            [
                'show-body-only' => true, // Показывать только тело документа (удаляются head и все его содержимое)
                'drop-proprietary-attributes' => true, // Удалять неподдерживаемые атрибуты
                'clean' => true, // Очищать и форматировать HTML
                'output-xhtml' => true, // Выводить XHTML
                'wrap' => 0 // Не оборачивать в <html> и <body>
            ]
        );
        $content = str_replace(' data-pm-slice="1 1 [" data-en-clipboard="true"', '', $content);

        $content = $tidy->repairString(
            $content,
            [
                'show-body-only' => true, // Показывать только тело документа (удаляются head и все его содержимое)
                'drop-proprietary-attributes' => true, // Удалять неподдерживаемые атрибуты
                'clean' => true, // Очищать и форматировать HTML
                'output-xhtml' => true, // Выводить XHTML
                'wrap' => 0 // Не оборачивать в <html> и <body>
            ]
        );
        $content = mb_strlen($content) > 200
            ?
            mb_substr($content, 0, 197) . '...'
            :
            $content;

        return $content;
    }
);
