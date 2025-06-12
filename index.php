<?php
$pageTitle = "Главная страница";
$pageHeading = "Добро пожаловать!";
$currentYear = date('Y');

function getCurrentTime(): string {
    $hour = (int)date('H');
    $minute = (int)date('i');

    $hourStr = $hour;
    if ($hour === 1 || $hour === 21) {
        $hourStr .= " час";
    } elseif (($hour >= 2 && $hour <= 4) || ($hour >= 22 && $hour <= 24)) {
        $hourStr .= " часа";
    } else {
        $hourStr .= " часов";
    }

    $minuteStr = $minute;
    if ($minute % 10 === 1 && $minute !== 11) {
        $minuteStr .= " минута";
    } elseif (($minute % 10 >= 2 && $minute % 10 <= 4) && ($minute < 10 || $minute > 20)) {
        $minuteStr .= " минуты";
    } else {
        $minuteStr .= " минут";
    }

    return "Текущее время: $hourStr $minuteStr";
}

$currentTimeStr = getCurrentTime();
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="/src/assets/styles/style.css">
</head>
<body>
    <header>
        <h1><?php echo $pageHeading; ?></h1>
    </header>

    <main>
        <div class="time-container">
            <p><?php echo $currentTimeStr; ?></p>
        </div>
    </main>

    <footer>
        <p>&copy; <?php echo $currentYear; ?> Все права защищены</p>
    </footer>

    <script src="/src/index.js"></script>
</body>
</html>
