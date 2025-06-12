<?php
// Задание 1

echo "<h2>Задание 1</h2>";

function printNumbers() {
    $i = 0;
    do {
        if ($i === 0) {
            echo "$i – это ноль.<br>";
        } elseif ($i % 2 === 0) {
            echo "$i – чётное число.<br>";
        } else {
            echo "$i – нечётное число.<br>";
        }
        $i++;
    } while ($i <= 10);
}

printNumbers();

// Задание 2

echo "<h2>Задание 2</h2>";

$regions = [
    'Московская область' => ['Москва', 'Зеленоград', 'Балашиха', 'Химки', 'Подольск'],
    'Ленинградская область' => ['Санкт-Петербург', 'Гатчина', 'Кириши', 'Кронштадт', 'Выборг'],
    'Рязанская область' => ['Рязань', 'Ряжск', 'Скопин', 'Сасово', 'Михайлово'],
    'Калужская область' => ['Калуга', 'Жуков', 'Белоусово', 'Козельск', 'Киров']
];

foreach ($regions as $region => $cities) {
    echo "<b>$region:</b><br>";
    echo implode(', ', $cities) . ".<br>";
}

// Задание 3

echo "<h2>Задание 3</h2>";

$translitMap = [
    'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd',
    'е' => 'e', 'ё' => 'yo', 'ж' => 'zh', 'з' => 'z', 'и' => 'i',
    'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n',
    'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't',
    'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'ts', 'ч' => 'ch',
    'ш' => 'sh', 'щ' => 'sch', 'ъ' => '', 'ы' => 'y', 'ь' => '',
    'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
    'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D',
    'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh', 'З' => 'Z', 'И' => 'I',
    'Й' => 'Y', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N',
    'О' => 'O', 'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T',
    'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'Ts', 'Ч' => 'Ch',
    'Ш' => 'Sh', 'Щ' => 'Sch', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '',
    'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya'
];

function transliterate($text, $translitMap) {
    $result = '';
    $chars = preg_split('//u', $text, -1, PREG_SPLIT_NO_EMPTY);

    foreach ($chars as $char) {
        $result .= isset($translitMap[$char]) ? $translitMap[$char] : $char;
    }

    return $result;
}

$testText = "Тест транслитерации.";
echo "Исходный текст: $testText<br>";
echo "Транслитерация: " . transliterate($testText, $translitMap) . "<br>";

// Задание 4

echo "<h2>Задание 4</h2>";

$menu = [
    [
        'title' => 'Главная',
        'link' => '/',
        'submenu' => []
    ],
    [
        'title' => 'Каталог',
        'link' => '/catalog',
        'submenu' => [
            [
                'title' => 'Категория 1',
                'link' => '/catalog/category1',
                'submenu' => []
            ],
            [
                'title' => 'Категория 2',
                'link' => '/catalog/category2',
                'submenu' => [
                    [
                        'title' => 'Подкатегория 2.1',
                        'link' => '/catalog/category2/subcategory1',
                        'submenu' => []
                    ],
                    [
                        'title' => 'Подкатегория 2.2',
                        'link' => '/catalog/category2/subcategory2',
                        'submenu' => []
                    ]
                ]
            ]
        ]
    ],
    [
        'title' => 'Контакты',
        'link' => '/contacts',
        'submenu' => []
    ],
    [
        'title' => 'О нас',
        'link' => '/about',
        'submenu' => [
            [
                'title' => 'История',
                'link' => '/about/history',
                'submenu' => []
            ],
            [
                'title' => 'Команда',
                'link' => '/about/team',
                'submenu' => []
            ]
        ]
    ]
];

function renderMenu($menuItems) {
    echo '<ul>';
    foreach ($menuItems as $item) {
        echo '<li>';
        echo '<a href="' . $item['link'] . '">' . $item['title'] . '</a>';

        if (!empty($item['submenu'])) {
            renderMenu($item['submenu']);
        }

        echo '</li>';
    }
    echo '</ul>';
}

renderMenu($menu);

// Задание 6

echo "<h2>Задание 6</h2>";

foreach ($regions as $region => $cities) {
    echo "<b>$region:</b><br>";
    $kCities = array_filter($cities, function($city) {
        return preg_match('/^К/u', $city);
    });

    if (!empty($kCities)) {
        echo implode(', ', $kCities) . ".<br>";
    } else {
        echo "Нет городов на букву «К».<br>";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Задания</title>
    <link rel="stylesheet" href="/src/assets/styles/style.css">
</head>
<body></body>
</html>