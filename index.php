<?php
require_once 'config.php';

function getMenuItems($pdo, $parentId = null) {
    $stmt = $pdo->prepare("SELECT id, name FROM menu_items WHERE parent_id " .
                         ($parentId === null ? "IS NULL" : "= :parentId") .
                         " ORDER BY id");

    if ($parentId !== null) {
        $stmt->bindParam(':parentId', $parentId, PDO::PARAM_INT);
    }

    $stmt->execute();
    $items = [];

    while ($row = $stmt->fetch()) {
        $childItems = getMenuItems($pdo, $row['id']);
        $hasChildren = !empty($childItems);

        $items[] = [
            'id' => $row['id'],
            'name' => $row['name'],
            'hasChildren' => $hasChildren,
            'items' => $childItems
        ];
    }

    return $items;
}

function renderMenuItem($menuItem) {
    $hasChildren = $menuItem['hasChildren'];
    $itemsHtml = '';

    if ($hasChildren) {
        $itemsHtml = '<div class="list-item__items">';
        foreach ($menuItem['items'] as $childItem) {
            $itemsHtml .= renderMenuItem($childItem);
        }
        $itemsHtml .= '</div>';
    }

    $html = '<div class="list-item" data-parent data-id="' . $menuItem['id'] . '">';
    $html .= '<div class="list-item__inner">';

    if ($hasChildren) {
        $html .= '<img class="list-item__arrow" src="img/chevron-down.png" alt="arrow" data-open>';
    }

    $html .= '<img class="list-item__folder" src="img/folder.png" alt="' . ($hasChildren ? 'folder' : 'file') . '">';
    $html .= '<span>' . htmlspecialchars($menuItem['name']) . '</span>';
    $html .= '</div>';

    if ($hasChildren) {
        $html .= $itemsHtml;
    }

    $html .= '</div>';

    return $html;
}

if (isset($pdo)) {
    try {
        $menuData = getMenuItems($pdo);
        $menuRoot = !empty($menuData) ? $menuData[0] : [
            'id' => 0,
            'name' => 'Каталог товаров',
            'hasChildren' => false,
            'items' => []
        ];
        $menuDataJson = json_encode($menuRoot, JSON_UNESCAPED_UNICODE);
    } catch (Exception $e) {
        $errorMessage = "Ошибка при получении данных из БД: " . $e->getMessage();
    }
} else {
    $errorMessage = "Нет соединения с базой данных. Настройте подключение в файле config.php";
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Меню из БД</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="list-items" id="list-items">
        <?php
        if (isset($errorMessage)) {
            echo '<div class="error-message">' . htmlspecialchars($errorMessage) . '</div>';
        } else {
            echo renderMenuItem($menuRoot);
        }
        ?>
    </div>

    <?php if (!isset($errorMessage)): ?>
    <script>
        const menuData = <?php echo $menuDataJson; ?>;
    </script>
    <script src="script.js"></script>
    <?php endif; ?>
</body>
</html>