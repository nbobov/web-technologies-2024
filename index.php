<?php
$host = 'localhost';
$dbname = 'product_catalog';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query('SELECT * FROM products ORDER BY id DESC');
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Ошибка подключения к БД: " . $e->getMessage();
    die();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Каталог товаров</title>
    <link rel="stylesheet" href="catalog_style.css">
</head>
<body>
    <div class="container">
        <h1>Каталог товаров</h1>

        <div class="products">
            <?php foreach ($products as $product): ?>
                <div class="product-card" onclick="location.href='product.php?id=<?php echo $product['id']; ?>'">
                    <img src="<?php echo $product['image_path']; ?>" alt="<?php echo $product['name']; ?>" class="product-image">
                    <div class="product-info">
                        <h2 class="product-name"><?php echo $product['name']; ?></h2>
                        <div class="product-price"><?php echo number_format($product['price'], 0, ',', ' '); ?> ₽</div>
                        <p class="product-description"><?php echo $product['description']; ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>