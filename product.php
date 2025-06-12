<?php
$host = 'localhost';
$dbname = 'product_catalog';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        header('Location: index.php');
        exit;
    }

    $product_id = $_GET['id'];

    $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
    $stmt->execute([$product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        header('Location: index.php');
        exit;
    }

    $stmt = $pdo->prepare('SELECT * FROM reviews WHERE product_id = ? ORDER BY created_at DESC');
    $stmt->execute([$product_id]);
    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Ошибка подключения к БД: " . $e->getMessage();
    die();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_review'])) {
    $author = trim($_POST['author']);
    $rating = (int)$_POST['rating'];
    $comment = trim($_POST['comment']);

    $errors = [];
    if (empty($author)) {
        $errors[] = 'Пожалуйста, укажите ваше имя';
    }
    if ($rating < 1 || $rating > 5) {
        $errors[] = 'Оценка должна быть от 1 до 5';
    }
    if (empty($comment)) {
        $errors[] = 'Пожалуйста, напишите текст отзыва';
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare('INSERT INTO reviews (product_id, author, rating, comment) VALUES (?, ?, ?, ?)');
        if ($stmt->execute([$product_id, $author, $rating, $comment])) {
            header("Location: product.php?id=$product_id&success=1");
            exit;
        } else {
            $errors[] = 'Произошла ошибка при сохранении отзыва';
        }
    }
}

$avgRating = 0;
$reviewsCount = count($reviews);
if ($reviewsCount > 0) {
    $totalRating = 0;
    foreach ($reviews as $review) {
        $totalRating += $review['rating'];
    }
    $avgRating = round($totalRating / $reviewsCount, 1);
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product['name']; ?> — Каталог товаров</title>
    <link rel="stylesheet" href="product_style.css">
</head>
<body>
    <div class="container">
        <a href="index.php" class="back-btn">← Назад к каталогу</a>

        <div class="product-details">
            <img src="<?php echo $product['image_path']; ?>" alt="<?php echo $product['name']; ?>" class="product-image">

            <div class="product-info">
                <h1 class="product-name"><?php echo $product['name']; ?></h1>
                <div class="product-price"><?php echo number_format($product['price'], 0, ',', ' '); ?> ₽</div>

                <div class="rating-summary">
                    <?php if ($reviewsCount > 0): ?>
                        <div class="stars">
                            <?php
                            for ($i = 1; $i <= 5; $i++) {
                                if ($i <= $avgRating) {
                                    echo '★';
                                } else {
                                    echo '☆';
                                }
                            }
                            ?>
                            <span style="color:#333;"><?php echo $avgRating; ?>/5</span>
                        </div>
                        <span>(<?php echo $reviewsCount; ?> <?php echo getReviewWord($reviewsCount); ?>)</span>
                    <?php else: ?>
                        <span>Нет отзывов</span>
                    <?php endif; ?>
                </div>

                <div class="product-description">
                    <?php echo nl2br($product['description']); ?>
                </div>
            </div>
        </div>

        <div class="reviews-section">
            <h2>Отзывы о товаре</h2>

            <?php if (isset($_GET['success'])): ?>
                <div class="success">Ваш отзыв успешно добавлен!</div>
            <?php endif; ?>

            <div class="review-list">
                <?php if ($reviews): ?>
                    <?php foreach ($reviews as $review): ?>
                        <div class="review">
                            <div class="review-header">
                                <span class="review-author"><?php echo htmlspecialchars($review['author']); ?></span>
                                <span class="review-date"><?php echo date('d.m.Y', strtotime($review['created_at'])); ?></span>
                            </div>
                            <div class="stars">
                                <?php
                                for ($i = 1; $i <= 5; $i++) {
                                    echo ($i <= $review['rating']) ? '★' : '☆';
                                }
                                ?>
                            </div>
                            <div class="review-comment"><?php echo nl2br(htmlspecialchars($review['comment'])); ?></div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>У этого товара пока нет отзывов. Будьте первым!</p>
                <?php endif; ?>
            </div>

            <div class="review-form">
                <h3>Оставить отзыв</h3>

                <?php if (!empty($errors)): ?>
                    <div class="errors">
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="post">
                    <div class="form-group">
                        <label for="author">Ваше имя:</label>
                        <input type="text" name="author" id="author" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Оценка:</label>
                        <div class="rating-select">
                            <input type="radio" name="rating" value="5" id="star5" required>
                            <label for="star5"></label>
                            <input type="radio" name="rating" value="4" id="star4">
                            <label for="star4"></label>
                            <input type="radio" name="rating" value="3" id="star3">
                            <label for="star3"></label>
                            <input type="radio" name="rating" value="2" id="star2">
                            <label for="star2"></label>
                            <input type="radio" name="rating" value="1" id="star1">
                            <label for="star1"></label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="comment">Комментарий:</label>
                        <textarea name="comment" id="comment" class="form-control" required></textarea>
                    </div>

                    <button type="submit" name="submit_review" class="btn">Отправить отзыв</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

<?php
function getReviewWord($count) {
    $lastDigit = $count % 10;
    $lastTwoDigits = $count % 100;

    if ($lastDigit == 1 && $lastTwoDigits != 11) {
        return 'отзыв';
    } elseif (($lastDigit >= 2 && $lastDigit <= 4) && !($lastTwoDigits >= 12 && $lastTwoDigits <= 14)) {
        return 'отзыва';
    } else {
        return 'отзывов';
    }
}
?>