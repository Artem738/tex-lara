<?php

use App\Console\ParseData\Parsers\Corrector;
use App\Helpers\StringHelper;

return new Corrector(
    [
        ' - '                 => '-',
        //'/' =>  '-',
        '- '                  => '-',
        ' -'                  => '-',
        'Многоцветный/ принт' => 'Многоцветный',
        ' принт'              => '',
        // 'какао' =>  'Какао',
        // 'темно-бежевый' =>  'Темно-бежевый',
        ' нюд'                => '',
        'Светло серый'        => 'Светло-серый',
        'Электро синий'       => 'Электро-синий',
        ' меланж'             => '',
        'Речной перламутр'    => 'Жемчужный',
        'Морская ракушка'     => 'Розовый',
        'Дымчатая роза'       => 'Розовый',


        'Золото'                           => 'Золотой',
        'Светло голубой'                   => 'Светло-голубой',
        'Многоцветный'                     => 'Многоцветный',
        'Черно-розовая полоска'            => 'Черный;Розовый',
        'Черно-белая полоска'              => 'Черный;Белый',
        'Принт коричневый леопард'         => 'Коричневый',
        'Принт/ разноцветная полоска'      => 'Разноцветный',
        'Черно-красная полоска'            => 'Черный;Красный',
        'Голубой/ полоска'                 => 'Голубой',
        'Принт этно'                       => 'Разноцветный',
        ' кадетский'                       => '',
        ' орнамент'                        => '',
        ' градиент'                        => '',
        'Полоса персик/белый'              => 'Белый;Персиковый',
        'Полоска сераябелая'               => 'Серо-белый',
        'Синий/принт черный'               => 'Синий;Черный',
        'Полоска зелень/белый'             => 'Зеленый;Белый',
        'Полоса голубой/белый'             => 'Голубой;Белый',
        'Белая сетка,-завитушки цветочные' => 'Черный;Белый',
        'Принт бело-голубые треугольники'  => 'Белый;Голубой',
        'Полоса бежевый/темно-синий'       => 'Бежевый;Темно-синий',
        'Принт зеленый леопард'            => 'Зеленый',
        'Белый /принт серый'               => 'Белый;Серый',
        'Апероль'                          => 'Апероль;Оранжевый',
        'Сетка черная-диско'               => 'Черный',
        'Сетка черная-бабочки'             => 'Черный',
        'Креш изумруд'                     => 'Зеленый;Изумруд',
        'Многоцветный / полоска'           => 'Многоцветный',

        '-принт змеиная кожа' => '',
        '-принт леопард'      => '',
        '-принт'              => '',
        'Коричневые цветы'    => 'Коричневый',
        ' зигзаг'             => ';Хаки',

        '/ принт леопард' => '',
        '/ змеиная кожа'  => '',
        '/ леопард'       => '',
        '/ бензин'        => '',

        'Черно-синяя полоска'         => 'Черно-синий',
        'Сетка черная-кошки'          => 'Черный',
        'Сетка белая'                 => 'Белый',
        'Кофейный, структура елочка'  => 'Кофейный',
        'Черно-белая гусиная лапка'   => 'Черно-белый',
        'Розово-серая крупная клетка' => 'Розово-серый',
        'Серебристая лиса'            => 'Серебро;Розовый;Бежевый',
        'Грязный бордо'               => 'Бордо;Коричневый',
        'Чёрно-белый'                 => 'Черно-белый',


        ' хаки' => ';Хаки',
    ]
);
