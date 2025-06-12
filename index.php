<?php
// Задание 1

$a = 15;
$b = 0;

echo "<h2>Задание 1</h2>";
echo "Переменная \$a = $a<br>";
echo "Переменная \$b = $b<br>";

if ($a >= 0 && $b >= 0) {
    $result = $a - $b;
    echo "Оба числа положительные, их разность: $result";
} elseif ($a < 0 && $b < 0) {
    $result = $a * $b;
    echo "Оба числа отрицательные, их произведение: $result";
} else {
    $result = $a + $b;
    echo "Числа разных знаков, их сумма: $result";
}

echo "<hr>";

// Задание 2

echo "<h2>Задание 2</h2>";

$a = 3;

echo "Начальное значение \$a = $a<br>";
echo "Вывод чисел от $a до 15: ";

switch ($a) {
    case 0: echo "0 ";
    case 1: echo "1 ";
    case 2: echo "2 ";
    case 3: echo "3 ";
    case 4: echo "4 ";
    case 5: echo "5 ";
    case 6: echo "6 ";
    case 7: echo "7 ";
    case 8: echo "8 ";
    case 9: echo "9 ";
    case 10: echo "10 ";
    case 11: echo "11 ";
    case 12: echo "12 ";
    case 13: echo "13 ";
    case 14: echo "14 ";
    case 15: echo "15 ";
        break;
    default:
        echo "Число не входит в диапазон [0..15]";
}

echo "<hr>";

// Задание 3

echo "<h2>Задание 3</h2>";

function addition($arg1, $arg2) {
    return $arg1 + $arg2;
}

function subtraction($arg1, $arg2) {
    return $arg1 - $arg2;
}

function multiplication($arg1, $arg2) {
    return $arg1 * $arg2;
}

function division($arg1, $arg2) {
    if ($arg2 == 0) {
        return "Ошибка: деление на ноль";
    }
    return $arg1 / $arg2;
}

$num1 = 8;
$num2 = 2;

echo "Число 1: $num1<br>";
echo "Число 2: $num2<br>";
echo "Сложение: " . addition($num1, $num2) . "<br>";
echo "Вычитание: " . subtraction($num1, $num2) . "<br>";
echo "Умножение: " . multiplication($num1, $num2) . "<br>";
echo "Деление: " . division($num1, $num2) . "<br>";

echo "<hr>";

// Задание 4

echo "<h2>Задание 4</h2>";

function mathOperation($arg1, $arg2, $operation) {
    switch ($operation) {
        case 'сложение':
            return addition($arg1, $arg2);
        case 'вычитание':
            return subtraction($arg1, $arg2);
        case 'умножение':
            return multiplication($arg1, $arg2);
        case 'деление':
            return division($arg1, $arg2);
        default:
            return "Неизвестная операция";
    }
}

$num1 = 15;
$num2 = 3;

echo "Число 1: $num1<br>";
echo "Число 2: $num2<br>";
echo "Операция «сложение»: " . mathOperation($num1, $num2, 'сложение') . "<br>";
echo "Операция «вычитание»: " . mathOperation($num1, $num2, 'вычитание') . "<br>";
echo "Операция «умножение»: " . mathOperation($num1, $num2, 'умножение') . "<br>";
echo "Операция «деление»: " . mathOperation($num1, $num2, 'деление') . "<br>";

echo "<hr>";

// Задание 5

echo "<h2>Задание 5</h2>";

echo "Функция date(): " . date("Y") . "<br>";

$date_array = getdate();
echo "Функция getdate(): " . $date_array['year'] . "<br>";

$datetime = new DateTime();
echo "Класс DateTime: " . $datetime->format('Y') . "<br>";

echo "<hr>";

// Задание 6

echo "<h2>Задание 6</h2>";

function power($val, $pow) {
    if ($pow == 0) {
        return 1;
    }

    if ($pow < 0) {
        return 1 / power($val, -$pow);
    }

    return $val * power($val, $pow - 1);
}

$base = 2;
$exponents = [-1, 0, 1, 2, 3];

echo "Основание: $base<br>";
foreach ($exponents as $exp) {
    echo "$base в степени $exp = " . power($base, $exp) . "<br>";
}
?>